<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

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
        public ?CommunesItem $commune = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
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
            commune: Cast::related($data['commune'] ?? null, CommunesItem::class),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
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
