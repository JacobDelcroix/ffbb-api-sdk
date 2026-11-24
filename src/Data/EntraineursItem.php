<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_entraineurs` (schéma OpenAPI ItemsFfbbserverEntraineurs).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EntraineursItem
{
    public const string COLLECTION = 'ffbbserver_entraineurs';

    public function __construct(
        public ?string $adresse1 = null,
        public ?string $adresse2 = null,
        public CommunesItem|string|int|null $commune = null,
        public ?string $date_created = null,
        public ?string $date_updated = null,
        public ?string $idLicence = null,
        public ?string $nom = null,
        public ?string $prenom = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            adresse1: Cast::string($data['adresse1'] ?? null),
            adresse2: Cast::string($data['adresse2'] ?? null),
            commune: Cast::relation($data['commune'] ?? null, CommunesItem::class),
            date_created: Cast::string($data['date_created'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            idLicence: Cast::string($data['idLicence'] ?? null),
            nom: Cast::string($data['nom'] ?? null),
            prenom: Cast::string($data['prenom'] ?? null),
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
