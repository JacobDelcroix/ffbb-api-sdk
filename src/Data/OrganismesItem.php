<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_organismes` (schéma OpenAPI ItemsFfbbserverOrganismes).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class OrganismesItem
{
    public const string COLLECTION = 'ffbbserver_organismes';

    public function __construct(
        public ?string $adresse = null,
        public ?string $adresseClubPro = null,
        public CartographiesItem|string|int|null $cartographie = null,
        public ?string $code = null,
        public CommunesItem|string|int|null $commune = null,
        public CommunesItem|string|int|null $communeClubPro = null,
        /** @var list<CompetitionsItem|string|int>|null */
        public ?array $competitions = null,
        public ?string $dateAffiliation = null,
        public ?string $date_created = null,
        public ?string $date_updated = null,
        /** @var list<EngagementsItem|string|int>|null */
        public ?array $engagements = null,
        public ?bool $entreprise = null,
        public ?bool $handibasket = null,
        public ?bool $horsAssociation = null,
        public ?string $id = null,
        /** @var list<LabellisationsOrganismesItem|string|int>|null */
        public ?array $labellisation = null,
        public mixed $logo = null,
        public ?string $logo_base64 = null,
        public ?string $mail = null,
        /** @var list<MembresItem|string|int>|null */
        public ?array $membres = null,
        public ?string $nom = null,
        public ?string $nomClubPro = null,
        public ?string $nom_simple = null,
        /** @var list<OrganismesFfbbserverOffresPratiquesItem|string|int>|null */
        public ?array $offresPratiques = null,
        public ?bool $omnisport = null,
        public OrganismesItem|string|int|null $organisme_id_pere = null,
        /** @var list<OrganismesItem|string|int>|null */
        public ?array $organismes_fils = null,
        public ?string $saison = null,
        public ?bool $saison_en_cours = null,
        public SallesItem|string|int|null $salle = null,
        public ?string $telephone = null,
        public ?string $type = null,
        public TypesAssociationsItem|string|int|null $type_association = null,
        public ?string $urlSiteWeb = null,
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
            adresse: Cast::string($data['adresse'] ?? null),
            adresseClubPro: Cast::string($data['adresseClubPro'] ?? null),
            cartographie: Cast::relation($data['cartographie'] ?? null, CartographiesItem::class),
            code: Cast::string($data['code'] ?? null),
            commune: Cast::relation($data['commune'] ?? null, CommunesItem::class),
            communeClubPro: Cast::relation($data['communeClubPro'] ?? null, CommunesItem::class),
            competitions: Cast::relations($data['competitions'] ?? null, CompetitionsItem::class),
            dateAffiliation: Cast::string($data['dateAffiliation'] ?? null),
            date_created: Cast::string($data['date_created'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            engagements: Cast::relations($data['engagements'] ?? null, EngagementsItem::class),
            entreprise: Cast::bool($data['entreprise'] ?? null),
            handibasket: Cast::bool($data['handibasket'] ?? null),
            horsAssociation: Cast::bool($data['horsAssociation'] ?? null),
            id: Cast::string($data['id'] ?? null),
            labellisation: Cast::relations($data['labellisation'] ?? null, LabellisationsOrganismesItem::class),
            logo: $data['logo'] ?? null,
            logo_base64: Cast::string($data['logo_base64'] ?? null),
            mail: Cast::string($data['mail'] ?? null),
            membres: Cast::relations($data['membres'] ?? null, MembresItem::class),
            nom: Cast::string($data['nom'] ?? null),
            nomClubPro: Cast::string($data['nomClubPro'] ?? null),
            nom_simple: Cast::string($data['nom_simple'] ?? null),
            offresPratiques: Cast::relations($data['offresPratiques'] ?? null, OrganismesFfbbserverOffresPratiquesItem::class),
            omnisport: Cast::bool($data['omnisport'] ?? null),
            organisme_id_pere: Cast::relation($data['organisme_id_pere'] ?? null, OrganismesItem::class),
            organismes_fils: Cast::relations($data['organismes_fils'] ?? null, OrganismesItem::class),
            saison: Cast::string($data['saison'] ?? null),
            saison_en_cours: Cast::bool($data['saison_en_cours'] ?? null),
            salle: Cast::relation($data['salle'] ?? null, SallesItem::class),
            telephone: Cast::string($data['telephone'] ?? null),
            type: Cast::string($data['type'] ?? null),
            type_association: Cast::relation($data['type_association'] ?? null, TypesAssociationsItem::class),
            urlSiteWeb: Cast::string($data['urlSiteWeb'] ?? null),
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
