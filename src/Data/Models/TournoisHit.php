<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Hit Meilisearch de l'index `ffbbserver_tournois` (modèle Python TerrainsHit (le SDK Python l'associe à un autre index)).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class TournoisHit
{
    public const string INDEX = 'ffbbserver_tournois';

    public function __construct(
        public ?Geo $_geo = null,
        public ?string $adresse = null,
        public ?string $adresseComplement = null,
        public ?int $ageMax = null,
        public ?int $ageMin = null,
        public ?Cartographie $cartographie = null,
        public ?int $categorieChampionnat3x3Id = null,
        public ?string $categorieChampionnat3x3Libelle = null,
        public ?string $code = null,
        public ?Commune $commune = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?DateTimeImmutable $debut = null,
        public ?int $debut_timestamp = null,
        public ?string $description = null,
        public ?DocumentFlyer $document_flyer = null,
        public ?DateTimeImmutable $fin = null,
        public ?int $fin_timestamp = null,
        public ?int $id = null,
        public ?string $mailOrganisateur = null,
        public ?int $nbParticipantPrevu = null,
        public ?string $nom = null,
        public ?string $nomOrganisateur = null,
        public ?string $sexe = null,
        public ?string $siteChoisi = null,
        public ?int $tarifOrganisateur = null,
        public ?string $telephoneOrganisateur = null,
        public ?string $thumbnail = null,
        public ?string $tournoiType = null,
        /** @var list<TournoiTypes3X3>|null */
        public ?array $tournoiTypes3x3 = null,
        public ?string $urlOrganisateur = null,
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
            adresse: Cast::string($data['adresse'] ?? null),
            adresseComplement: Cast::string($data['adresseComplement'] ?? null),
            ageMax: Cast::int($data['ageMax'] ?? null),
            ageMin: Cast::int($data['ageMin'] ?? null),
            cartographie: Cast::object($data['cartographie'] ?? null, Cartographie::class),
            categorieChampionnat3x3Id: Cast::int($data['categorieChampionnat3x3Id'] ?? null),
            categorieChampionnat3x3Libelle: Cast::string($data['categorieChampionnat3x3Libelle'] ?? null),
            code: Cast::string($data['code'] ?? null),
            commune: Cast::object($data['commune'] ?? null, Commune::class),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            debut: Cast::dateTime($data['debut'] ?? null),
            debut_timestamp: Cast::int($data['debut_timestamp'] ?? null),
            description: Cast::string($data['description'] ?? null),
            document_flyer: Cast::object($data['document_flyer'] ?? null, DocumentFlyer::class),
            fin: Cast::dateTime($data['fin'] ?? null),
            fin_timestamp: Cast::int($data['fin_timestamp'] ?? null),
            id: Cast::int($data['id'] ?? null),
            mailOrganisateur: Cast::string($data['mailOrganisateur'] ?? null),
            nbParticipantPrevu: Cast::int($data['nbParticipantPrevu'] ?? null),
            nom: Cast::string($data['nom'] ?? null),
            nomOrganisateur: Cast::string($data['nomOrganisateur'] ?? null),
            sexe: Cast::string($data['sexe'] ?? null),
            siteChoisi: Cast::string($data['siteChoisi'] ?? null),
            tarifOrganisateur: Cast::int($data['tarifOrganisateur'] ?? null),
            telephoneOrganisateur: Cast::string($data['telephoneOrganisateur'] ?? null),
            thumbnail: Cast::string($data['thumbnail'] ?? null),
            tournoiType: Cast::string($data['tournoiType'] ?? null),
            tournoiTypes3x3: Cast::listOf($data['tournoiTypes3x3'] ?? null, TournoiTypes3X3::class),
            urlOrganisateur: Cast::string($data['urlOrganisateur'] ?? null),
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
