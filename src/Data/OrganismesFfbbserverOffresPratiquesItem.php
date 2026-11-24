<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_organismes_ffbbserver_offres_pratiques` (schéma OpenAPI ItemsFfbbserverOrganismesFfbbserverOffresPratiques).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class OrganismesFfbbserverOffresPratiquesItem
{
    public const string COLLECTION = 'ffbbserver_organismes_ffbbserver_offres_pratiques';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [
        'ffbbserver_offres_pratiques' => 'ffbbserver_offres_pratiques_id',
        'ffbbserver_organismes' => 'ffbbserver_organismes_id',
    ];

    public function __construct(
        /** Champ Directus : ffbbserver_offres_pratiques_id */
        public ?OffresPratiquesItem $ffbbserver_offres_pratiques = null,
        /** Champ Directus : ffbbserver_organismes_id */
        public ?OrganismesItem $ffbbserver_organismes = null,
        public ?int $id = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            ffbbserver_offres_pratiques: Cast::related($data['ffbbserver_offres_pratiques_id'] ?? null, OffresPratiquesItem::class),
            ffbbserver_organismes: Cast::related($data['ffbbserver_organismes_id'] ?? null, OrganismesItem::class),
            id: Cast::int($data['id'] ?? null),
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
