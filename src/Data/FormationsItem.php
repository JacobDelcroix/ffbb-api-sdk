<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_formations` (schéma OpenAPI ItemsFfbbserverFormations).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class FormationsItem
{
    public const string COLLECTION = 'ffbbserver_formations';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?string $certification = null,
        public ?string $content = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?string $description = null,
        public ?FormationsDomainItem $domain = null,
        public ?string $duration_hours = null,
        /** @var list<FormationsFilesItem>|null */
        public ?array $files = null,
        public ?string $goals = null,
        public ?string $id = null,
        public ?string $idOrigin = null,
        public ?string $idOriginHash = null,
        public mixed $image = null,
        public ?string $level = null,
        public ?string $modalities = null,
        public ?string $mode = null,
        public ?string $pedagogy = null,
        public ?string $prerequisites = null,
        public ?string $programIdFbi = null,
        public ?string $public = null,
        public ?string $reference = null,
        public ?string $results = null,
        /** @var list<SessionsItem>|null */
        public ?array $sessions = null,
        public ?int $sort = null,
        public ?string $status = null,
        public ?FormationsThemeItem $theme = null,
        public ?string $title = null,
        public ?string $user_created = null,
        public ?string $user_updated = null,
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
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            description: Cast::string($data['description'] ?? null),
            domain: Cast::related($data['domain'] ?? null, FormationsDomainItem::class),
            duration_hours: Cast::string($data['duration_hours'] ?? null),
            files: Cast::relatedList($data['files'] ?? null, FormationsFilesItem::class),
            goals: Cast::string($data['goals'] ?? null),
            id: Cast::string($data['id'] ?? null),
            idOrigin: Cast::string($data['idOrigin'] ?? null),
            idOriginHash: Cast::string($data['idOriginHash'] ?? null),
            image: $data['image'] ?? null,
            level: Cast::string($data['level'] ?? null),
            modalities: Cast::string($data['modalities'] ?? null),
            mode: Cast::string($data['mode'] ?? null),
            pedagogy: Cast::string($data['pedagogy'] ?? null),
            prerequisites: Cast::string($data['prerequisites'] ?? null),
            programIdFbi: Cast::string($data['programIdFbi'] ?? null),
            public: Cast::string($data['public'] ?? null),
            reference: Cast::string($data['reference'] ?? null),
            results: Cast::string($data['results'] ?? null),
            sessions: Cast::relatedList($data['sessions'] ?? null, SessionsItem::class),
            sort: Cast::int($data['sort'] ?? null),
            status: Cast::string($data['status'] ?? null),
            theme: Cast::related($data['theme'] ?? null, FormationsThemeItem::class),
            title: Cast::string($data['title'] ?? null),
            user_created: Cast::string($data['user_created'] ?? null),
            user_updated: Cast::string($data['user_updated'] ?? null),
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
