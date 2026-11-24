<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbnational_rss` (schéma OpenAPI ItemsFfbbnationalRss).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class RssItem
{
    public const string COLLECTION = 'ffbbnational_rss';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        /** @var list<RssFfbbnationalCategoriesItem>|null */
        public ?array $categories = null,
        public ?string $chapo = null,
        public mixed $cover = null,
        public ?string $creator = null,
        public ?DateTimeImmutable $date = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?bool $highlight = null,
        public ?string $id = null,
        public ?string $img = null,
        public ?string $img_credits = null,
        public ?string $img_legend = null,
        public ?string $link = null,
        public ?string $match_id = null,
        public ?string $surtitle = null,
        /** @var list<RssFfbbnationalTagsItem>|null */
        public ?array $tags = null,
        public mixed $text = null,
        public ?string $texte = null,
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
            categories: Cast::relatedList($data['categories'] ?? null, RssFfbbnationalCategoriesItem::class),
            chapo: Cast::string($data['chapo'] ?? null),
            cover: $data['cover'] ?? null,
            creator: Cast::string($data['creator'] ?? null),
            date: Cast::dateTime($data['date'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            highlight: Cast::bool($data['highlight'] ?? null),
            id: Cast::string($data['id'] ?? null),
            img: Cast::string($data['img'] ?? null),
            img_credits: Cast::string($data['img_credits'] ?? null),
            img_legend: Cast::string($data['img_legend'] ?? null),
            link: Cast::string($data['link'] ?? null),
            match_id: Cast::string($data['match_id'] ?? null),
            surtitle: Cast::string($data['surtitle'] ?? null),
            tags: Cast::relatedList($data['tags'] ?? null, RssFfbbnationalTagsItem::class),
            text: $data['text'] ?? null,
            texte: Cast::string($data['texte'] ?? null),
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
