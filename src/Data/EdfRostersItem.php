<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `edf_rosters` (schéma OpenAPI ItemsEdfRosters).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EdfRostersItem
{
    public const string COLLECTION = 'edf_rosters';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?EdfCampaignsItem $campaign = null,
        public ?string $club = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?float $height = null,
        public ?int $id = null,
        public ?string $number = null,
        public ?int $order = null,
        public ?int $original_id = null,
        public mixed $photo = null,
        public mixed $photo_hover = null,
        public ?EdfPlayersItem $player = null,
        public ?string $status = null,
        public ?bool $unselected = null,
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
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            height: Cast::float($data['height'] ?? null),
            id: Cast::int($data['id'] ?? null),
            number: Cast::string($data['number'] ?? null),
            order: Cast::int($data['order'] ?? null),
            original_id: Cast::int($data['original_id'] ?? null),
            photo: $data['photo'] ?? null,
            photo_hover: $data['photo_hover'] ?? null,
            player: Cast::related($data['player'] ?? null, EdfPlayersItem::class),
            status: Cast::string($data['status'] ?? null),
            unselected: Cast::bool($data['unselected'] ?? null),
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
