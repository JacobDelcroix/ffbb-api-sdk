<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_rencontres` (schéma OpenAPI ItemsFfbbserverRencontres).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class RencontresItem
{
    public const string COLLECTION = 'ffbbserver_rencontres';

    public function __construct(
        public CompetitionsItem|string|int|null $competitionId = null,
        public ?string $creation = null,
        public ?string $date = null,
        public ?string $dateSaisieResultat = null,
        public ?string $date_created = null,
        public ?string $date_rencontre = null,
        public ?string $date_updated = null,
        public ?bool $defautEquipe1 = null,
        public ?bool $defautEquipe2 = null,
        public ?string $etat = null,
        public ?bool $forfaitEquipe1 = null,
        public ?bool $forfaitEquipe2 = null,
        public mixed $gsId = null,
        public ?int $handicap1 = null,
        public ?int $handicap2 = null,
        public ?int $horaire = null,
        public ?string $id = null,
        public EngagementsItem|string|int|null $idEngagementEquipe1 = null,
        public EngagementsItem|string|int|null $idEngagementEquipe2 = null,
        public OrganismesItem|string|int|null $idOrganismeEquipe1 = null,
        public OrganismesItem|string|int|null $idOrganismeEquipe2 = null,
        public PoulesItem|string|int|null $idPoule = null,
        public ?bool $joue = null,
        public ?string $modification = null,
        public ?string $nomEquipe1 = null,
        public ?string $nomEquipe2 = null,
        public ?int $numero = null,
        public ?string $numeroJournee = null,
        /** @var list<OfficielsRencontresItem|string|int>|null */
        public ?array $officiels = null,
        public ?bool $penaliteEquipe1 = null,
        public ?bool $penaliteEquipe2 = null,
        public ?string $pratique = null,
        /** @var list<mixed>|null */
        public ?array $rematch_videos = null,
        public ?bool $remise = null,
        public ?int $resultatEquipe1 = null,
        public ?int $resultatEquipe2 = null,
        public SaisonsItem|string|int|null $saison = null,
        public SallesItem|string|int|null $salle = null,
        public ?string $status = null,
        public ?bool $toUpdate = null,
        public ?string $uniqueKey = null,
        public ?string $url_competition = null,
        public ?bool $validee = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            competitionId: Cast::relation($data['competitionId'] ?? null, CompetitionsItem::class),
            creation: Cast::string($data['creation'] ?? null),
            date: Cast::string($data['date'] ?? null),
            dateSaisieResultat: Cast::string($data['dateSaisieResultat'] ?? null),
            date_created: Cast::string($data['date_created'] ?? null),
            date_rencontre: Cast::string($data['date_rencontre'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            defautEquipe1: Cast::bool($data['defautEquipe1'] ?? null),
            defautEquipe2: Cast::bool($data['defautEquipe2'] ?? null),
            etat: Cast::string($data['etat'] ?? null),
            forfaitEquipe1: Cast::bool($data['forfaitEquipe1'] ?? null),
            forfaitEquipe2: Cast::bool($data['forfaitEquipe2'] ?? null),
            gsId: $data['gsId'] ?? null,
            handicap1: Cast::int($data['handicap1'] ?? null),
            handicap2: Cast::int($data['handicap2'] ?? null),
            horaire: Cast::int($data['horaire'] ?? null),
            id: Cast::string($data['id'] ?? null),
            idEngagementEquipe1: Cast::relation($data['idEngagementEquipe1'] ?? null, EngagementsItem::class),
            idEngagementEquipe2: Cast::relation($data['idEngagementEquipe2'] ?? null, EngagementsItem::class),
            idOrganismeEquipe1: Cast::relation($data['idOrganismeEquipe1'] ?? null, OrganismesItem::class),
            idOrganismeEquipe2: Cast::relation($data['idOrganismeEquipe2'] ?? null, OrganismesItem::class),
            idPoule: Cast::relation($data['idPoule'] ?? null, PoulesItem::class),
            joue: Cast::bool($data['joue'] ?? null),
            modification: Cast::string($data['modification'] ?? null),
            nomEquipe1: Cast::string($data['nomEquipe1'] ?? null),
            nomEquipe2: Cast::string($data['nomEquipe2'] ?? null),
            numero: Cast::int($data['numero'] ?? null),
            numeroJournee: Cast::string($data['numeroJournee'] ?? null),
            officiels: Cast::relations($data['officiels'] ?? null, OfficielsRencontresItem::class),
            penaliteEquipe1: Cast::bool($data['penaliteEquipe1'] ?? null),
            penaliteEquipe2: Cast::bool($data['penaliteEquipe2'] ?? null),
            pratique: Cast::string($data['pratique'] ?? null),
            rematch_videos: Cast::relations($data['rematch_videos'] ?? null, null),
            remise: Cast::bool($data['remise'] ?? null),
            resultatEquipe1: Cast::int($data['resultatEquipe1'] ?? null),
            resultatEquipe2: Cast::int($data['resultatEquipe2'] ?? null),
            saison: Cast::relation($data['saison'] ?? null, SaisonsItem::class),
            salle: Cast::relation($data['salle'] ?? null, SallesItem::class),
            status: Cast::string($data['status'] ?? null),
            toUpdate: Cast::bool($data['toUpdate'] ?? null),
            uniqueKey: Cast::string($data['uniqueKey'] ?? null),
            url_competition: Cast::string($data['url_competition'] ?? null),
            validee: Cast::bool($data['validee'] ?? null),
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
