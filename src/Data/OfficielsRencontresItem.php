<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_officiels_rencontres` (schéma OpenAPI ItemsFfbbserverOfficielsRencontres).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class OfficielsRencontresItem
{
    public const string COLLECTION = 'ffbbserver_officiels_rencontres';

    public function __construct(
        public ?string $date_created = null,
        public ?string $date_updated = null,
        public ?float $distanceKm = null,
        public FonctionsOfficielsItem|string|int|null $fonction = null,
        public ?string $id = null,
        public ?float $indemnite = null,
        public OfficielsItem|string|int|null $officiel = null,
        public ?int $ordre = null,
        public ?string $presence = null,
        public RencontresItem|string|int|null $rencontre = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            date_created: Cast::string($data['date_created'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            distanceKm: Cast::float($data['distanceKm'] ?? null),
            fonction: Cast::relation($data['fonction'] ?? null, FonctionsOfficielsItem::class),
            id: Cast::string($data['id'] ?? null),
            indemnite: Cast::float($data['indemnite'] ?? null),
            officiel: Cast::relation($data['officiel'] ?? null, OfficielsItem::class),
            ordre: Cast::int($data['ordre'] ?? null),
            presence: Cast::string($data['presence'] ?? null),
            rencontre: Cast::relation($data['rencontre'] ?? null, RencontresItem::class),
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
