<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `configuration` (schéma OpenAPI ItemsConfiguration).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class ConfigurationItem
{
    public const string COLLECTION = 'configuration';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?string $android_version = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?bool $force_ms_reindex = null,
        public ?int $id = null,
        public ?string $ios_version = null,
        public ?string $key_dh = null,
        public ?string $key_directus_competitions = null,
        public ?string $key_directus_website = null,
        public ?string $key_ms = null,
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
            android_version: Cast::string($data['android_version'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            force_ms_reindex: Cast::bool($data['force_ms_reindex'] ?? null),
            id: Cast::int($data['id'] ?? null),
            ios_version: Cast::string($data['ios_version'] ?? null),
            key_dh: Cast::string($data['key_dh'] ?? null),
            key_directus_competitions: Cast::string($data['key_directus_competitions'] ?? null),
            key_directus_website: Cast::string($data['key_directus_website'] ?? null),
            key_ms: Cast::string($data['key_ms'] ?? null),
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
