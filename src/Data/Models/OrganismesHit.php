<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Hit Meilisearch de l'index `ffbbserver_organismes` (modèle Python OrganismesHit, complété par 4 attribut(s) observé(s)).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class OrganismesHit
{
    public const string INDEX = 'ffbbserver_organismes';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?Geo $_geo = null,
        public ?string $adresse = null,
        public ?string $adresseClubPro = null,
        public ?Cartographie $cartographie = null,
        public ?string $code = null,
        public ?string $code_emploi = null,
        public ?Commune $commune = null,
        public ?Commune $communeClubPro = null,
        public ?DateTimeImmutable $dateAffiliation = null,
        public ?string $engagements_codes = null,
        public ?string $engagements_noms = null,
        public ?string $id = null,
        /** @var list<string>|null */
        public ?array $labellisation = null,
        public ?Logo $logo = null,
        public ?string $mail = null,
        public ?string $nom = null,
        public ?string $nomClubPro = null,
        public ?string $nom_simple = null,
        /** @var list<string>|null */
        public ?array $offresPratiques = null,
        public ?OrganismeIDPere $organisme_id_pere = null,
        public ?string $saison = null,
        public ?bool $saison_en_cours = null,
        public ?string $telephone = null,
        public ?string $thumbnail = null,
        public ?string $type = null,
        public ?TypeAssociation $type_association = null,
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
            _geo: Cast::object($data['_geo'] ?? null, Geo::class),
            adresse: Cast::string($data['adresse'] ?? null),
            adresseClubPro: Cast::string($data['adresseClubPro'] ?? null),
            cartographie: Cast::object($data['cartographie'] ?? null, Cartographie::class),
            code: Cast::string($data['code'] ?? null),
            code_emploi: Cast::string($data['code_emploi'] ?? null),
            commune: Cast::object($data['commune'] ?? null, Commune::class),
            communeClubPro: Cast::object($data['communeClubPro'] ?? null, Commune::class),
            dateAffiliation: Cast::dateTime($data['dateAffiliation'] ?? null),
            engagements_codes: Cast::string($data['engagements_codes'] ?? null),
            engagements_noms: Cast::string($data['engagements_noms'] ?? null),
            id: Cast::string($data['id'] ?? null),
            labellisation: Cast::listOf($data['labellisation'] ?? null, 'string'),
            logo: Cast::object($data['logo'] ?? null, Logo::class),
            mail: Cast::string($data['mail'] ?? null),
            nom: Cast::string($data['nom'] ?? null),
            nomClubPro: Cast::string($data['nomClubPro'] ?? null),
            nom_simple: Cast::string($data['nom_simple'] ?? null),
            offresPratiques: Cast::listOf($data['offresPratiques'] ?? null, 'string'),
            organisme_id_pere: Cast::object($data['organisme_id_pere'] ?? null, OrganismeIDPere::class),
            saison: Cast::string($data['saison'] ?? null),
            saison_en_cours: Cast::bool($data['saison_en_cours'] ?? null),
            telephone: Cast::string($data['telephone'] ?? null),
            thumbnail: Cast::string($data['thumbnail'] ?? null),
            type: Cast::string($data['type'] ?? null),
            type_association: Cast::object($data['type_association'] ?? null, TypeAssociation::class),
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
