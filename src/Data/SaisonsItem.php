<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_saisons` (schéma OpenAPI ItemsFfbbserverSaisons).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class SaisonsItem
{
    public const string COLLECTION = 'ffbbserver_saisons';

    public function __construct(
        public ?bool $actif = null,
        public ?string $code = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?DateTimeImmutable $debut = null,
        public ?bool $enCours = null,
        public ?DateTimeImmutable $fin = null,
        public ?string $id = null,
        public ?string $libelle = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            actif: Cast::bool($data['actif'] ?? null),
            code: Cast::string($data['code'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            debut: Cast::dateTime($data['debut'] ?? null),
            enCours: Cast::bool($data['enCours'] ?? null),
            fin: Cast::dateTime($data['fin'] ?? null),
            id: Cast::string($data['id'] ?? null),
            libelle: Cast::string($data['libelle'] ?? null),
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
