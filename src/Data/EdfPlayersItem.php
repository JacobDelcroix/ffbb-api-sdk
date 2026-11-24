<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `edf_players` (schéma OpenAPI ItemsEdfPlayers).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EdfPlayersItem
{
    public const string COLLECTION = 'edf_players';

    public function __construct(
        public ?string $birth_place = null,
        /** @var list<EdfRostersItem>|null */
        public ?array $campaigns = null,
        public ?string $career = null,
        public ?DateTimeImmutable $date_birth = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_death = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?string $death_place = null,
        public ?string $distinctions = null,
        public ?string $first_name = null,
        public ?string $first_selection = null,
        public ?EdfMatchesItem $first_selection_id = null,
        public ?EdfMatchesItem $first_selection_id_3x3 = null,
        public ?float $height = null,
        public ?int $id = null,
        public ?string $identifiant = null,
        public ?int $identifier = null,
        public ?string $jou_n_id = null,
        public ?string $last_name = null,
        public ?string $last_selection = null,
        public ?EdfMatchesItem $last_selection_id = null,
        public ?EdfMatchesItem $last_selection_id_3x3 = null,
        public ?int $original_id = null,
        public ?string $palmares = null,
        public ?string $palmares_individual = null,
        public ?string $palmares_international = null,
        public ?string $player_note = null,
        public ?int $player_points = null,
        public ?int $player_points_3x3 = null,
        public ?int $player_record = null,
        public ?int $player_record_3x3 = null,
        public ?int $player_selections = null,
        public ?int $player_selections_3x3 = null,
        public ?string $pole = null,
        /** @var list<EdfPlayersEdfPositionsItem>|null */
        public ?array $position = null,
        /** @var list<EdfSelectionItem>|null */
        public ?array $selections = null,
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
            birth_place: Cast::string($data['birth_place'] ?? null),
            campaigns: Cast::relatedList($data['campaigns'] ?? null, EdfRostersItem::class),
            career: Cast::string($data['career'] ?? null),
            date_birth: Cast::dateTime($data['date_birth'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_death: Cast::dateTime($data['date_death'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            death_place: Cast::string($data['death_place'] ?? null),
            distinctions: Cast::string($data['distinctions'] ?? null),
            first_name: Cast::string($data['first_name'] ?? null),
            first_selection: Cast::string($data['first_selection'] ?? null),
            first_selection_id: Cast::related($data['first_selection_id'] ?? null, EdfMatchesItem::class),
            first_selection_id_3x3: Cast::related($data['first_selection_id_3x3'] ?? null, EdfMatchesItem::class),
            height: Cast::float($data['height'] ?? null),
            id: Cast::int($data['id'] ?? null),
            identifiant: Cast::string($data['identifiant'] ?? null),
            identifier: Cast::int($data['identifier'] ?? null),
            jou_n_id: Cast::string($data['jou_n_id'] ?? null),
            last_name: Cast::string($data['last_name'] ?? null),
            last_selection: Cast::string($data['last_selection'] ?? null),
            last_selection_id: Cast::related($data['last_selection_id'] ?? null, EdfMatchesItem::class),
            last_selection_id_3x3: Cast::related($data['last_selection_id_3x3'] ?? null, EdfMatchesItem::class),
            original_id: Cast::int($data['original_id'] ?? null),
            palmares: Cast::string($data['palmares'] ?? null),
            palmares_individual: Cast::string($data['palmares_individual'] ?? null),
            palmares_international: Cast::string($data['palmares_international'] ?? null),
            player_note: Cast::string($data['player_note'] ?? null),
            player_points: Cast::int($data['player_points'] ?? null),
            player_points_3x3: Cast::int($data['player_points_3x3'] ?? null),
            player_record: Cast::int($data['player_record'] ?? null),
            player_record_3x3: Cast::int($data['player_record_3x3'] ?? null),
            player_selections: Cast::int($data['player_selections'] ?? null),
            player_selections_3x3: Cast::int($data['player_selections_3x3'] ?? null),
            pole: Cast::string($data['pole'] ?? null),
            position: Cast::relatedList($data['position'] ?? null, EdfPlayersEdfPositionsItem::class),
            selections: Cast::relatedList($data['selections'] ?? null, EdfSelectionItem::class),
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
