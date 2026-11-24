<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Search;

/**
 * Une sous-requête du POST multi-search (miroir de MultiSearchQuery et de ses sous-classes).
 */
final readonly class MultiSearchQuery
{
    /**
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @param  list<string>|null  $facets  null = facettes par défaut de l'index
     */
    public function __construct(
        public Index $index,
        public ?string $q = null,
        public ?int $limit = 10,
        public ?int $offset = 0,
        public ?array $filter = null,
        public ?array $sort = null,
        public ?array $facets = null,
    ) {}

    /**
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     */
    public static function for(Index $index, ?string $q, ?int $limit = 10, ?array $filter = null, ?array $sort = null): self
    {
        return new self($index, $q, $limit, 0, $filter, $sort);
    }

    public function withPage(int $offset, int $limit): self
    {
        return new self($this->index, $this->q, $limit, $offset, $this->filter, $this->sort, $this->facets);
    }

    public function lowerQ(): ?string
    {
        return $this->q !== null && $this->q !== '' ? mb_strtolower($this->q) : null;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = ['indexUid' => $this->index->value];

        if ($this->q !== null) {
            $payload['q'] = $this->q;
        }

        $facets = $this->facets ?? $this->index->facets();

        if ($facets !== null) {
            $payload['facets'] = $facets;
        }

        if ($this->limit !== null) {
            $payload['limit'] = $this->limit;
        }

        if ($this->offset !== null) {
            $payload['offset'] = $this->offset;
        }

        if ($this->filter !== null) {
            $payload['filter'] = $this->filter;
        }

        if ($this->sort !== null) {
            $payload['sort'] = $this->sort;
        }

        return $payload;
    }

    /**
     * Génère une requête par index pour la recherche universelle
     * (miroir de multi_search_query_helper.generate_queries).
     *
     * @return list<self>
     */
    public static function forAllIndexes(?string $q, ?int $limit = 1): array
    {
        return array_map(
            static fn (Index $index): self => self::for($index, $q, $limit),
            Index::cases(),
        );
    }
}
