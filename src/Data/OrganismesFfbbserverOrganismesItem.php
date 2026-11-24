<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_organismes_ffbbserver_organismes` (schéma OpenAPI ItemsFfbbserverOrganismesFfbbserverOrganismes).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class OrganismesFfbbserverOrganismesItem
{
    public const string COLLECTION = 'ffbbserver_organismes_ffbbserver_organismes';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [
        'ffbbserver_organismes' => 'ffbbserver_organismes_id',
        'related_ffbbserver_organismes' => 'related_ffbbserver_organismes_id',
    ];

    public function __construct(
        /** Champ Directus : ffbbserver_organismes_id */
        public ?OrganismesItem $ffbbserver_organismes = null,
        public ?int $id = null,
        /** Champ Directus : related_ffbbserver_organismes_id */
        public ?OrganismesItem $related_ffbbserver_organismes = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            ffbbserver_organismes: Cast::related($data['ffbbserver_organismes_id'] ?? null, OrganismesItem::class),
            id: Cast::int($data['id'] ?? null),
            related_ffbbserver_organismes: Cast::related($data['related_ffbbserver_organismes_id'] ?? null, OrganismesItem::class),
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
