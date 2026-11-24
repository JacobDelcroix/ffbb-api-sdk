<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_terrains` (schéma OpenAPI ItemsFfbbserverTerrains).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class TerrainsItem
{
    public const string COLLECTION = 'ffbbserver_terrains';

    public function __construct(
        public ?bool $accesLibre = null,
        public CartographiesItem|string|int|null $cartographie = null,
        public CommunesItem|string|int|null $commune = null,
        public ?string $date_created = null,
        public ?string $date_updated = null,
        public ?string $id = null,
        public ?int $largeur = null,
        public ?int $longueur = null,
        public RevetementsItem|string|int|null $natureSol = null,
        public ?string $nom = null,
        public ?int $numero = null,
        public ?string $rue = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            accesLibre: Cast::bool($data['accesLibre'] ?? null),
            cartographie: Cast::relation($data['cartographie'] ?? null, CartographiesItem::class),
            commune: Cast::relation($data['commune'] ?? null, CommunesItem::class),
            date_created: Cast::string($data['date_created'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            id: Cast::string($data['id'] ?? null),
            largeur: Cast::int($data['largeur'] ?? null),
            longueur: Cast::int($data['longueur'] ?? null),
            natureSol: Cast::relation($data['natureSol'] ?? null, RevetementsItem::class),
            nom: Cast::string($data['nom'] ?? null),
            numero: Cast::int($data['numero'] ?? null),
            rue: Cast::string($data['rue'] ?? null),
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
