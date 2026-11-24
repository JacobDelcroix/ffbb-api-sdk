<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_competitions` (schéma OpenAPI ItemsFfbbserverCompetitions).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class CompetitionsItem
{
    public const string COLLECTION = 'ffbbserver_competitions';

    public function __construct(
        public CategoriesChampionnatsItem|string|int|null $categorie = null,
        public ?string $code = null,
        public ?bool $compare_old_site = null,
        public CompetitionsItem|string|int|null $competition_origine = null,
        public ?int $competition_origine_niveau = null,
        public ?string $competition_origine_nom = null,
        public ?bool $creationEnCours = null,
        public ?string $date_created = null,
        public ?string $date_updated = null,
        public ?bool $emarqueV2 = null,
        public ?string $etat = null,
        public ?string $id = null,
        public CompetitionsItem|string|int|null $idCompetitionPere = null,
        public ?bool $liveStat = null,
        public mixed $logo = null,
        public ?string $nom = null,
        public ?int $ordre = null,
        public OrganismesItem|string|int|null $organisateur = null,
        public ?string $phase_code = null,
        /** @var list<CompetitionsItem|string|int>|null */
        public ?array $phases = null,
        /** @var list<PoulesItem|string|int>|null */
        public ?array $poules = null,
        public ?bool $pro = null,
        public ?string $publicationInternet = null,
        public SaisonsItem|string|int|null $saison = null,
        public ?string $sexe = null,
        public ?string $slug = null,
        public ?bool $toUpdate = null,
        public ?string $typeCompetition = null,
        public TypesCompetitionsItem|string|int|null $typeCompetitionGenerique = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            categorie: Cast::relation($data['categorie'] ?? null, CategoriesChampionnatsItem::class),
            code: Cast::string($data['code'] ?? null),
            compare_old_site: Cast::bool($data['compare_old_site'] ?? null),
            competition_origine: Cast::relation($data['competition_origine'] ?? null, CompetitionsItem::class),
            competition_origine_niveau: Cast::int($data['competition_origine_niveau'] ?? null),
            competition_origine_nom: Cast::string($data['competition_origine_nom'] ?? null),
            creationEnCours: Cast::bool($data['creationEnCours'] ?? null),
            date_created: Cast::string($data['date_created'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            emarqueV2: Cast::bool($data['emarqueV2'] ?? null),
            etat: Cast::string($data['etat'] ?? null),
            id: Cast::string($data['id'] ?? null),
            idCompetitionPere: Cast::relation($data['idCompetitionPere'] ?? null, CompetitionsItem::class),
            liveStat: Cast::bool($data['liveStat'] ?? null),
            logo: $data['logo'] ?? null,
            nom: Cast::string($data['nom'] ?? null),
            ordre: Cast::int($data['ordre'] ?? null),
            organisateur: Cast::relation($data['organisateur'] ?? null, OrganismesItem::class),
            phase_code: Cast::string($data['phase_code'] ?? null),
            phases: Cast::relations($data['phases'] ?? null, CompetitionsItem::class),
            poules: Cast::relations($data['poules'] ?? null, PoulesItem::class),
            pro: Cast::bool($data['pro'] ?? null),
            publicationInternet: Cast::string($data['publicationInternet'] ?? null),
            saison: Cast::relation($data['saison'] ?? null, SaisonsItem::class),
            sexe: Cast::string($data['sexe'] ?? null),
            slug: Cast::string($data['slug'] ?? null),
            toUpdate: Cast::bool($data['toUpdate'] ?? null),
            typeCompetition: Cast::string($data['typeCompetition'] ?? null),
            typeCompetitionGenerique: Cast::relation($data['typeCompetitionGenerique'] ?? null, TypesCompetitionsItem::class),
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
