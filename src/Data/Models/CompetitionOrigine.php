<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Objet imbriqué CompetitionOrigine (modèle Python, competition_origine.py).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class CompetitionOrigine
{
    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?CompetitionOrigineCategorie $categorie = null,
        public ?string $code = null,
        public ?string $id = null,
        public ?string $nom = null,
        public mixed $typeCompetition = null,
        public ?CompetitionOrigineTypeCompetitionGenerique $typeCompetitionGenerique = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            categorie: Cast::object($data['categorie'] ?? null, CompetitionOrigineCategorie::class),
            code: Cast::string($data['code'] ?? null),
            id: Cast::string($data['id'] ?? null),
            nom: Cast::string($data['nom'] ?? null),
            typeCompetition: $data['typeCompetition'] ?? null,
            typeCompetitionGenerique: Cast::object($data['typeCompetitionGenerique'] ?? null, CompetitionOrigineTypeCompetitionGenerique::class),
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
