<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_engagements` (schéma OpenAPI ItemsFfbbserverEngagements).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class EngagementsItem
{
    public const string COLLECTION = 'ffbbserver_engagements';

    public function __construct(
        public ?string $adresseCorrespondantEquipe = null,
        /** @var list<PoulesClassementsItem>|null */
        public ?array $classement = null,
        public ?bool $clubPro = null,
        public ?string $codeAbrege = null,
        public ?string $communeCorrespondantEquipe = null,
        public ?string $complementAdresseCorrespondantEquipe = null,
        public ?DateTimeImmutable $creation = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?string $emailCorrespondantEquipe = null,
        public EntraineursItem|string|int|null $entraineur = null,
        public EntraineursItem|string|int|null $entraineurAdjoint = null,
        public ?bool $forfaitGeneral = null,
        public ?string $id = null,
        public ?CompetitionsItem $idCompetition = null,
        public ?OrganismesItem $idOrganisme = null,
        public ?OrganismesItem $idOrganismeCtc = null,
        public ?PoulesItem $idPoule = null,
        public mixed $logo = null,
        public ?string $logo_genius = null,
        public ?DateTimeImmutable $modification = null,
        public ?TypesDivisionsItem $niveau = null,
        public ?string $nom = null,
        public ?string $nomCorrespondantEquipe = null,
        public ?string $nomCtc = null,
        public ?string $nomEquipe = null,
        public ?string $nomOfficiel = null,
        public ?string $nomUsuel = null,
        public ?string $numeroEquipe = null,
        public ?string $photo = null,
        public ?int $position = null,
        public ?int $positionVariation = null,
        public ?int $position_n1 = null,
        public mixed $positions = null,
        public ?string $pouleId = null,
        /** @var list<RencontresItem>|null */
        public ?array $rencontres_domiciles = null,
        /** @var list<RencontresItem>|null */
        public ?array $rencontres_exterieur = null,
        public ?string $telephoneFixeCorrespondantEquipe = null,
        public ?string $telephonePortableCorrespondantEquipe = null,
        public ?string $telephoneTravailCorrespondantEquipe = null,
        public ?bool $toUpdate = null,
        public ?string $typeEntenteCtc = null,
        public ?string $url_competition = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            adresseCorrespondantEquipe: Cast::string($data['adresseCorrespondantEquipe'] ?? null),
            classement: Cast::relatedList($data['classement'] ?? null, PoulesClassementsItem::class),
            clubPro: Cast::bool($data['clubPro'] ?? null),
            codeAbrege: Cast::string($data['codeAbrege'] ?? null),
            communeCorrespondantEquipe: Cast::string($data['communeCorrespondantEquipe'] ?? null),
            complementAdresseCorrespondantEquipe: Cast::string($data['complementAdresseCorrespondantEquipe'] ?? null),
            creation: Cast::dateTime($data['creation'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            emailCorrespondantEquipe: Cast::string($data['emailCorrespondantEquipe'] ?? null),
            entraineur: Cast::relation($data['entraineur'] ?? null, EntraineursItem::class),
            entraineurAdjoint: Cast::relation($data['entraineurAdjoint'] ?? null, EntraineursItem::class),
            forfaitGeneral: Cast::bool($data['forfaitGeneral'] ?? null),
            id: Cast::string($data['id'] ?? null),
            idCompetition: Cast::related($data['idCompetition'] ?? null, CompetitionsItem::class),
            idOrganisme: Cast::related($data['idOrganisme'] ?? null, OrganismesItem::class),
            idOrganismeCtc: Cast::related($data['idOrganismeCtc'] ?? null, OrganismesItem::class),
            idPoule: Cast::related($data['idPoule'] ?? null, PoulesItem::class),
            logo: $data['logo'] ?? null,
            logo_genius: Cast::string($data['logo_genius'] ?? null),
            modification: Cast::dateTime($data['modification'] ?? null),
            niveau: Cast::related($data['niveau'] ?? null, TypesDivisionsItem::class),
            nom: Cast::string($data['nom'] ?? null),
            nomCorrespondantEquipe: Cast::string($data['nomCorrespondantEquipe'] ?? null),
            nomCtc: Cast::string($data['nomCtc'] ?? null),
            nomEquipe: Cast::string($data['nomEquipe'] ?? null),
            nomOfficiel: Cast::string($data['nomOfficiel'] ?? null),
            nomUsuel: Cast::string($data['nomUsuel'] ?? null),
            numeroEquipe: Cast::string($data['numeroEquipe'] ?? null),
            photo: Cast::string($data['photo'] ?? null),
            position: Cast::int($data['position'] ?? null),
            positionVariation: Cast::int($data['positionVariation'] ?? null),
            position_n1: Cast::int($data['position_n1'] ?? null),
            positions: $data['positions'] ?? null,
            pouleId: Cast::string($data['pouleId'] ?? null),
            rencontres_domiciles: Cast::relatedList($data['rencontres_domiciles'] ?? null, RencontresItem::class),
            rencontres_exterieur: Cast::relatedList($data['rencontres_exterieur'] ?? null, RencontresItem::class),
            telephoneFixeCorrespondantEquipe: Cast::string($data['telephoneFixeCorrespondantEquipe'] ?? null),
            telephonePortableCorrespondantEquipe: Cast::string($data['telephonePortableCorrespondantEquipe'] ?? null),
            telephoneTravailCorrespondantEquipe: Cast::string($data['telephoneTravailCorrespondantEquipe'] ?? null),
            toUpdate: Cast::bool($data['toUpdate'] ?? null),
            typeEntenteCtc: Cast::string($data['typeEntenteCtc'] ?? null),
            url_competition: Cast::string($data['url_competition'] ?? null),
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
