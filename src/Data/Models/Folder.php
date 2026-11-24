<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Objet imbriqué Folder (modèle Python, folder.py).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class Folder
{
    public function __construct(
        public ?string $id = null,
        public ?string $name = null,
        public ?string $parent = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Cast::string($data['id'] ?? null),
            name: Cast::string($data['name'] ?? null),
            parent: Cast::string($data['parent'] ?? null),
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
