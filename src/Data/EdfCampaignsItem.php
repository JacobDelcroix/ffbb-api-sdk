<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `edf_campaigns` (schéma OpenAPI ItemsEdfCampaigns).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EdfCampaignsItem
{
    public const string COLLECTION = 'edf_campaigns';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?string $bronze = null,
        public ?EdfOpponentsItem $bronze_medalist = null,
        /** @var list<EdfCampaignsEdfCitiesItem>|null */
        public ?array $cities = null,
        public ?EdfCompetitionTypesItem $competition_type = null,
        /** @var list<EdfCampaignsEdfCountriesItem>|null */
        public ?array $countries = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?string $gold = null,
        public ?EdfOpponentsItem $gold_medalist = null,
        public ?int $id = null,
        /** @var list<EdfMatchesItem>|null */
        public ?array $matches = null,
        public ?int $original_id = null,
        public mixed $photo_team = null,
        public ?string $place = null,
        public ?string $rank = null,
        /** @var list<EdfRostersItem>|null */
        public ?array $roster = null,
        public ?string $silver = null,
        public ?EdfOpponentsItem $silver_medalist = null,
        /** @var list<EdfStaffsItem>|null */
        public ?array $staff = null,
        public ?string $status = null,
        public ?EdfTeamsItem $team = null,
        public ?bool $team_france = null,
        public ?int $year = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            bronze: Cast::string($data['bronze'] ?? null),
            bronze_medalist: Cast::related($data['bronze_medalist'] ?? null, EdfOpponentsItem::class),
            cities: Cast::relatedList($data['cities'] ?? null, EdfCampaignsEdfCitiesItem::class),
            competition_type: Cast::related($data['competition_type'] ?? null, EdfCompetitionTypesItem::class),
            countries: Cast::relatedList($data['countries'] ?? null, EdfCampaignsEdfCountriesItem::class),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            gold: Cast::string($data['gold'] ?? null),
            gold_medalist: Cast::related($data['gold_medalist'] ?? null, EdfOpponentsItem::class),
            id: Cast::int($data['id'] ?? null),
            matches: Cast::relatedList($data['matches'] ?? null, EdfMatchesItem::class),
            original_id: Cast::int($data['original_id'] ?? null),
            photo_team: $data['photo_team'] ?? null,
            place: Cast::string($data['place'] ?? null),
            rank: Cast::string($data['rank'] ?? null),
            roster: Cast::relatedList($data['roster'] ?? null, EdfRostersItem::class),
            silver: Cast::string($data['silver'] ?? null),
            silver_medalist: Cast::related($data['silver_medalist'] ?? null, EdfOpponentsItem::class),
            staff: Cast::relatedList($data['staff'] ?? null, EdfStaffsItem::class),
            status: Cast::string($data['status'] ?? null),
            team: Cast::related($data['team'] ?? null, EdfTeamsItem::class),
            team_france: Cast::bool($data['team_france'] ?? null),
            year: Cast::int($data['year'] ?? null),
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
