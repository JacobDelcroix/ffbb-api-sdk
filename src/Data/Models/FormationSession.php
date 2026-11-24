<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Objet imbriqué FormationSession (modèle Python, formation_session.py).
 *
 * A session within a formation (MeiliSearch denormalized data).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class FormationSession
{
    public function __construct(
        public ?DateTimeImmutable $date_end = null,
        public ?DateTimeImmutable $date_start = null,
        public ?string $entity = null,
        public ?string $id = null,
        public ?string $place = null,
        public ?string $postal_code = null,
        public ?string $reference = null,
        public ?string $subscribeBtn = null,
        public ?string $title = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            date_end: Cast::dateTime($data['date_end'] ?? null),
            date_start: Cast::dateTime($data['date_start'] ?? null),
            entity: Cast::string($data['entity'] ?? null),
            id: Cast::string($data['id'] ?? null),
            place: Cast::string($data['place'] ?? null),
            postal_code: Cast::string($data['postal_code'] ?? null),
            reference: Cast::string($data['reference'] ?? null),
            subscribeBtn: Cast::string($data['subscribeBtn'] ?? null),
            title: Cast::string($data['title'] ?? null),
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
