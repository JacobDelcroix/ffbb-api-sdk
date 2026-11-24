<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Hit des index de contenu (actualités, vidéos YouTube, RSS, galeries), dont le schéma
 * change souvent côté FFBB (miroir de GenericSearchHit) : quelques champs communs typés,
 * le reste dans $raw.
 */
final readonly class ContentHit
{
    /**
     * @param  array<string, mixed>  $raw  réponse brute complète
     */
    public function __construct(
        public string|int|null $id = null,
        public ?string $title = null,
        public ?string $type = null,
        public ?string $url = null,
        public ?string $thumbnail = null,
        public ?DateTimeImmutable $date = null,
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $id = $data['id'] ?? null;

        return new self(
            id: is_string($id) || is_int($id) ? $id : null,
            title: Cast::string($data['title'] ?? $data['titre'] ?? $data['name'] ?? null),
            type: Cast::string($data['type'] ?? null),
            url: Cast::string($data['url'] ?? $data['link'] ?? null),
            thumbnail: Cast::string($data['thumbnail'] ?? $data['image'] ?? null),
            date: Cast::dateTime($data['date'] ?? $data['date_published'] ?? $data['published_at'] ?? $data['date_created'] ?? null),
            raw: $data,
        );
    }

    /**
     * Valeur brute d'un champ quelconque.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->raw[$key] ?? $default;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->raw;
    }
}
