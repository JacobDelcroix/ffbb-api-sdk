<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Search;

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Connectors\MeilisearchConnector;
use CoachBasket\Ffbb\Requests\Meilisearch\MultiSearch;
use CoachBasket\Ffbb\Requests\Meilisearch\SearchIndex;
use CoachBasket\Ffbb\Support\Json;
use CoachBasket\Ffbb\Support\Transport;
use Psr\SimpleCache\CacheInterface;

/**
 * Exécution des recherches Meilisearch, miroir de MeilisearchClient
 * + MeilisearchClientExtension :
 *
 * - multiSearch()                 : POST multi-search avec cache applicatif (TTL 300 s) ;
 * - smartMultiSearch()            : + filtrage des hits côté client (HitMatcher) ;
 * - recursiveSmartMultiSearch()   : + récupération de toutes les pages jusqu'à estimatedTotalHits.
 *
 * Un résultat est le tableau brut renvoyé par Meilisearch pour une sous-requête :
 * indexUid, hits, query, limit, offset, estimatedTotalHits, facetDistribution, facetStats…
 */
final class MeilisearchSearcher
{
    public function __construct(
        private readonly MeilisearchConnector $connector,
        private readonly ?CacheInterface $cache = null,
        private readonly int $cacheTtl = Config::MEILISEARCH_CACHE_TTL,
    ) {}

    public function connector(): MeilisearchConnector
    {
        return $this->connector;
    }

    /**
     * @param  list<MultiSearchQuery>  $queries
     * @return list<array<string, mixed>>|null
     */
    public function multiSearch(array $queries): ?array
    {
        $key = 'coach-basket.ffbb.meili.'.hash('sha256', Json::encode(array_map(
            static fn (MultiSearchQuery $q): array => $q->toArray(),
            $queries,
        )));

        $cached = $this->cache?->get($key);

        if (is_array($cached)) {
            return $cached;
        }

        $response = Transport::guard(fn () => $this->connector->send(new MultiSearch($queries)));
        $payload = Json::decode($response->body());

        if (! is_array($payload) || ! isset($payload['results']) || ! is_array($payload['results'])) {
            return null;
        }

        /** @var list<array<string, mixed>> $results */
        $results = array_values(array_filter($payload['results'], 'is_array'));

        $this->cache?->set($key, $results, $this->cacheTtl);

        return $results;
    }

    /**
     * @param  list<MultiSearchQuery>  $queries
     * @return list<array<string, mixed>>|null
     */
    public function smartMultiSearch(array $queries): ?array
    {
        $results = $this->multiSearch($queries);

        if ($results === null) {
            return null;
        }

        foreach ($results as $i => $result) {
            if (isset($queries[$i]) && $queries[$i]->q !== null && $queries[$i]->q !== '') {
                $results[$i] = HitMatcher::filterResult($queries[$i], $result);
            }
        }

        return $results;
    }

    /**
     * Récupère toutes les pages restantes de chaque sous-requête, par pages de 1000,
     * groupées par lots de 10 sous-requêtes (miroir de recursive_smart_multi_search).
     *
     * @param  list<MultiSearchQuery>  $queries
     * @return list<array<string, mixed>>|null
     */
    public function recursiveSmartMultiSearch(array $queries): ?array
    {
        $results = $this->smartMultiSearch($queries);

        if ($results === null || $queries === []) {
            return $results;
        }

        $jobs = [];

        foreach ($queries as $i => $query) {
            $result = $results[$i] ?? null;

            if (! is_array($result) || ! is_array($result['hits'] ?? null) || ! is_int($result['estimatedTotalHits'] ?? null)) {
                continue;
            }

            $ceiling = $result['estimatedTotalHits'];
            $offset = ($query->offset ?? 0) + count($result['hits']);

            while ($offset < $ceiling) {
                $take = min(Config::MEILISEARCH_PAGE_SIZE_CAP, $ceiling - $offset);
                $jobs[] = [$i, $query->withPage($offset, $take)];
                $offset += $take;
            }
        }

        foreach (array_chunk($jobs, Config::MEILISEARCH_BATCH_SIZE) as $batch) {
            $pages = $this->smartMultiSearch(array_map(static fn (array $job): MultiSearchQuery => $job[1], $batch));

            if ($pages === null) {
                continue;
            }

            foreach ($batch as $k => [$originalIndex]) {
                $pageHits = $pages[$k]['hits'] ?? null;

                if (is_array($pageHits) && is_array($results[$originalIndex]['hits'] ?? null)) {
                    array_push($results[$originalIndex]['hits'], ...$pageHits);
                }
            }
        }

        return $results;
    }

    /**
     * Alias historique (recursive_multi_search).
     *
     * @param  list<MultiSearchQuery>  $queries
     * @return list<array<string, mixed>>|null
     */
    public function recursiveMultiSearch(array $queries): ?array
    {
        return $this->recursiveSmartMultiSearch($queries);
    }

    /**
     * Recherche exacte sur un index (POST indexes/{index}/search), utilisée par les fallbacks.
     *
     * @param  array<string, mixed>  $payload
     * @return list<array<string, mixed>>
     */
    public function searchIndex(Index $index, array $payload): array
    {
        $response = Transport::guard(fn () => $this->connector->send(new SearchIndex($index->value, $payload)));
        $data = Json::decode($response->body());
        $hits = is_array($data) ? ($data['hits'] ?? null) : null;

        return is_array($hits) ? array_values(array_filter($hits, 'is_array')) : [];
    }
}
