<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `genius_sport_matches` (schéma OpenAPI ItemsGeniusSportMatches).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class GeniusSportMatchesItem
{
    public const string COLLECTION = 'genius_sport_matches';

    public function __construct(
        public ?bool $atNeutralVenue = null,
        public ?int $attendance = null,
        public ?string $clock = null,
        public ?string $competitionAbgName = null,
        public ?int $competitionId = null,
        public ?string $competitionName = null,
        public ?bool $consolidated = null,
        public ?string $currentPeriod = null,
        public ?string $currentStatus = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?int $duration = null,
        public ?CompetitionsItem $externalCompetitionId = null,
        public ?RencontresItem $externalId = null,
        public ?int $extraPeriodsUsed = null,
        public ?int $fouls_home = null,
        public ?int $fouls_out = null,
        public ?int $leagueId = null,
        public ?bool $liveStream = null,
        public ?string $matchId = null,
        public ?string $matchName = null,
        public ?int $matchNumber = null,
        public ?string $matchStatus = null,
        public ?DateTimeImmutable $matchTime = null,
        public ?DateTimeImmutable $matchTimeUTC = null,
        public ?int $matchTimeUTC_timestamp = null,
        public ?int $matchTime_timestamp = null,
        public ?string $matchType = null,
        public ?string $periodStatus = null,
        public ?string $phaseName = null,
        public ?int $poolNumber = null,
        public ?string $roundDescription = null,
        public ?string $roundNumber = null,
        public ?int $score_home = null,
        public ?int $score_ot1_home = null,
        public ?int $score_ot1_out = null,
        public ?int $score_ot2_home = null,
        public ?int $score_ot2_out = null,
        public ?int $score_out = null,
        public ?int $score_q1_home = null,
        public ?int $score_q1_out = null,
        public ?int $score_q2_home = null,
        public ?int $score_q2_out = null,
        public ?int $score_q3_home = null,
        public ?int $score_q3_out = null,
        public ?int $score_q4_home = null,
        public ?int $score_q4_out = null,
        public ?bool $socket_opened = null,
        public ?string $statsSource = null,
        public mixed $stats_full = null,
        public ?EngagementsItem $teamEngagement_home = null,
        public ?EngagementsItem $teamEngagement_out = null,
        public ?int $teamId_home = null,
        public ?int $teamId_out = null,
        public ?string $teamName_home = null,
        public ?string $teamName_out = null,
        public ?string $temperature = null,
        public ?DateTimeImmutable $timeActual = null,
        public ?int $timeActual_timestamp = null,
        public ?DateTimeImmutable $timeEndActual = null,
        public ?int $timeEndActual_timestamp = null,
        public ?string $timezone = null,
        public ?string $twitterHashtag = null,
        public ?int $venueId = null,
        public ?string $venueName = null,
        public ?string $weather = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            atNeutralVenue: Cast::bool($data['atNeutralVenue'] ?? null),
            attendance: Cast::int($data['attendance'] ?? null),
            clock: Cast::string($data['clock'] ?? null),
            competitionAbgName: Cast::string($data['competitionAbgName'] ?? null),
            competitionId: Cast::int($data['competitionId'] ?? null),
            competitionName: Cast::string($data['competitionName'] ?? null),
            consolidated: Cast::bool($data['consolidated'] ?? null),
            currentPeriod: Cast::string($data['currentPeriod'] ?? null),
            currentStatus: Cast::string($data['currentStatus'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            duration: Cast::int($data['duration'] ?? null),
            externalCompetitionId: Cast::related($data['externalCompetitionId'] ?? null, CompetitionsItem::class),
            externalId: Cast::related($data['externalId'] ?? null, RencontresItem::class),
            extraPeriodsUsed: Cast::int($data['extraPeriodsUsed'] ?? null),
            fouls_home: Cast::int($data['fouls_home'] ?? null),
            fouls_out: Cast::int($data['fouls_out'] ?? null),
            leagueId: Cast::int($data['leagueId'] ?? null),
            liveStream: Cast::bool($data['liveStream'] ?? null),
            matchId: Cast::string($data['matchId'] ?? null),
            matchName: Cast::string($data['matchName'] ?? null),
            matchNumber: Cast::int($data['matchNumber'] ?? null),
            matchStatus: Cast::string($data['matchStatus'] ?? null),
            matchTime: Cast::dateTime($data['matchTime'] ?? null),
            matchTimeUTC: Cast::dateTime($data['matchTimeUTC'] ?? null),
            matchTimeUTC_timestamp: Cast::int($data['matchTimeUTC_timestamp'] ?? null),
            matchTime_timestamp: Cast::int($data['matchTime_timestamp'] ?? null),
            matchType: Cast::string($data['matchType'] ?? null),
            periodStatus: Cast::string($data['periodStatus'] ?? null),
            phaseName: Cast::string($data['phaseName'] ?? null),
            poolNumber: Cast::int($data['poolNumber'] ?? null),
            roundDescription: Cast::string($data['roundDescription'] ?? null),
            roundNumber: Cast::string($data['roundNumber'] ?? null),
            score_home: Cast::int($data['score_home'] ?? null),
            score_ot1_home: Cast::int($data['score_ot1_home'] ?? null),
            score_ot1_out: Cast::int($data['score_ot1_out'] ?? null),
            score_ot2_home: Cast::int($data['score_ot2_home'] ?? null),
            score_ot2_out: Cast::int($data['score_ot2_out'] ?? null),
            score_out: Cast::int($data['score_out'] ?? null),
            score_q1_home: Cast::int($data['score_q1_home'] ?? null),
            score_q1_out: Cast::int($data['score_q1_out'] ?? null),
            score_q2_home: Cast::int($data['score_q2_home'] ?? null),
            score_q2_out: Cast::int($data['score_q2_out'] ?? null),
            score_q3_home: Cast::int($data['score_q3_home'] ?? null),
            score_q3_out: Cast::int($data['score_q3_out'] ?? null),
            score_q4_home: Cast::int($data['score_q4_home'] ?? null),
            score_q4_out: Cast::int($data['score_q4_out'] ?? null),
            socket_opened: Cast::bool($data['socket_opened'] ?? null),
            statsSource: Cast::string($data['statsSource'] ?? null),
            stats_full: $data['stats_full'] ?? null,
            teamEngagement_home: Cast::related($data['teamEngagement_home'] ?? null, EngagementsItem::class),
            teamEngagement_out: Cast::related($data['teamEngagement_out'] ?? null, EngagementsItem::class),
            teamId_home: Cast::int($data['teamId_home'] ?? null),
            teamId_out: Cast::int($data['teamId_out'] ?? null),
            teamName_home: Cast::string($data['teamName_home'] ?? null),
            teamName_out: Cast::string($data['teamName_out'] ?? null),
            temperature: Cast::string($data['temperature'] ?? null),
            timeActual: Cast::dateTime($data['timeActual'] ?? null),
            timeActual_timestamp: Cast::int($data['timeActual_timestamp'] ?? null),
            timeEndActual: Cast::dateTime($data['timeEndActual'] ?? null),
            timeEndActual_timestamp: Cast::int($data['timeEndActual_timestamp'] ?? null),
            timezone: Cast::string($data['timezone'] ?? null),
            twitterHashtag: Cast::string($data['twitterHashtag'] ?? null),
            venueId: Cast::int($data['venueId'] ?? null),
            venueName: Cast::string($data['venueName'] ?? null),
            weather: Cast::string($data['weather'] ?? null),
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
