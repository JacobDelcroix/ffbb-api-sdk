<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Requests\Directus;

/**
 * Construit les paramètres de requête Directus comme le fait le SDK Python.
 *
 * `fields` et `sort` sont envoyés en liste séparée par des virgules,
 * forme native de Directus (équivalente à fields[]=a&fields[]=b).
 */
final class DirectusQuery
{
    /**
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @param  array<string, string>  $extra
     * @return array<string, string>
     */
    public static function build(
        ?array $fields = null,
        ?int $limit = null,
        ?string $filter = null,
        string|array|null $sort = null,
        ?int $offset = null,
        ?string $search = null,
        array $extra = [],
    ): array {
        $query = [];

        if ($limit !== null) {
            $query['limit'] = (string) $limit;
        }

        if ($fields !== null && $fields !== []) {
            $query['fields'] = implode(',', $fields);
        }

        if ($filter !== null && $filter !== '') {
            $query['filter'] = $filter;
        }

        if ($sort !== null && $sort !== [] && $sort !== '') {
            $query['sort'] = is_array($sort) ? implode(',', $sort) : $sort;
        }

        // Comme en Python : un offset de 0 n'est pas envoyé.
        if ($offset !== null && $offset > 0) {
            $query['offset'] = (string) $offset;
        }

        if ($search !== null && $search !== '') {
            $query['search'] = $search;
        }

        return array_merge($query, $extra);
    }
}
