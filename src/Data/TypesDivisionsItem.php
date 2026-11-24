<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_types_divisions` (schéma OpenAPI ItemsFfbbserverTypesDivisions).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class TypesDivisionsItem
{
    public const string COLLECTION = 'ffbbserver_types_divisions';

    public function __construct(
        public ?CategoriesChampionnatsItem $categorieChampionnat = null,
        public ?int $ccg = null,
        public ?string $code = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?string $id = null,
        public ?string $libelle = null,
        public ?int $ordre = null,
        public ?int $point = null,
        public ?string $sexe = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            categorieChampionnat: Cast::related($data['categorieChampionnat'] ?? null, CategoriesChampionnatsItem::class),
            ccg: Cast::int($data['ccg'] ?? null),
            code: Cast::string($data['code'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            id: Cast::string($data['id'] ?? null),
            libelle: Cast::string($data['libelle'] ?? null),
            ordre: Cast::int($data['ordre'] ?? null),
            point: Cast::int($data['point'] ?? null),
            sexe: Cast::string($data['sexe'] ?? null),
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
