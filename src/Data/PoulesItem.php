<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_poules` (schéma OpenAPI ItemsFfbbserverPoules).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class PoulesItem
{
    public const string COLLECTION = 'ffbbserver_poules';

    public function __construct(
        /** @var list<PoulesClassementsItem>|null */
        public ?array $classements = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        /** @var list<EngagementsItem>|null */
        public ?array $engagements = null,
        public ?string $id = null,
        public ?CompetitionsItem $id_competition = null,
        public ?string $nom = null,
        /** @var list<RencontresItem>|null */
        public ?array $rencontres = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            classements: Cast::relatedList($data['classements'] ?? null, PoulesClassementsItem::class),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            engagements: Cast::relatedList($data['engagements'] ?? null, EngagementsItem::class),
            id: Cast::string($data['id'] ?? null),
            id_competition: Cast::related($data['id_competition'] ?? null, CompetitionsItem::class),
            nom: Cast::string($data['nom'] ?? null),
            rencontres: Cast::relatedList($data['rencontres'] ?? null, RencontresItem::class),
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
