<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Concerns;

use CoachBasket\Ffbb\Connectors\ApiFfbbConnector;
use CoachBasket\Ffbb\Exceptions\FfbbNotFoundException;
use CoachBasket\Ffbb\Requests\Directus\GetItem;
use CoachBasket\Ffbb\Requests\Directus\ListItems;
use CoachBasket\Ffbb\Support\Json;
use CoachBasket\Ffbb\Support\Transport;
use Saloon\Http\Request;

/**
 * Accès générique aux collections Directus (miroir de GettersMixin._get/_list_directus_item(s)).
 *
 * @property-read ApiFfbbConnector $api
 */
trait InteractsWithDirectus
{
    /**
     * Envoie une requête Directus et renvoie le JSON décodé.
     */
    protected function sendDirectus(Request $request): mixed
    {
        $response = Transport::guard(fn () => $this->api->send($request));

        return Json::decode($response->body());
    }

    /**
     * Un élément d'une collection, ou null s'il n'existe pas (404).
     *
     * @param  list<string>|null  $fields
     * @param  array<string, string>  $extraQuery
     * @return array<string, mixed>|null
     */
    protected function getDirectusItem(string $endpoint, string|int $id, ?array $fields = null, array $extraQuery = [], ?float $timeout = null): ?array
    {
        try {
            $data = Json::unwrapData($this->sendDirectus(new GetItem($endpoint, $id, $fields, $extraQuery, $timeout)));
        } catch (FfbbNotFoundException) {
            return null;
        }

        return is_array($data) && ! array_is_list($data) ? $data : null;
    }

    /**
     * Une page d'une collection ([] si la collection est introuvable).
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @param  array<string, string>  $extraQuery
     * @return list<array<string, mixed>>
     */
    protected function listDirectusItems(
        string $endpoint,
        ?int $limit = 10,
        ?array $fields = null,
        ?string $filter = null,
        string|array|null $sort = null,
        ?int $offset = null,
        ?string $search = null,
        array $extraQuery = [],
        ?float $timeout = null,
    ): array {
        try {
            $data = Json::unwrapData($this->sendDirectus(
                new ListItems($endpoint, $limit, $fields, $filter, $sort, $offset, $search, $extraQuery, $timeout),
            ));
        } catch (FfbbNotFoundException) {
            return [];
        }

        return is_array($data) && array_is_list($data) ? self::onlyItems($data) : [];
    }

    /**
     * Toutes les pages d'une collection (miroir de _list_all_directus_items_async) :
     * au plus 20 pages de $pageSize éléments, et $maxItems éléments au total.
     *
     * @param  list<string>|null  $sort
     * @return list<array<string, mixed>>
     */
    protected function listAllDirectusItems(
        string $endpoint,
        ?string $filter = null,
        ?array $sort = null,
        ?string $search = null,
        int $pageSize = 100,
        int $maxItems = 10000,
    ): array {
        $results = $this->listDirectusItems($endpoint, $pageSize, null, $filter, $sort, 0, $search);

        if ($results === [] || count($results) < $pageSize || count($results) >= $maxItems) {
            return array_slice($results, 0, $maxItems);
        }

        $totalPages = min(intdiv($maxItems + $pageSize - 1, $pageSize), 20);

        for ($page = 1; $page < $totalPages; $page++) {
            $batch = $this->listDirectusItems($endpoint, $pageSize, null, $filter, $sort, $page * $pageSize, $search);

            if ($batch === []) {
                break;
            }

            array_push($results, ...$batch);

            if (count($batch) < $pageSize) {
                break;
            }
        }

        return array_slice($results, 0, $maxItems);
    }

    /**
     * Itération paresseuse page par page (miroir de _aiter_all_directus_items).
     *
     * @param  list<string>|null  $sort
     * @return \Generator<int, array<string, mixed>>
     */
    protected function iterAllDirectusItems(
        string $endpoint,
        ?string $filter = null,
        ?array $sort = null,
        ?string $search = null,
        int $pageSize = 100,
        int $maxItems = 10000,
    ): \Generator {
        $offset = 0;
        $yielded = 0;

        while ($yielded < $maxItems) {
            $limit = min($pageSize, $maxItems - $yielded);
            $batch = $this->listDirectusItems($endpoint, $limit, null, $filter, $sort, $offset, $search);

            if ($batch === []) {
                return;
            }

            foreach ($batch as $item) {
                yield $item;

                if (++$yielded >= $maxItems) {
                    return;
                }
            }

            if (count($batch) < $limit) {
                return;
            }

            $offset += count($batch);
        }
    }

    /**
     * @param  array<mixed>  $data
     * @return list<array<string, mixed>>
     */
    private static function onlyItems(array $data): array
    {
        return array_values(array_filter($data, static fn (mixed $item): bool => is_array($item) && $item !== []));
    }
}
