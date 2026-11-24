<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Objet imbriqué OrganismeIDPere (modèle Python, organisme_id_pere.py).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class OrganismeIDPere
{
    public function __construct(
        public ?string $adresse = null,
        public ?string $adresseClubPro = null,
        public ?string $cartographie = null,
        public ?string $code = null,
        public ?int $commune = null,
        public ?string $communeClubPro = null,
        public ?DateTimeImmutable $dateAffiliation = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        /** @var list<mixed>|null */
        public ?array $engagements = null,
        public ?bool $entreprise = null,
        public ?bool $handibasket = null,
        public ?bool $horsAssociation = null,
        public ?int $id = null,
        /** @var list<mixed>|null */
        public ?array $labellisation = null,
        public ?string $logo = null,
        public ?string $mail = null,
        public ?string $nom = null,
        public ?string $nomClubPro = null,
        public ?string $nom_simple = null,
        /** @var list<mixed>|null */
        public ?array $offresPratiques = null,
        public ?bool $omnisport = null,
        public ?OrganismeIDPere $organisme_id_pere = null,
        public ?bool $saison_en_cours = null,
        public ?string $salle = null,
        public ?string $telephone = null,
        public ?string $type = null,
        public ?string $type_association = null,
        public ?string $urlSiteWeb = null,
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
            cartographie: Cast::string($data['cartographie'] ?? null),
            code: Cast::string($data['code'] ?? null),
            commune: Cast::int($data['commune'] ?? null),
            communeClubPro: Cast::string($data['communeClubPro'] ?? null),
            dateAffiliation: Cast::dateTime($data['dateAffiliation'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            engagements: Cast::listOf($data['engagements'] ?? null, 'raw'),
            entreprise: Cast::bool($data['entreprise'] ?? null),
            handibasket: Cast::bool($data['handibasket'] ?? null),
            horsAssociation: Cast::bool($data['horsAssociation'] ?? null),
            id: Cast::int($data['id'] ?? null),
            labellisation: Cast::listOf($data['labellisation'] ?? null, 'raw'),
            logo: Cast::string($data['logo'] ?? null),
            mail: Cast::string($data['mail'] ?? null),
            nom: Cast::string($data['nom'] ?? null),
            nomClubPro: Cast::string($data['nomClubPro'] ?? null),
            nom_simple: Cast::string($data['nom_simple'] ?? null),
            offresPratiques: Cast::listOf($data['offresPratiques'] ?? null, 'raw'),
            omnisport: Cast::bool($data['omnisport'] ?? null),
            organisme_id_pere: Cast::object($data['organisme_id_pere'] ?? null, OrganismeIDPere::class),
            saison_en_cours: Cast::bool($data['saison_en_cours'] ?? null),
            salle: Cast::string($data['salle'] ?? null),
            telephone: Cast::string($data['telephone'] ?? null),
            type: Cast::string($data['type'] ?? null),
            type_association: Cast::string($data['type_association'] ?? null),
            urlSiteWeb: Cast::string($data['urlSiteWeb'] ?? null),
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
