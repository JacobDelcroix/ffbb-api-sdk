<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `edf_campaigns_edf_cities` (schéma OpenAPI ItemsEdfCampaignsEdfCities).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EdfCampaignsEdfCitiesItem
{
    public const string COLLECTION = 'edf_campaigns_edf_cities';

    public function __construct(
        public ?EdfCampaignsItem $edf_campaigns_id = null,
        public ?EdfCitiesItem $edf_cities_id = null,
        public ?int $id = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            edf_campaigns_id: Cast::related($data['edf_campaigns_id'] ?? null, EdfCampaignsItem::class),
            edf_cities_id: Cast::related($data['edf_cities_id'] ?? null, EdfCitiesItem::class),
            id: Cast::int($data['id'] ?? null),
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
