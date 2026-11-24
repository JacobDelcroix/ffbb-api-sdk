<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Hit Meilisearch de l'index `ffbbserver_formations` (modèle Python FormationsHit).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class FormationsHit
{
    public const string INDEX = 'ffbbserver_formations';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?string $certification = null,
        public ?string $content = null,
        public ?DateTimeImmutable $date_end = null,
        public ?int $date_end_formatted = null,
        public ?DateTimeImmutable $date_start = null,
        public ?int $date_start_formatted = null,
        public ?string $description = null,
        public ?string $domain = null,
        public mixed $duration_hours = null,
        public ?string $entity = null,
        /** @var list<mixed>|null */
        public ?array $files = null,
        public ?string $formation_domain = null,
        public ?string $formation_duration_hours = null,
        public ?string $formation_id = null,
        public ?string $formation_image = null,
        public ?string $formation_mode = null,
        public ?string $formation_theme = null,
        public ?string $formation_thumbnail = null,
        public ?string $formation_title = null,
        public ?string $goals = null,
        public ?string $id = null,
        public ?string $id_origin_hash = null,
        public ?string $image = null,
        public ?string $level = null,
        public ?string $modalities = null,
        public ?string $mode = null,
        public ?string $mode_hidden = null,
        public ?string $pedagogy = null,
        public ?string $place = null,
        /** @var list<string>|null */
        public ?array $places = null,
        public ?string $postal_code = null,
        /** @var list<string>|null */
        public ?array $postal_codes = null,
        public ?string $prerequisites = null,
        public ?string $programIdFbi = null,
        public ?string $public = null,
        public ?string $reference = null,
        public ?string $reference_hidden = null,
        public ?string $results = null,
        /** @var list<FormationSession>|null */
        public ?array $sessions = null,
        public ?string $subscribeBtn = null,
        public ?string $subscribe_button = null,
        public ?string $theme = null,
        public ?string $thumbnail = null,
        public ?string $title = null,
        public ?string $type = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            certification: Cast::string($data['certification'] ?? null),
            content: Cast::string($data['content'] ?? null),
            date_end: Cast::dateTime($data['date_end'] ?? null),
            date_end_formatted: Cast::int($data['date_end_formatted'] ?? null),
            date_start: Cast::dateTime($data['date_start'] ?? null),
            date_start_formatted: Cast::int($data['date_start_formatted'] ?? null),
            description: Cast::string($data['description'] ?? null),
            domain: Cast::string($data['domain'] ?? null),
            duration_hours: $data['duration_hours'] ?? null,
            entity: Cast::string($data['entity'] ?? null),
            files: Cast::listOf($data['files'] ?? null, 'raw'),
            formation_domain: Cast::string($data['formation_domain'] ?? null),
            formation_duration_hours: Cast::string($data['formation_duration_hours'] ?? null),
            formation_id: Cast::string($data['formation_id'] ?? null),
            formation_image: Cast::string($data['formation_image'] ?? null),
            formation_mode: Cast::string($data['formation_mode'] ?? null),
            formation_theme: Cast::string($data['formation_theme'] ?? null),
            formation_thumbnail: Cast::string($data['formation_thumbnail'] ?? null),
            formation_title: Cast::string($data['formation_title'] ?? null),
            goals: Cast::string($data['goals'] ?? null),
            id: Cast::string($data['id'] ?? null),
            id_origin_hash: Cast::string($data['id_origin_hash'] ?? null),
            image: Cast::string($data['image'] ?? null),
            level: Cast::string($data['level'] ?? null),
            modalities: Cast::string($data['modalities'] ?? null),
            mode: Cast::string($data['mode'] ?? null),
            mode_hidden: Cast::string($data['mode_hidden'] ?? null),
            pedagogy: Cast::string($data['pedagogy'] ?? null),
            place: Cast::string($data['place'] ?? null),
            places: Cast::listOf($data['places'] ?? null, 'string'),
            postal_code: Cast::string($data['postal_code'] ?? null),
            postal_codes: Cast::listOf($data['postal_codes'] ?? null, 'string'),
            prerequisites: Cast::string($data['prerequisites'] ?? null),
            programIdFbi: Cast::string($data['programIdFbi'] ?? null),
            public: Cast::string($data['public'] ?? null),
            reference: Cast::string($data['reference'] ?? null),
            reference_hidden: Cast::string($data['reference_hidden'] ?? null),
            results: Cast::string($data['results'] ?? null),
            sessions: Cast::listOf($data['sessions'] ?? null, FormationSession::class),
            subscribeBtn: Cast::string($data['subscribeBtn'] ?? null),
            subscribe_button: Cast::string($data['subscribe_button'] ?? null),
            theme: Cast::string($data['theme'] ?? null),
            thumbnail: Cast::string($data['thumbnail'] ?? null),
            title: Cast::string($data['title'] ?? null),
            type: Cast::string($data['type'] ?? null),
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
