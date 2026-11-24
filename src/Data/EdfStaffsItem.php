<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `edf_staffs` (schéma OpenAPI ItemsEdfStaffs).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EdfStaffsItem
{
    public const string COLLECTION = 'edf_staffs';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?EdfCampaignsItem $campaign = null,
        public ?string $club = null,
        public ?EdfCoachesItem $coach = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?int $id = null,
        public ?int $order = null,
        public ?string $original_id = null,
        public mixed $photo = null,
        public mixed $photo_hover = null,
        public ?string $role = null,
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
            campaign: Cast::related($data['campaign'] ?? null, EdfCampaignsItem::class),
            club: Cast::string($data['club'] ?? null),
            coach: Cast::related($data['coach'] ?? null, EdfCoachesItem::class),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            id: Cast::int($data['id'] ?? null),
            order: Cast::int($data['order'] ?? null),
            original_id: Cast::string($data['original_id'] ?? null),
            photo: $data['photo'] ?? null,
            photo_hover: $data['photo_hover'] ?? null,
            role: Cast::string($data['role'] ?? null),
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
