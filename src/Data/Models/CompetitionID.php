<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Objet imbriqué CompetitionID (modèle Python, competition_id.py).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class CompetitionID
{
    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?CompetitionIDCategorie $categorie = null,
        public ?string $code = null,
        public ?CompetitionOrigine $competition_origine = null,
        public ?string $competition_origine_nom = null,
        public ?bool $creationEnCours = null,
        public ?string $id = null,
        public ?bool $liveStat = null,
        public ?Logo $logo = null,
        public ?string $nom = null,
        public ?string $nomExtended = null,
        public ?bool $pro = null,
        public ?string $publicationInternet = null,
        public ?string $sexe = null,
        public ?string $typeCompetition = null,
        public ?CompetitionIDTypeCompetitionGenerique $typeCompetitionGenerique = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            categorie: Cast::object($data['categorie'] ?? null, CompetitionIDCategorie::class),
            code: Cast::string($data['code'] ?? null),
            competition_origine: Cast::object($data['competition_origine'] ?? null, CompetitionOrigine::class),
            competition_origine_nom: Cast::string($data['competition_origine_nom'] ?? null),
            creationEnCours: Cast::bool($data['creationEnCours'] ?? null),
            id: Cast::string($data['id'] ?? null),
            liveStat: Cast::bool($data['liveStat'] ?? null),
            logo: Cast::object($data['logo'] ?? null, Logo::class),
            nom: Cast::string($data['nom'] ?? null),
            nomExtended: Cast::string($data['nomExtended'] ?? null),
            pro: Cast::bool($data['pro'] ?? null),
            publicationInternet: Cast::string($data['publicationInternet'] ?? null),
            sexe: Cast::string($data['sexe'] ?? null),
            typeCompetition: Cast::string($data['typeCompetition'] ?? null),
            typeCompetitionGenerique: Cast::object($data['typeCompetitionGenerique'] ?? null, CompetitionIDTypeCompetitionGenerique::class),
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
