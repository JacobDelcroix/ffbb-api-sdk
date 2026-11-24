<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb;

use CoachBasket\Ffbb\Auth\TokenManager;
use CoachBasket\Ffbb\Concerns\InteractsWithDirectus;
use CoachBasket\Ffbb\Concerns\ListsResources;
use CoachBasket\Ffbb\Concerns\ManagesCompetitions;
use CoachBasket\Ffbb\Concerns\ManagesExternalResources;
use CoachBasket\Ffbb\Concerns\ManagesOrganismes;
use CoachBasket\Ffbb\Concerns\ManagesResources;
use CoachBasket\Ffbb\Concerns\SearchesMeilisearch;
use CoachBasket\Ffbb\Connectors\ApiFfbbConnector;
use CoachBasket\Ffbb\Connectors\MeilisearchConnector;
use CoachBasket\Ffbb\Directus\QueryBuilder;
use CoachBasket\Ffbb\Fallback\MeilisearchFallback;
use CoachBasket\Ffbb\Fallback\PouleCompetitionRegistry;
use CoachBasket\Ffbb\Search\MeilisearchSearcher;
use CoachBasket\Ffbb\Support\ArrayCache;
use CoachBasket\Ffbb\Support\Validator;
use Psr\SimpleCache\CacheInterface;
use Saloon\Http\Faking\MockClient;

/**
 * Point d'entrée du SDK : façade unique sur Directus (api.ffbb.com) et Meilisearch,
 * miroir de FFBBDataClient (ffbb_data_client).
 *
 *     $ffbb = FfbbDataClient::create();
 *     $club = $ffbb->searchOrganismes('Ostrevent')['hits'][0];
 *     $equipes = $ffbb->getEquipes((int) $club['id']);
 */
final class FfbbDataClient
{
    use InteractsWithDirectus;
    use ListsResources;
    use ManagesCompetitions;
    use ManagesExternalResources;
    use ManagesOrganismes;
    use ManagesResources;
    use SearchesMeilisearch;

    public readonly MeilisearchFallback $fallback;

    public function __construct(
        public readonly ApiFfbbConnector $api,
        public readonly MeilisearchSearcher $search,
        public readonly PouleCompetitionRegistry $registry = new PouleCompetitionRegistry,
    ) {
        $this->fallback = new MeilisearchFallback($this->search, $this->registry);
    }

    /**
     * Crée un client prêt à l'emploi.
     *
     * Les jetons manquants sont résolus par TokenManager (env → cache → items/configuration → repli).
     *
     * @param  CacheInterface|null  $cache  cache PSR-16 (Laravel : Cache::store()). Par défaut : mémoire du process.
     * @param  int|null  $cacheTtl  TTL du cache HTTP Directus en secondes (1800 comme en Python, null = désactivé)
     */
    public static function create(
        ?string $meilisearchBearerToken = null,
        ?string $apiBearerToken = null,
        ?CacheInterface $cache = null,
        ?int $cacheTtl = 1800,
        ?string $apiBaseUrl = null,
        ?string $meilisearchBaseUrl = null,
    ): self {
        $cache ??= new ArrayCache;

        $tokens = new TokenManager($cache);

        if ($apiBearerToken !== null || $meilisearchBearerToken !== null) {
            $resolved = ($apiBearerToken === null || $meilisearchBearerToken === null) ? $tokens->getTokens() : null;

            $tokens = TokenManager::withTokens(
                Validator::token($apiBearerToken ?? $resolved?->apiToken, 'api_bearer_token'),
                Validator::token($meilisearchBearerToken ?? $resolved?->meilisearchToken, 'meilisearch_bearer_token'),
            );
        }

        return new self(
            new ApiFfbbConnector($tokens, $apiBaseUrl, $cache, $cacheTtl),
            new MeilisearchSearcher(new MeilisearchConnector($tokens, $meilisearchBaseUrl), $cache),
        );
    }

    /**
     * Branche un MockClient Saloon sur les deux connectors (tests).
     */
    public function withMockClient(MockClient $mockClient): self
    {
        $this->api->withMockClient($mockClient);
        $this->search->connector()->withMockClient($mockClient);
        $this->api->tokens->withMockClient($mockClient);

        return $this;
    }

    /**
     * Query builder Directus complet sur n'importe quelle collection.
     *
     *     $ffbb->directus('ffbbserver_rencontres')->where('idPoule', '_eq', 123)->sort('-date_rencontre')->get();
     */
    public function directus(string $collection): QueryBuilder
    {
        return new QueryBuilder($this->api, $collection);
    }

    /**
     * Pré-charge un organisme et ses équipes dans le cache.
     */
    public function warmOrganismeCache(int|string $organismeId): void
    {
        $this->getOrganisme($organismeId);
        $this->getEquipes($organismeId);
    }

    /**
     * Pré-charge une compétition et toutes ses poules dans le cache.
     */
    public function warmCompetitionCache(int|string $competitionId): void
    {
        $competition = $this->getCompetition($competitionId);

        if ($competition === null) {
            return;
        }

        $pouleIds = [];

        foreach ((array) ($competition['poules'] ?? []) as $poule) {
            if (is_array($poule) && ! empty($poule['id'])) {
                $pouleIds[(int) $poule['id']] = true;
            }
        }

        foreach ((array) ($competition['phases'] ?? []) as $phase) {
            foreach ((array) (is_array($phase) ? ($phase['poules'] ?? []) : []) as $poule) {
                if (is_array($poule) && ! empty($poule['id'])) {
                    $pouleIds[(int) $poule['id']] = true;
                }
            }
        }

        $ids = array_keys($pouleIds);
        sort($ids);

        foreach ($ids as $pouleId) {
            $this->getPoule($pouleId);
        }
    }

    /**
     * Rien à fermer côté PHP (pas de session persistante) ; présent pour la parité d'API.
     */
    public function close(): void {}
}
