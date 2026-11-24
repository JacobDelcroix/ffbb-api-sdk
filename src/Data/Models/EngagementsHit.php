<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Hit Meilisearch de l'index `ffbbserver_engagements` (modèle Python EngagementsHit).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EngagementsHit
{
    public const string INDEX = 'ffbbserver_engagements';

    public function __construct(
        public ?Geo $_geo = null,
        public ?string $age = null,
        public ?Categorie $categorie = null,
        public ?bool $clubPro = null,
        public ?string $codeAbrege = null,
        public ?string $codeClub = null,
        public ?string $codeComite = null,
        public ?string $codeLigue = null,
        public ?string $competitionsUrl = null,
        public ?string $gradient_color = null,
        public ?string $id = null,
        public ?CompetitionOrigine $idCompetition = null,
        public ?Poule $idPoule = null,
        public ?string $logo = null,
        public ?Categorie $niveau = null,
        public ?string $nom = null,
        public ?string $nomClub = null,
        public ?string $nomClubPro = null,
        public ?string $nomComite = null,
        public ?string $nomCtc = null,
        public ?string $nomEquipe = null,
        public ?string $nomLigue = null,
        public ?string $nomOfficiel = null,
        public ?string $nomOrganisme = null,
        public ?string $nomUsuel = null,
        public ?string $numeroEquipe = null,
        public ?string $sexe = null,
        public ?string $thumbnail = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            _geo: Cast::object($data['_geo'] ?? null, Geo::class),
            age: Cast::string($data['age'] ?? null),
            categorie: Cast::object($data['categorie'] ?? null, Categorie::class),
            clubPro: Cast::bool($data['clubPro'] ?? null),
            codeAbrege: Cast::string($data['codeAbrege'] ?? null),
            codeClub: Cast::string($data['codeClub'] ?? null),
            codeComite: Cast::string($data['codeComite'] ?? null),
            codeLigue: Cast::string($data['codeLigue'] ?? null),
            competitionsUrl: Cast::string($data['competitionsUrl'] ?? null),
            gradient_color: Cast::string($data['gradient_color'] ?? null),
            id: Cast::string($data['id'] ?? null),
            idCompetition: Cast::object($data['idCompetition'] ?? null, CompetitionOrigine::class),
            idPoule: Cast::object($data['idPoule'] ?? null, Poule::class),
            logo: Cast::string($data['logo'] ?? null),
            niveau: Cast::object($data['niveau'] ?? null, Categorie::class),
            nom: Cast::string($data['nom'] ?? null),
            nomClub: Cast::string($data['nomClub'] ?? null),
            nomClubPro: Cast::string($data['nomClubPro'] ?? null),
            nomComite: Cast::string($data['nomComite'] ?? null),
            nomCtc: Cast::string($data['nomCtc'] ?? null),
            nomEquipe: Cast::string($data['nomEquipe'] ?? null),
            nomLigue: Cast::string($data['nomLigue'] ?? null),
            nomOfficiel: Cast::string($data['nomOfficiel'] ?? null),
            nomOrganisme: Cast::string($data['nomOrganisme'] ?? null),
            nomUsuel: Cast::string($data['nomUsuel'] ?? null),
            numeroEquipe: Cast::string($data['numeroEquipe'] ?? null),
            sexe: Cast::string($data['sexe'] ?? null),
            thumbnail: Cast::string($data['thumbnail'] ?? null),
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
