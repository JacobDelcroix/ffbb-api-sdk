<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `genius_sports_live_logs` (schéma OpenAPI ItemsGeniusSportsLiveLogs).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class GeniusSportsLiveLogsItem
{
    public const string COLLECTION = 'genius_sports_live_logs';

    public function __construct(
        public mixed $data = null,
        public ?DateTimeImmutable $date_created = null,
        public ?int $id = null,
        public GeniusSportMatchesItem|string|int|null $match = null,
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
            data: $data['data'] ?? null,
            date_created: Cast::dateTime($data['date_created'] ?? null),
            id: Cast::int($data['id'] ?? null),
            match: Cast::relation($data['match'] ?? null, GeniusSportMatchesItem::class),
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
