<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_rencontres` (schéma OpenAPI ItemsFfbbserverRencontres).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class RencontresItem
{
    public const string COLLECTION = 'ffbbserver_rencontres';

    public function __construct(
        public ?CompetitionsItem $competitionId = null,
        public ?DateTimeImmutable $creation = null,
        public ?DateTimeImmutable $date = null,
        public ?DateTimeImmutable $dateSaisieResultat = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_rencontre = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?bool $defautEquipe1 = null,
        public ?bool $defautEquipe2 = null,
        public ?string $etat = null,
        public ?bool $forfaitEquipe1 = null,
        public ?bool $forfaitEquipe2 = null,
        public GeniusSportMatchesItem|string|int|null $gsId = null,
        public ?int $handicap1 = null,
        public ?int $handicap2 = null,
        public ?int $horaire = null,
        public ?string $id = null,
        public ?EngagementsItem $idEngagementEquipe1 = null,
        public ?EngagementsItem $idEngagementEquipe2 = null,
        public ?OrganismesItem $idOrganismeEquipe1 = null,
        public ?OrganismesItem $idOrganismeEquipe2 = null,
        public ?PoulesItem $idPoule = null,
        public ?bool $joue = null,
        public ?DateTimeImmutable $modification = null,
        public ?string $nomEquipe1 = null,
        public ?string $nomEquipe2 = null,
        public ?int $numero = null,
        public ?string $numeroJournee = null,
        /** @var list<OfficielsRencontresItem>|null */
        public ?array $officiels = null,
        public ?bool $penaliteEquipe1 = null,
        public ?bool $penaliteEquipe2 = null,
        public ?string $pratique = null,
        /** @var list<RematchVideosItem|string|int>|null */
        public ?array $rematch_videos = null,
        public ?bool $remise = null,
        public ?int $resultatEquipe1 = null,
        public ?int $resultatEquipe2 = null,
        public ?SaisonsItem $saison = null,
        public ?SallesItem $salle = null,
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
            competitionId: Cast::related($data['competitionId'] ?? null, CompetitionsItem::class),
            creation: Cast::dateTime($data['creation'] ?? null),
            date: Cast::dateTime($data['date'] ?? null),
            dateSaisieResultat: Cast::dateTime($data['dateSaisieResultat'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_rencontre: Cast::dateTime($data['date_rencontre'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            defautEquipe1: Cast::bool($data['defautEquipe1'] ?? null),
            defautEquipe2: Cast::bool($data['defautEquipe2'] ?? null),
            etat: Cast::string($data['etat'] ?? null),
            forfaitEquipe1: Cast::bool($data['forfaitEquipe1'] ?? null),
            forfaitEquipe2: Cast::bool($data['forfaitEquipe2'] ?? null),
            gsId: Cast::relation($data['gsId'] ?? null, GeniusSportMatchesItem::class),
            handicap1: Cast::int($data['handicap1'] ?? null),
            handicap2: Cast::int($data['handicap2'] ?? null),
            horaire: Cast::int($data['horaire'] ?? null),
            id: Cast::string($data['id'] ?? null),
            idEngagementEquipe1: Cast::related($data['idEngagementEquipe1'] ?? null, EngagementsItem::class),
            idEngagementEquipe2: Cast::related($data['idEngagementEquipe2'] ?? null, EngagementsItem::class),
            idOrganismeEquipe1: Cast::related($data['idOrganismeEquipe1'] ?? null, OrganismesItem::class),
            idOrganismeEquipe2: Cast::related($data['idOrganismeEquipe2'] ?? null, OrganismesItem::class),
            idPoule: Cast::related($data['idPoule'] ?? null, PoulesItem::class),
            joue: Cast::bool($data['joue'] ?? null),
            modification: Cast::dateTime($data['modification'] ?? null),
            nomEquipe1: Cast::string($data['nomEquipe1'] ?? null),
            nomEquipe2: Cast::string($data['nomEquipe2'] ?? null),
            numero: Cast::int($data['numero'] ?? null),
            numeroJournee: Cast::string($data['numeroJournee'] ?? null),
            officiels: Cast::relatedList($data['officiels'] ?? null, OfficielsRencontresItem::class),
            penaliteEquipe1: Cast::bool($data['penaliteEquipe1'] ?? null),
            penaliteEquipe2: Cast::bool($data['penaliteEquipe2'] ?? null),
            pratique: Cast::string($data['pratique'] ?? null),
            rematch_videos: Cast::relations($data['rematch_videos'] ?? null, RematchVideosItem::class),
            remise: Cast::bool($data['remise'] ?? null),
            resultatEquipe1: Cast::int($data['resultatEquipe1'] ?? null),
            resultatEquipe2: Cast::int($data['resultatEquipe2'] ?? null),
            saison: Cast::related($data['saison'] ?? null, SaisonsItem::class),
            salle: Cast::related($data['salle'] ?? null, SallesItem::class),
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
