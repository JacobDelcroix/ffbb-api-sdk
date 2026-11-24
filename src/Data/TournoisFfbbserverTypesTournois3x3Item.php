<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_tournois_ffbbserver_types_tournois3x3` (schéma OpenAPI ItemsFfbbserverTournoisFfbbserverTypesTournois3x3).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class TournoisFfbbserverTypesTournois3x3Item
{
    public const string COLLECTION = 'ffbbserver_tournois_ffbbserver_types_tournois3x3';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [
        'ffbbserver_tournois' => 'ffbbserver_tournois_id',
        'ffbbserver_types_tournois_3x3' => 'ffbbserver_types_tournois_3x3_id',
    ];

    public function __construct(
        /** Champ Directus : ffbbserver_tournois_id */
        public ?TournoisItem $ffbbserver_tournois = null,
        /** Champ Directus : ffbbserver_types_tournois_3x3_id */
        public ?TypesTournois3x3Item $ffbbserver_types_tournois_3x3 = null,
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
            ffbbserver_tournois: Cast::related($data['ffbbserver_tournois_id'] ?? null, TournoisItem::class),
            ffbbserver_types_tournois_3x3: Cast::related($data['ffbbserver_types_tournois_3x3_id'] ?? null, TypesTournois3x3Item::class),
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
