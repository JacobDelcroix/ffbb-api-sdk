<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbnational_rss_ffbbnational_categories` (schéma OpenAPI ItemsFfbbnationalRssFfbbnationalCategories).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class RssFfbbnationalCategoriesItem
{
    public const string COLLECTION = 'ffbbnational_rss_ffbbnational_categories';

    public function __construct(
        public CategoriesItem|string|int|null $ffbbnational_categories_id = null,
        public RssItem|string|int|null $ffbbnational_rss_id = null,
        public ?int $id = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            ffbbnational_categories_id: Cast::relation($data['ffbbnational_categories_id'] ?? null, CategoriesItem::class),
            ffbbnational_rss_id: Cast::relation($data['ffbbnational_rss_id'] ?? null, RssItem::class),
            id: Cast::int($data['id'] ?? null),
            raw: $data,
        );
    }

    /**
     * @param  iterable<array<string, mixed>>  $items
     * @return list<self>
     */
    public static function collect(iterable $items): array
    {
        $out = [];

        foreach ($items as $item) {
            $out[] = self::fromArray($item);
        }

        return $out;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->raw;
    }
}
