<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_formations_files` (schéma OpenAPI ItemsFfbbserverFormationsFiles).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class FormationsFilesItem
{
    public const string COLLECTION = 'ffbbserver_formations_files';

    public function __construct(
        public mixed $directus_files_id = null,
        public FormationsItem|string|int|null $ffbbserver_formations_id = null,
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
            directus_files_id: $data['directus_files_id'] ?? null,
            ffbbserver_formations_id: Cast::relation($data['ffbbserver_formations_id'] ?? null, FormationsItem::class),
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
