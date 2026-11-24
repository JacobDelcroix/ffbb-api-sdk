<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Objet imbriqué Cartographie (modèle Python, cartographie.py).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class Cartographie
{
    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?string $adresse = null,
        public ?string $codePostal = null,
        public ?Coordonnees $coordonnees = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?string $id = null,
        public ?float $latitude = null,
        public ?float $longitude = null,
        public ?string $status = null,
        public ?string $title = null,
        public ?string $ville = null,
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
            codePostal: Cast::string($data['codePostal'] ?? null),
            coordonnees: Cast::object($data['coordonnees'] ?? null, Coordonnees::class),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            id: Cast::string($data['id'] ?? null),
            latitude: Cast::float($data['latitude'] ?? null),
            longitude: Cast::float($data['longitude'] ?? null),
            status: Cast::string($data['status'] ?? null),
            title: Cast::string($data['title'] ?? null),
            ville: Cast::string($data['ville'] ?? null),
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
