<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `edf_matches` (schéma OpenAPI ItemsEdfMatches).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EdfMatchesItem
{
    public const string COLLECTION = 'edf_matches';

    public function __construct(
        public ?EdfArenasItem $arena = null,
        public ?EdfCampaignsItem $campaign = null,
        public ?EdfCitiesItem $city = null,
        public ?EdfCompetitionTypesItem $competition_type = null,
        public ?EdfCountriesItem $country = null,
        public ?DateTimeImmutable $date = null,
        public ?DateTimeImmutable $date_created = null,
        public ?int $date_timestamp = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?EdfTeamsItem $edf_team = null,
        public ?int $federation_number = null,
        public ?bool $france_at_home = null,
        public GeniusSportMatchesItem|string|int|null $gsId = null,
        public ?string $hour = null,
        public ?int $id = null,
        public ?int $national_number = null,
        public ?bool $not_official = null,
        public ?EdfOpponentsItem $opponent = null,
        public ?int $original_id = null,
        public ?string $phase = null,
        public ?bool $preparation = null,
        public ?string $result = null,
        /** @var list<EdfSelectionItem>|null */
        public ?array $roster = null,
        public ?int $score_france = null,
        public ?int $score_france_ot1 = null,
        public ?int $score_france_ot2 = null,
        public ?int $score_france_q1 = null,
        public ?int $score_france_q2 = null,
        public ?int $score_france_q3 = null,
        public ?int $score_france_q4 = null,
        public ?int $score_opponent = null,
        public ?int $score_opponent_ot1 = null,
        public ?int $score_opponent_ot2 = null,
        public ?int $score_opponent_q1 = null,
        public ?int $score_opponent_q2 = null,
        public ?int $score_opponent_q3 = null,
        public ?int $score_opponent_q4 = null,
        public ?string $status = null,
        public ?string $url_article = null,
        public ?string $url_live = null,
        public ?string $url_match_sheet = null,
        public ?string $url_photos = null,
        public ?string $url_ticketing = null,
        public ?string $url_video = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            arena: Cast::related($data['arena'] ?? null, EdfArenasItem::class),
            campaign: Cast::related($data['campaign'] ?? null, EdfCampaignsItem::class),
            city: Cast::related($data['city'] ?? null, EdfCitiesItem::class),
            competition_type: Cast::related($data['competition_type'] ?? null, EdfCompetitionTypesItem::class),
            country: Cast::related($data['country'] ?? null, EdfCountriesItem::class),
            date: Cast::dateTime($data['date'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_timestamp: Cast::int($data['date_timestamp'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            edf_team: Cast::related($data['edf_team'] ?? null, EdfTeamsItem::class),
            federation_number: Cast::int($data['federation_number'] ?? null),
            france_at_home: Cast::bool($data['france_at_home'] ?? null),
            gsId: Cast::relation($data['gsId'] ?? null, GeniusSportMatchesItem::class),
            hour: Cast::string($data['hour'] ?? null),
            id: Cast::int($data['id'] ?? null),
            national_number: Cast::int($data['national_number'] ?? null),
            not_official: Cast::bool($data['not_official'] ?? null),
            opponent: Cast::related($data['opponent'] ?? null, EdfOpponentsItem::class),
            original_id: Cast::int($data['original_id'] ?? null),
            phase: Cast::string($data['phase'] ?? null),
            preparation: Cast::bool($data['preparation'] ?? null),
            result: Cast::string($data['result'] ?? null),
            roster: Cast::relatedList($data['roster'] ?? null, EdfSelectionItem::class),
            score_france: Cast::int($data['score_france'] ?? null),
            score_france_ot1: Cast::int($data['score_france_ot1'] ?? null),
            score_france_ot2: Cast::int($data['score_france_ot2'] ?? null),
            score_france_q1: Cast::int($data['score_france_q1'] ?? null),
            score_france_q2: Cast::int($data['score_france_q2'] ?? null),
            score_france_q3: Cast::int($data['score_france_q3'] ?? null),
            score_france_q4: Cast::int($data['score_france_q4'] ?? null),
            score_opponent: Cast::int($data['score_opponent'] ?? null),
            score_opponent_ot1: Cast::int($data['score_opponent_ot1'] ?? null),
            score_opponent_ot2: Cast::int($data['score_opponent_ot2'] ?? null),
            score_opponent_q1: Cast::int($data['score_opponent_q1'] ?? null),
            score_opponent_q2: Cast::int($data['score_opponent_q2'] ?? null),
            score_opponent_q3: Cast::int($data['score_opponent_q3'] ?? null),
            score_opponent_q4: Cast::int($data['score_opponent_q4'] ?? null),
            status: Cast::string($data['status'] ?? null),
            url_article: Cast::string($data['url_article'] ?? null),
            url_live: Cast::string($data['url_live'] ?? null),
            url_match_sheet: Cast::string($data['url_match_sheet'] ?? null),
            url_photos: Cast::string($data['url_photos'] ?? null),
            url_ticketing: Cast::string($data['url_ticketing'] ?? null),
            url_video: Cast::string($data['url_video'] ?? null),
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
