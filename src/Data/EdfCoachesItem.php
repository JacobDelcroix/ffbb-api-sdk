<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `edf_coaches` (schéma OpenAPI ItemsEdfCoaches).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EdfCoachesItem
{
    public const string COLLECTION = 'edf_coaches';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?DateTimeImmutable $birth_date = null,
        public ?string $birth_place = null,
        /** @var list<EdfStaffsItem>|null */
        public ?array $campaigns = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?DateTimeImmutable $death_date = null,
        public ?string $death_place = null,
        public ?string $first_name = null,
        public ?string $gender = null,
        public ?int $id = null,
        public ?string $last_name = null,
        public ?int $original_id = null,
        public ?string $qualification = null,
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
            birth_date: Cast::dateTime($data['birth_date'] ?? null),
            birth_place: Cast::string($data['birth_place'] ?? null),
            campaigns: Cast::relatedList($data['campaigns'] ?? null, EdfStaffsItem::class),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            death_date: Cast::dateTime($data['death_date'] ?? null),
            death_place: Cast::string($data['death_place'] ?? null),
            first_name: Cast::string($data['first_name'] ?? null),
            gender: Cast::string($data['gender'] ?? null),
            id: Cast::int($data['id'] ?? null),
            last_name: Cast::string($data['last_name'] ?? null),
            original_id: Cast::int($data['original_id'] ?? null),
            qualification: Cast::string($data['qualification'] ?? null),
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
