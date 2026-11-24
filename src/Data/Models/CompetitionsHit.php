<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Hit Meilisearch de l'index `ffbbserver_competitions` (modèle Python CompetitionsHit, complété par 8 attribut(s) observé(s)).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class CompetitionsHit
{
    public const string INDEX = 'ffbbserver_competitions';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?string $age = null,
        public ?Categorie $categorie = null,
        public ?string $code = null,
        public ?string $codeComite = null,
        public ?string $codeLigue = null,
        public ?bool $compare_old_site = null,
        public ?string $competition_origine = null,
        public ?int $competition_origine_niveau = null,
        public ?string $competition_origine_nom = null,
        public ?bool $creationEnCours = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?bool $emarqueV2 = null,
        public ?string $etat = null,
        public ?string $id = null,
        public ?string $idCompetitionPere = null,
        public ?bool $liveStat = null,
        public ?Logo $logo = null,
        public ?string $niveau = null,
        public ?int $niveau_nb = null,
        public ?string $nom = null,
        public ?int $ordre = null,
        public ?Organisateur $organisateur = null,
        public ?string $participants = null,
        public ?string $phase_code = null,
        /** @var list<string>|null */
        public ?array $phases = null,
        /** @var list<Poule>|null */
        public ?array $poules = null,
        public ?bool $pro = null,
        public ?string $publicationInternet = null,
        public ?Saison $saison = null,
        public ?string $sexe = null,
        public ?string $slug = null,
        public ?string $thumbnail = null,
        public ?bool $toUpdate = null,
        public ?string $typeCompetition = null,
        public ?TypeCompetitionGenerique $typeCompetitionGenerique = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            age: Cast::string($data['age'] ?? null),
            categorie: Cast::object($data['categorie'] ?? null, Categorie::class),
            code: Cast::string($data['code'] ?? null),
            codeComite: Cast::string($data['codeComite'] ?? null),
            codeLigue: Cast::string($data['codeLigue'] ?? null),
            compare_old_site: Cast::bool($data['compare_old_site'] ?? null),
            competition_origine: Cast::string($data['competition_origine'] ?? null),
            competition_origine_niveau: Cast::int($data['competition_origine_niveau'] ?? null),
            competition_origine_nom: Cast::string($data['competition_origine_nom'] ?? null),
            creationEnCours: Cast::bool($data['creationEnCours'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            emarqueV2: Cast::bool($data['emarqueV2'] ?? null),
            etat: Cast::string($data['etat'] ?? null),
            id: Cast::string($data['id'] ?? null),
            idCompetitionPere: Cast::string($data['idCompetitionPere'] ?? null),
            liveStat: Cast::bool($data['liveStat'] ?? null),
            logo: Cast::object($data['logo'] ?? null, Logo::class),
            niveau: Cast::string($data['niveau'] ?? null),
            niveau_nb: Cast::int($data['niveau_nb'] ?? null),
            nom: Cast::string($data['nom'] ?? null),
            ordre: Cast::int($data['ordre'] ?? null),
            organisateur: Cast::object($data['organisateur'] ?? null, Organisateur::class),
            participants: Cast::string($data['participants'] ?? null),
            phase_code: Cast::string($data['phase_code'] ?? null),
            phases: Cast::listOf($data['phases'] ?? null, 'string'),
            poules: Cast::listOf($data['poules'] ?? null, Poule::class),
            pro: Cast::bool($data['pro'] ?? null),
            publicationInternet: Cast::string($data['publicationInternet'] ?? null),
            saison: Cast::object($data['saison'] ?? null, Saison::class),
            sexe: Cast::string($data['sexe'] ?? null),
            slug: Cast::string($data['slug'] ?? null),
            thumbnail: Cast::string($data['thumbnail'] ?? null),
            toUpdate: Cast::bool($data['toUpdate'] ?? null),
            typeCompetition: Cast::string($data['typeCompetition'] ?? null),
            typeCompetitionGenerique: Cast::object($data['typeCompetitionGenerique'] ?? null, TypeCompetitionGenerique::class),
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
