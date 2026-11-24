<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_sessions` (schéma OpenAPI ItemsFfbbserverSessions).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class SessionsItem
{
    public const string COLLECTION = 'ffbbserver_sessions';

    public function __construct(
        public ?string $date_created = null,
        public ?string $date_end = null,
        public ?string $date_start = null,
        public ?string $date_updated = null,
        public ?string $entity = null,
        public FormationsItem|string|int|null $formations = null,
        public ?string $id = null,
        public ?string $idOrigin = null,
        public ?string $place = null,
        public ?string $postal_code = null,
        public ?string $reference = null,
        public ?int $sort = null,
        public ?string $status = null,
        public ?string $subscribeBtn = null,
        public ?string $title = null,
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
            date_created: Cast::string($data['date_created'] ?? null),
            date_end: Cast::string($data['date_end'] ?? null),
            date_start: Cast::string($data['date_start'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            entity: Cast::string($data['entity'] ?? null),
            formations: Cast::relation($data['formations'] ?? null, FormationsItem::class),
            id: Cast::string($data['id'] ?? null),
            idOrigin: Cast::string($data['idOrigin'] ?? null),
            place: Cast::string($data['place'] ?? null),
            postal_code: Cast::string($data['postal_code'] ?? null),
            reference: Cast::string($data['reference'] ?? null),
            sort: Cast::int($data['sort'] ?? null),
            status: Cast::string($data['status'] ?? null),
            subscribeBtn: Cast::string($data['subscribeBtn'] ?? null),
            title: Cast::string($data['title'] ?? null),
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
            $out[] = self::fromArray($item);
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
