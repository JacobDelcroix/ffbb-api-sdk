<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `edf_players_edf_positions` (schéma OpenAPI ItemsEdfPlayersEdfPositions).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EdfPlayersEdfPositionsItem
{
    public const string COLLECTION = 'edf_players_edf_positions';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [
        'edf_players' => 'edf_players_id',
        'edf_positions' => 'edf_positions_id',
    ];

    public function __construct(
        /** Champ Directus : edf_players_id */
        public ?EdfPlayersItem $edf_players = null,
        /** Champ Directus : edf_positions_id */
        public ?EdfPositionsItem $edf_positions = null,
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
            edf_players: Cast::related($data['edf_players_id'] ?? null, EdfPlayersItem::class),
            edf_positions: Cast::related($data['edf_positions_id'] ?? null, EdfPositionsItem::class),
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
