<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_salles` (schéma OpenAPI ItemsFfbbserverSalles).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class SallesItem
{
    public const string COLLECTION = 'ffbbserver_salles';

    public function __construct(
        public ?string $adresse = null,
        public ?string $adresseComplement = null,
        public ?string $capaciteSpectateur = null,
        public CartographiesItem|string|int|null $cartographie = null,
        public CommunesItem|string|int|null $commune = null,
        public ?string $date_created = null,
        public ?string $date_updated = null,
        public ?string $id = null,
        public ?string $libelle = null,
        public ?string $libelle2 = null,
        public ?string $mail = null,
        public ?string $numero = null,
        public ?string $telephone = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            adresse: Cast::string($data['adresse'] ?? null),
            adresseComplement: Cast::string($data['adresseComplement'] ?? null),
            capaciteSpectateur: Cast::string($data['capaciteSpectateur'] ?? null),
            cartographie: Cast::relation($data['cartographie'] ?? null, CartographiesItem::class),
            commune: Cast::relation($data['commune'] ?? null, CommunesItem::class),
            date_created: Cast::string($data['date_created'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            id: Cast::string($data['id'] ?? null),
            libelle: Cast::string($data['libelle'] ?? null),
            libelle2: Cast::string($data['libelle2'] ?? null),
            mail: Cast::string($data['mail'] ?? null),
            numero: Cast::string($data['numero'] ?? null),
            telephone: Cast::string($data['telephone'] ?? null),
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
