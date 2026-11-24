<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_labellisations_organismes` (schéma OpenAPI ItemsFfbbserverLabellisationsOrganismes).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class LabellisationsOrganismesItem
{
    public const string COLLECTION = 'ffbbserver_labellisations_organismes';

    public function __construct(
        public ?string $date_created = null,
        public ?string $date_updated = null,
        public ?string $debut = null,
        public ?string $fin = null,
        public ?string $id = null,
        public LabellisationProgrammeItem|string|int|null $idLabellisationProgramme = null,
        public OrganismesItem|string|int|null $idOrganisme = null,
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
            debut: Cast::string($data['debut'] ?? null),
            fin: Cast::string($data['fin'] ?? null),
            id: Cast::string($data['id'] ?? null),
            idLabellisationProgramme: Cast::relation($data['idLabellisationProgramme'] ?? null, LabellisationProgrammeItem::class),
            idOrganisme: Cast::relation($data['idOrganisme'] ?? null, OrganismesItem::class),
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
