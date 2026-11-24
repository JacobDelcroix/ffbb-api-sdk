<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Objet imbriqué TeamEngagement (modèle Python, team_engagement.py).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class TeamEngagement
{
    public function __construct(
        public ?string $codeAbrege = null,
        public ?Logo $logo = null,
        public ?string $nomOfficiel = null,
        public ?string $nomUsuel = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            codeAbrege: Cast::string($data['codeAbrege'] ?? null),
            logo: Cast::object($data['logo'] ?? null, Logo::class),
            nomOfficiel: Cast::string($data['nomOfficiel'] ?? null),
            nomUsuel: Cast::string($data['nomUsuel'] ?? null),
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
