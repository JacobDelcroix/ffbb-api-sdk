<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_categories_championnats` (schéma OpenAPI ItemsFfbbserverCategoriesChampionnats).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class CategoriesChampionnatsItem
{
    public const string COLLECTION = 'ffbbserver_categories_championnats';

    public function __construct(
        public ?string $code = null,
        public ?string $date_created = null,
        public ?string $date_updated = null,
        public ?string $id = null,
        public ?string $libelle = null,
        public ?int $ordre = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: Cast::string($data['code'] ?? null),
            date_created: Cast::string($data['date_created'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            id: Cast::string($data['id'] ?? null),
            libelle: Cast::string($data['libelle'] ?? null),
            ordre: Cast::int($data['ordre'] ?? null),
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
