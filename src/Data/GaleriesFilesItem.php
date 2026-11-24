<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbnational_galeries_files` (schéma OpenAPI ItemsFfbbnationalGaleriesFiles).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class GaleriesFilesItem
{
    public const string COLLECTION = 'ffbbnational_galeries_files';

    public function __construct(
        public mixed $directus_files_id = null,
        public ?GaleriesItem $ffbbnational_galeries_id = null,
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
            directus_files_id: $data['directus_files_id'] ?? null,
            ffbbnational_galeries_id: Cast::related($data['ffbbnational_galeries_id'] ?? null, GaleriesItem::class),
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
