<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `edf_cities` (schéma OpenAPI ItemsEdfCities).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EdfCitiesItem
{
    public const string COLLECTION = 'edf_cities';

    public function __construct(
        /** @var list<EdfCampaignsEdfCitiesItem>|null */
        public ?array $campaigns = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?int $id = null,
        /** @var list<EdfMatchesItem>|null */
        public ?array $matches = null,
        public ?string $name = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            campaigns: Cast::relatedList($data['campaigns'] ?? null, EdfCampaignsEdfCitiesItem::class),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            id: Cast::int($data['id'] ?? null),
            matches: Cast::relatedList($data['matches'] ?? null, EdfMatchesItem::class),
            name: Cast::string($data['name'] ?? null),
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
