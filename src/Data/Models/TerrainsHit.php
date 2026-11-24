<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Hit Meilisearch de l'index `ffbbserver_terrains` (modèle Python TournoisHit (le SDK Python l'associe à un autre index)).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class TerrainsHit
{
    public const string INDEX = 'ffbbserver_terrains';

    public function __construct(
        public ?Geo $_geo = null,
        public ?bool $accesLibre = null,
        public ?Cartographie $cartographie = null,
        public ?Commune $commune = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?int $id = null,
        public ?int $largeur = null,
        public ?int $longueur = null,
        public ?NatureSol $natureSol = null,
        public ?string $nom = null,
        public ?int $numero = null,
        public ?string $rue = null,
        public ?string $thumbnail = null,
        public ?string $type = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            _geo: Cast::object($data['_geo'] ?? null, Geo::class),
            accesLibre: Cast::bool($data['accesLibre'] ?? null),
            cartographie: Cast::object($data['cartographie'] ?? null, Cartographie::class),
            commune: Cast::object($data['commune'] ?? null, Commune::class),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            id: Cast::int($data['id'] ?? null),
            largeur: Cast::int($data['largeur'] ?? null),
            longueur: Cast::int($data['longueur'] ?? null),
            natureSol: Cast::object($data['natureSol'] ?? null, NatureSol::class),
            nom: Cast::string($data['nom'] ?? null),
            numero: Cast::int($data['numero'] ?? null),
            rue: Cast::string($data['rue'] ?? null),
            thumbnail: Cast::string($data['thumbnail'] ?? null),
            type: Cast::string($data['type'] ?? null),
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
