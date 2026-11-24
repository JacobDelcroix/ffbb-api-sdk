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

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [
        'ffbbnational_categories' => 'ffbbnational_categories_id',
        'ffbbnational_rss' => 'ffbbnational_rss_id',
    ];

    public function __construct(
        /** Champ Directus : ffbbnational_categories_id */
        public ?CategoriesItem $ffbbnational_categories = null,
        /** Champ Directus : ffbbnational_rss_id */
        public ?RssItem $ffbbnational_rss = null,
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
            ffbbnational_categories: Cast::related($data['ffbbnational_categories_id'] ?? null, CategoriesItem::class),
            ffbbnational_rss: Cast::related($data['ffbbnational_rss_id'] ?? null, RssItem::class),
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
            if (is_array($item)) {
                $out[] = self::fromArray($item);
            }
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
