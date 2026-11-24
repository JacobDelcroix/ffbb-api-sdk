<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `rematch_videos` (schéma OpenAPI ItemsRematchVideos).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class RematchVideosItem
{
    public const string COLLECTION = 'rematch_videos';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [
        'club1Fede' => 'club1FedeID',
        'club2Fede' => 'club2FedeID',
        'competitionFede' => 'competitionFedeID',
        'matchFede' => 'matchFedeID',
    ];

    public function __construct(
        public ?string $author = null,
        /** Champ Directus : club1FedeID */
        public ?OrganismesItem $club1Fede = null,
        /** Champ Directus : club2FedeID */
        public ?OrganismesItem $club2Fede = null,
        /** Champ Directus : competitionFedeID */
        public ?CompetitionsItem $competitionFede = null,
        public ?DateTimeImmutable $date = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?string $federation = null,
        /** Champ Directus : matchFedeID */
        public ?RencontresItem $matchFede = null,
        public ?string $matchID = null,
        public ?string $placeName = null,
        public ?string $status = null,
        public ?string $thumbnailURL = null,
        public ?string $type = null,
        public ?string $user_created = null,
        public ?string $user_updated = null,
        public ?string $videoID = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            author: Cast::string($data['author'] ?? null),
            club1Fede: Cast::related($data['club1FedeID'] ?? null, OrganismesItem::class),
            club2Fede: Cast::related($data['club2FedeID'] ?? null, OrganismesItem::class),
            competitionFede: Cast::related($data['competitionFedeID'] ?? null, CompetitionsItem::class),
            date: Cast::dateTime($data['date'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            federation: Cast::string($data['federation'] ?? null),
            matchFede: Cast::related($data['matchFedeID'] ?? null, RencontresItem::class),
            matchID: Cast::string($data['matchID'] ?? null),
            placeName: Cast::string($data['placeName'] ?? null),
            status: Cast::string($data['status'] ?? null),
            thumbnailURL: Cast::string($data['thumbnailURL'] ?? null),
            type: Cast::string($data['type'] ?? null),
            user_created: Cast::string($data['user_created'] ?? null),
            user_updated: Cast::string($data['user_updated'] ?? null),
            videoID: Cast::string($data['videoID'] ?? null),
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
