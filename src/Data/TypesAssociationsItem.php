<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_types_associations` (schéma OpenAPI ItemsFfbbserverTypesAssociations).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class TypesAssociationsItem
{
    public const string COLLECTION = 'ffbbserver_types_associations';

    public function __construct(
        public ?string $code = null,
        public ?bool $comite = null,
        public ?string $date_created = null,
        public ?string $date_updated = null,
        public ?bool $ffbb = null,
        public ?string $id = null,
        public ?string $libelle = null,
        public ?bool $ligue = null,
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
            comite: Cast::bool($data['comite'] ?? null),
            date_created: Cast::string($data['date_created'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            ffbb: Cast::bool($data['ffbb'] ?? null),
            id: Cast::string($data['id'] ?? null),
            libelle: Cast::string($data['libelle'] ?? null),
            ligue: Cast::bool($data['ligue'] ?? null),
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
