<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Match en direct (json/lives.json), modèle Python Live.
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class Live
{
    public function __construct(
        public mixed $clock = null,
        public ?string $competitionAbgName = null,
        public ?string $competitionName = null,
        public ?string $currentPeriod = null,
        public ?string $currentStatus = null,
        public ?ExternalID $externalId = null,
        public ?int $matchId = null,
        public ?string $matchStatus = null,
        public ?DateTimeImmutable $matchTime = null,
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
        public ?TeamEngagement $teamEngagement_home = null,
        public ?TeamEngagement $teamEngagement_out = null,
        public ?string $teamName_home = null,
        public ?string $teamName_out = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            clock: $data['clock'] ?? null,
            competitionAbgName: Cast::string($data['competitionAbgName'] ?? null),
            competitionName: Cast::string($data['competitionName'] ?? null),
            currentPeriod: Cast::string($data['currentPeriod'] ?? null),
            currentStatus: Cast::string($data['currentStatus'] ?? null),
            externalId: Cast::object($data['externalId'] ?? null, ExternalID::class),
            matchId: Cast::int($data['matchId'] ?? null),
            matchStatus: Cast::string($data['matchStatus'] ?? null),
            matchTime: Cast::dateTime($data['matchTime'] ?? null),
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
            teamEngagement_home: Cast::object($data['teamEngagement_home'] ?? null, TeamEngagement::class),
            teamEngagement_out: Cast::object($data['teamEngagement_out'] ?? null, TeamEngagement::class),
            teamName_home: Cast::string($data['teamName_home'] ?? null),
            teamName_out: Cast::string($data['teamName_out'] ?? null),
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
