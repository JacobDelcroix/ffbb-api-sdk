<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `edf_selection` (schéma OpenAPI ItemsEdfSelection).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EdfSelectionItem
{
    public const string COLLECTION = 'edf_selection';

    public function __construct(
        public ?string $club = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?float $height = null,
        public ?int $id = null,
        public ?bool $maj_n_nd = null,
        public ?bool $maj_n_npj = null,
        public ?EdfMatchesItem $match = null,
        public ?int $original_id = null,
        public ?EdfPlayersItem $player = null,
        public ?int $points_number = null,
        public ?int $sort = null,
        public ?string $status = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            club: Cast::string($data['club'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            height: Cast::float($data['height'] ?? null),
            id: Cast::int($data['id'] ?? null),
            maj_n_nd: Cast::bool($data['maj_n_nd'] ?? null),
            maj_n_npj: Cast::bool($data['maj_n_npj'] ?? null),
            match: Cast::related($data['match'] ?? null, EdfMatchesItem::class),
            original_id: Cast::int($data['original_id'] ?? null),
            player: Cast::related($data['player'] ?? null, EdfPlayersItem::class),
            points_number: Cast::int($data['points_number'] ?? null),
            sort: Cast::int($data['sort'] ?? null),
            status: Cast::string($data['status'] ?? null),
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
