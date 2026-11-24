<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Hit Meilisearch de l'index `ffbbserver_rencontres` (modèle Python RencontresHit, complété par 9 attribut(s) observé(s)).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class RencontresHit
{
    public const string INDEX = 'ffbbserver_rencontres';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [
        'competition' => 'competitionId',
        'engagementEquipe1' => 'idEngagementEquipe1',
        'engagementEquipe2' => 'idEngagementEquipe2',
        'organismeEquipe1' => 'idOrganismeEquipe1',
        'organismeEquipe2' => 'idOrganismeEquipe2',
        'poule' => 'idPoule',
    ];

    public function __construct(
        public ?Geo $_geo = null,
        /** Champ Directus : competitionId */
        public ?CompetitionID $competition = null,
        public ?int $creation_timestamp = null,
        public ?DateTimeImmutable $date = null,
        public ?int $dateSaisieResultat_timestamp = null,
        public ?DateTimeImmutable $date_rencontre = null,
        public ?int $date_rencontre_timestamp = null,
        public ?int $date_timestamp = null,
        /** Champ Directus : idEngagementEquipe1 */
        public ?IDEngagementEquipe $engagementEquipe1 = null,
        /** Champ Directus : idEngagementEquipe2 */
        public ?IDEngagementEquipe $engagementEquipe2 = null,
        public ?string $gsId = null,
        public ?int $handicap1 = null,
        public ?int $handicap2 = null,
        public ?string $horaire = null,
        public ?string $id = null,
        public ?bool $joue = null,
        public ?int $modification_timestamp = null,
        public ?string $niveau = null,
        public ?int $niveau_nb = null,
        public ?string $nomEquipe1 = null,
        public ?string $nomEquipe2 = null,
        public ?int $numeroJournee = null,
        /** @var list<mixed>|null */
        public ?array $officiels = null,
        public ?string $officiels_string = null,
        public ?Organisateur $organisateur = null,
        /** Champ Directus : idOrganismeEquipe1 */
        public ?IDOrganismeEquipe $organismeEquipe1 = null,
        /** Champ Directus : idOrganismeEquipe2 */
        public ?IDOrganismeEquipe $organismeEquipe2 = null,
        /** Champ Directus : idPoule */
        public ?IDPoule $poule = null,
        public ?string $pratique = null,
        /** @var list<mixed>|null */
        public ?array $rematch_videos = null,
        public ?int $resultatEquipe1 = null,
        public ?int $resultatEquipe2 = null,
        public ?Saison $saison = null,
        public ?Salle $salle = null,
        public ?string $thumbnail = null,
        public ?string $uniqueKey = null,
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
            _geo: Cast::object($data['_geo'] ?? null, Geo::class),
            competition: Cast::object($data['competitionId'] ?? null, CompetitionID::class),
            creation_timestamp: Cast::int($data['creation_timestamp'] ?? null),
            date: Cast::dateTime($data['date'] ?? null),
            dateSaisieResultat_timestamp: Cast::int($data['dateSaisieResultat_timestamp'] ?? null),
            date_rencontre: Cast::dateTime($data['date_rencontre'] ?? null),
            date_rencontre_timestamp: Cast::int($data['date_rencontre_timestamp'] ?? null),
            date_timestamp: Cast::int($data['date_timestamp'] ?? null),
            engagementEquipe1: Cast::object($data['idEngagementEquipe1'] ?? null, IDEngagementEquipe::class),
            engagementEquipe2: Cast::object($data['idEngagementEquipe2'] ?? null, IDEngagementEquipe::class),
            gsId: Cast::string($data['gsId'] ?? null),
            handicap1: Cast::int($data['handicap1'] ?? null),
            handicap2: Cast::int($data['handicap2'] ?? null),
            horaire: Cast::string($data['horaire'] ?? null),
            id: Cast::string($data['id'] ?? null),
            joue: Cast::bool($data['joue'] ?? null),
            modification_timestamp: Cast::int($data['modification_timestamp'] ?? null),
            niveau: Cast::string($data['niveau'] ?? null),
            niveau_nb: Cast::int($data['niveau_nb'] ?? null),
            nomEquipe1: Cast::string($data['nomEquipe1'] ?? null),
            nomEquipe2: Cast::string($data['nomEquipe2'] ?? null),
            numeroJournee: Cast::int($data['numeroJournee'] ?? null),
            officiels: Cast::listOf($data['officiels'] ?? null, 'raw'),
            officiels_string: Cast::string($data['officiels_string'] ?? null),
            organisateur: Cast::object($data['organisateur'] ?? null, Organisateur::class),
            organismeEquipe1: Cast::object($data['idOrganismeEquipe1'] ?? null, IDOrganismeEquipe::class),
            organismeEquipe2: Cast::object($data['idOrganismeEquipe2'] ?? null, IDOrganismeEquipe::class),
            poule: Cast::object($data['idPoule'] ?? null, IDPoule::class),
            pratique: Cast::string($data['pratique'] ?? null),
            rematch_videos: Cast::array($data['rematch_videos'] ?? null),
            resultatEquipe1: Cast::int($data['resultatEquipe1'] ?? null),
            resultatEquipe2: Cast::int($data['resultatEquipe2'] ?? null),
            saison: Cast::object($data['saison'] ?? null, Saison::class),
            salle: Cast::object($data['salle'] ?? null, Salle::class),
            thumbnail: Cast::string($data['thumbnail'] ?? null),
            uniqueKey: Cast::string($data['uniqueKey'] ?? null),
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
