<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `edf_teams` (schéma OpenAPI ItemsEdfTeams).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EdfTeamsItem
{
    public const string COLLECTION = 'edf_teams';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?string $age_category = null,
        public ?string $basket_type = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?string $gender = null,
        public ?int $id = null,
        public mixed $logo = null,
        public ?string $name = null,
        public ?int $order = null,
        public ?int $original_id = null,
        public ?int $sort = null,
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
            age_category: Cast::string($data['age_category'] ?? null),
            basket_type: Cast::string($data['basket_type'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            gender: Cast::string($data['gender'] ?? null),
            id: Cast::int($data['id'] ?? null),
            logo: $data['logo'] ?? null,
            name: Cast::string($data['name'] ?? null),
            order: Cast::int($data['order'] ?? null),
            original_id: Cast::int($data['original_id'] ?? null),
            sort: Cast::int($data['sort'] ?? null),
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
