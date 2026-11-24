<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Objet imbriqué IDOrganismeEquipe (modèle Python, id_organisme_equipe.py).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class IDOrganismeEquipe
{
    public function __construct(
        public ?string $code = null,
        public ?string $id = null,
        public ?IDOrganismeEquipe1Logo $logo = null,
        public ?string $nom = null,
        public ?string $nomClubPro = null,
        public ?string $nom_simple = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: Cast::string($data['code'] ?? null),
            id: Cast::string($data['id'] ?? null),
            logo: Cast::object($data['logo'] ?? null, IDOrganismeEquipe1Logo::class),
            nom: Cast::string($data['nom'] ?? null),
            nomClubPro: Cast::string($data['nomClubPro'] ?? null),
            nom_simple: Cast::string($data['nom_simple'] ?? null),
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
