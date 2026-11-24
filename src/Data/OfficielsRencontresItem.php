<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_officiels_rencontres` (schéma OpenAPI ItemsFfbbserverOfficielsRencontres).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class OfficielsRencontresItem
{
    public const string COLLECTION = 'ffbbserver_officiels_rencontres';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?float $distanceKm = null,
        public ?FonctionsOfficielsItem $fonction = null,
        public ?string $id = null,
        public ?float $indemnite = null,
        public OfficielsItem|string|int|null $officiel = null,
        public ?int $ordre = null,
        public ?string $presence = null,
        public ?RencontresItem $rencontre = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            distanceKm: Cast::float($data['distanceKm'] ?? null),
            fonction: Cast::related($data['fonction'] ?? null, FonctionsOfficielsItem::class),
            id: Cast::string($data['id'] ?? null),
            indemnite: Cast::float($data['indemnite'] ?? null),
            officiel: Cast::relation($data['officiel'] ?? null, OfficielsItem::class),
            ordre: Cast::int($data['ordre'] ?? null),
            presence: Cast::string($data['presence'] ?? null),
            rencontre: Cast::related($data['rencontre'] ?? null, RencontresItem::class),
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
