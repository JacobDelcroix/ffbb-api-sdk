<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

/**
 * Résultat d'une recherche Meilisearch sur un index (miroir de MultiSearchResult).
 *
 * @template THit of object
 */
final readonly class SearchResult
{
    /**
     * @param  list<THit>  $hits
     * @param  array<string, array<string, int>>  $facetDistribution  facette → valeur → nombre de documents
     * @param  array<string, array{min: float|int, max: float|int}>  $facetStats  facette numérique → bornes
     * @param  array<string, mixed>  $raw  réponse brute complète
     */
    public function __construct(
        public ?string $indexUid = null,
        public array $hits = [],
        public ?string $query = null,
        public ?int $processingTimeMs = null,
        public ?int $limit = null,
        public ?int $offset = null,
        public ?int $estimatedTotalHits = null,
        public array $facetDistribution = [],
        public array $facetStats = [],
        public array $raw = [],
    ) {}

    /**
     * @template T of object
     *
     * @param  array<string, mixed>  $data
     * @param  class-string<T>  $hitClass
     * @return self<T>
     */
    public static function fromArray(array $data, string $hitClass): self
    {
        $hits = [];

        foreach ((array) ($data['hits'] ?? []) as $hit) {
            if (is_array($hit)) {
                $hits[] = $hitClass::fromArray($hit);
            }
        }

        $int = static fn (mixed $v): ?int => is_int($v) ? $v : (is_numeric($v) ? (int) $v : null);

        return new self(
            indexUid: is_string($data['indexUid'] ?? null) ? $data['indexUid'] : null,
            hits: $hits,
            query: is_string($data['query'] ?? null) ? $data['query'] : null,
            processingTimeMs: $int($data['processingTimeMs'] ?? null),
            limit: $int($data['limit'] ?? null),
            offset: $int($data['offset'] ?? null),
            estimatedTotalHits: $int($data['estimatedTotalHits'] ?? null),
            facetDistribution: is_array($data['facetDistribution'] ?? null) ? $data['facetDistribution'] : [],
            facetStats: is_array($data['facetStats'] ?? null) ? $data['facetStats'] : [],
            raw: $data,
        );
    }

    /**
     * Premier hit, ou null si la recherche n'a rien trouvé.
     *
     * @return THit|null
     */
    public function first(): ?object
    {
        return $this->hits[0] ?? null;
    }

    public function isEmpty(): bool
    {
        return $this->hits === [];
    }

    public function count(): int
    {
        return count($this->hits);
    }

    /**
     * Comptages d'une facette, ex. facet('type') → ['Club' => 4210, 'Comité' => 101].
     *
     * @return array<string, int>
     */
    public function facet(string $name): array
    {
        return $this->facetDistribution[$name] ?? [];
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->raw;
    }
}
