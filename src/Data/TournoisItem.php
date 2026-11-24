<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_tournois` (schéma OpenAPI ItemsFfbbserverTournois).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class TournoisItem
{
    public const string COLLECTION = 'ffbbserver_tournois';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?string $adresse = null,
        public ?string $adresseComplement = null,
        public ?int $ageMax = null,
        public ?int $ageMin = null,
        public ?CartographiesItem $cartographie = null,
        public ?string $categorieChampionnat3x3Id = null,
        public ?string $categorieChampionnat3x3Libelle = null,
        public ?string $code = null,
        public ?CommunesItem $commune = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?DateTimeImmutable $debut = null,
        public ?string $description = null,
        public mixed $document_flyer = null,
        public ?DateTimeImmutable $fin = null,
        public ?string $id = null,
        public ?string $mailOrganisateur = null,
        public ?int $nbParticipantPrevu = null,
        public ?string $nom = null,
        public ?string $nomOrganisateur = null,
        public ?string $sexe = null,
        public ?string $siteChoisi = null,
        public ?string $tarifOrganisateur = null,
        public ?string $telephoneOrganisateur = null,
        public ?TypesTournoisItem $tournoiType = null,
        /** @var list<TournoisFfbbserverTypesTournois3x3Item>|null */
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
            adresse: Cast::string($data['adresse'] ?? null),
            adresseComplement: Cast::string($data['adresseComplement'] ?? null),
            ageMax: Cast::int($data['ageMax'] ?? null),
            ageMin: Cast::int($data['ageMin'] ?? null),
            cartographie: Cast::related($data['cartographie'] ?? null, CartographiesItem::class),
            categorieChampionnat3x3Id: Cast::string($data['categorieChampionnat3x3Id'] ?? null),
            categorieChampionnat3x3Libelle: Cast::string($data['categorieChampionnat3x3Libelle'] ?? null),
            code: Cast::string($data['code'] ?? null),
            commune: Cast::related($data['commune'] ?? null, CommunesItem::class),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            debut: Cast::dateTime($data['debut'] ?? null),
            description: Cast::string($data['description'] ?? null),
            document_flyer: $data['document_flyer'] ?? null,
            fin: Cast::dateTime($data['fin'] ?? null),
            id: Cast::string($data['id'] ?? null),
            mailOrganisateur: Cast::string($data['mailOrganisateur'] ?? null),
            nbParticipantPrevu: Cast::int($data['nbParticipantPrevu'] ?? null),
            nom: Cast::string($data['nom'] ?? null),
            nomOrganisateur: Cast::string($data['nomOrganisateur'] ?? null),
            sexe: Cast::string($data['sexe'] ?? null),
            siteChoisi: Cast::string($data['siteChoisi'] ?? null),
            tarifOrganisateur: Cast::string($data['tarifOrganisateur'] ?? null),
            telephoneOrganisateur: Cast::string($data['telephoneOrganisateur'] ?? null),
            tournoiType: Cast::related($data['tournoiType'] ?? null, TypesTournoisItem::class),
            tournoiTypes3x3: Cast::relatedList($data['tournoiTypes3x3'] ?? null, TournoisFfbbserverTypesTournois3x3Item::class),
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
