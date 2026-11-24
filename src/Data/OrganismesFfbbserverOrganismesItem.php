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

    public function __construct(
        public OrganismesItem|string|int|null $ffbbserver_organismes_id = null,
        public ?int $id = null,
        public OrganismesItem|string|int|null $related_ffbbserver_organismes_id = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            ffbbserver_organismes_id: Cast::relation($data['ffbbserver_organismes_id'] ?? null, OrganismesItem::class),
            id: Cast::int($data['id'] ?? null),
            related_ffbbserver_organismes_id: Cast::relation($data['related_ffbbserver_organismes_id'] ?? null, OrganismesItem::class),
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
