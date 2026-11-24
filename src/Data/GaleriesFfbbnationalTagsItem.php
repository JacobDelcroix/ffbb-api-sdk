<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbnational_galeries_ffbbnational_tags` (schéma OpenAPI ItemsFfbbnationalGaleriesFfbbnationalTags).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class GaleriesFfbbnationalTagsItem
{
    public const string COLLECTION = 'ffbbnational_galeries_ffbbnational_tags';

    public function __construct(
        public ?GaleriesItem $ffbbnational_galeries_id = null,
        public ?TagsItem $ffbbnational_tags_id = null,
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
            ffbbnational_galeries_id: Cast::related($data['ffbbnational_galeries_id'] ?? null, GaleriesItem::class),
            ffbbnational_tags_id: Cast::related($data['ffbbnational_tags_id'] ?? null, TagsItem::class),
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
