<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_labellisations_organismes` (schéma OpenAPI ItemsFfbbserverLabellisationsOrganismes).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class LabellisationsOrganismesItem
{
    public const string COLLECTION = 'ffbbserver_labellisations_organismes';

    public function __construct(
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?DateTimeImmutable $debut = null,
        public ?DateTimeImmutable $fin = null,
        public ?string $id = null,
        public ?LabellisationProgrammeItem $idLabellisationProgramme = null,
        public ?OrganismesItem $idOrganisme = null,
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
            debut: Cast::dateTime($data['debut'] ?? null),
            fin: Cast::dateTime($data['fin'] ?? null),
            id: Cast::string($data['id'] ?? null),
            idLabellisationProgramme: Cast::related($data['idLabellisationProgramme'] ?? null, LabellisationProgrammeItem::class),
            idOrganisme: Cast::related($data['idOrganisme'] ?? null, OrganismesItem::class),
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
