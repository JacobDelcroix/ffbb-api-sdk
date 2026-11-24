<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_types_tournois3x3` (schéma OpenAPI ItemsFfbbserverTypesTournois3x3).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class TypesTournois3x3Item
{
    public const string COLLECTION = 'ffbbserver_types_tournois3x3';

    public function __construct(
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?int $id = null,
        public ?string $libelle = null,
        public mixed $logo = null,
        public ?string $type_league = null,
        public ?TypesTournoisItem $type_tournois = null,
        public ?string $user_created = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            id: Cast::int($data['id'] ?? null),
            libelle: Cast::string($data['libelle'] ?? null),
            logo: $data['logo'] ?? null,
            type_league: Cast::string($data['type_league'] ?? null),
            type_tournois: Cast::related($data['type_tournois'] ?? null, TypesTournoisItem::class),
            user_created: Cast::string($data['user_created'] ?? null),
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
