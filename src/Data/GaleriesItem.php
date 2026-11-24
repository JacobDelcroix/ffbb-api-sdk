<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbnational_galeries` (schéma OpenAPI ItemsFfbbnationalGaleries).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class GaleriesItem
{
    public const string COLLECTION = 'ffbbnational_galeries';

    public function __construct(
        public mixed $cover = null,
        public ?string $creator = null,
        public ?string $date = null,
        public ?string $date_created = null,
        public ?string $date_updated = null,
        public ?int $id = null,
        /** @var list<GaleriesFilesItem|string|int>|null */
        public ?array $images = null,
        public ?string $surtitle = null,
        /** @var list<GaleriesFfbbnationalTagsItem|string|int>|null */
        public ?array $tags = null,
        public ?string $title = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            cover: $data['cover'] ?? null,
            creator: Cast::string($data['creator'] ?? null),
            date: Cast::string($data['date'] ?? null),
            date_created: Cast::string($data['date_created'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            id: Cast::int($data['id'] ?? null),
            images: Cast::relations($data['images'] ?? null, GaleriesFilesItem::class),
            surtitle: Cast::string($data['surtitle'] ?? null),
            tags: Cast::relations($data['tags'] ?? null, GaleriesFfbbnationalTagsItem::class),
            title: Cast::string($data['title'] ?? null),
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
