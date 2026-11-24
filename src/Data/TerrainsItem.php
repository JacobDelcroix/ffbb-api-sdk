<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_terrains` (schéma OpenAPI ItemsFfbbserverTerrains).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class TerrainsItem
{
    public const string COLLECTION = 'ffbbserver_terrains';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?bool $accesLibre = null,
        public ?CartographiesItem $cartographie = null,
        public ?CommunesItem $commune = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?string $id = null,
        public ?int $largeur = null,
        public ?int $longueur = null,
        public ?RevetementsItem $natureSol = null,
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
            cartographie: Cast::related($data['cartographie'] ?? null, CartographiesItem::class),
            commune: Cast::related($data['commune'] ?? null, CommunesItem::class),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            id: Cast::string($data['id'] ?? null),
            largeur: Cast::int($data['largeur'] ?? null),
            longueur: Cast::int($data['longueur'] ?? null),
            natureSol: Cast::related($data['natureSol'] ?? null, RevetementsItem::class),
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
