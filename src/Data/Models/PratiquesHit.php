<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Hit Meilisearch de l'index `ffbbnational_pratiques` (modèle Python PratiquesHit, complété par 3 attribut(s) observé(s)).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class PratiquesHit
{
    public const string INDEX = 'ffbbnational_pratiques';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [];

    public function __construct(
        public ?Geo $_geo = null,
        public ?string $action = null,
        public ?string $adresse = null,
        public ?string $adresse_salle = null,
        public ?string $adresse_structure = null,
        public ?Affiche $affiche = null,
        public ?string $assurance = null,
        public ?Cartographie $cartographie = null,
        public ?string $code = null,
        public ?string $code_structure = null,
        public ?string $cp_salle = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_debut = null,
        public ?int $date_debut_timestamp = null,
        public ?int $date_demande = null,
        public ?DateTimeImmutable $date_fin = null,
        public ?int $date_fin_timestamp = null,
        public ?int $date_inscription = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?string $date_validation_ffbb = null,
        public ?int $date_validation_ffbb_timestamp = null,
        public ?string $description = null,
        public ?string $email = null,
        public ?string $engagement = null,
        public ?string $facebook = null,
        public ?string $horaires_seances = null,
        public ?int $id = null,
        public ?string $inscriptions = null,
        /** @var list<mixed>|null */
        public ?array $jours = null,
        public ?string $label = null,
        public ?float $latitude = null,
        public ?float $longitude = null,
        public ?string $mail_demandeur = null,
        public ?string $mail_structure = null,
        public ?string $nom_demandeur = null,
        public ?string $nom_salle = null,
        public ?string $nom_structure = null,
        public ?string $nombre_personnes = null,
        public ?string $nombre_seances = null,
        public ?string $objectif = null,
        public ?string $prenom_demandeur = null,
        public ?string $public = null,
        public ?string $site_web = null,
        public ?string $telephone = null,
        public ?string $thumbnail = null,
        public ?string $titre = null,
        public ?string $twitter = null,
        public ?string $type = null,
        public ?string $ville_salle = null,
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
            action: Cast::string($data['action'] ?? null),
            adresse: Cast::string($data['adresse'] ?? null),
            adresse_salle: Cast::string($data['adresse_salle'] ?? null),
            adresse_structure: Cast::string($data['adresse_structure'] ?? null),
            affiche: Cast::object($data['affiche'] ?? null, Affiche::class),
            assurance: Cast::string($data['assurance'] ?? null),
            cartographie: Cast::object($data['cartographie'] ?? null, Cartographie::class),
            code: Cast::string($data['code'] ?? null),
            code_structure: Cast::string($data['code_structure'] ?? null),
            cp_salle: Cast::string($data['cp_salle'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_debut: Cast::dateTime($data['date_debut'] ?? null),
            date_debut_timestamp: Cast::int($data['date_debut_timestamp'] ?? null),
            date_demande: Cast::int($data['date_demande'] ?? null),
            date_fin: Cast::dateTime($data['date_fin'] ?? null),
            date_fin_timestamp: Cast::int($data['date_fin_timestamp'] ?? null),
            date_inscription: Cast::int($data['date_inscription'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            date_validation_ffbb: Cast::string($data['date_validation_ffbb'] ?? null),
            date_validation_ffbb_timestamp: Cast::int($data['date_validation_ffbb_timestamp'] ?? null),
            description: Cast::string($data['description'] ?? null),
            email: Cast::string($data['email'] ?? null),
            engagement: Cast::string($data['engagement'] ?? null),
            facebook: Cast::string($data['facebook'] ?? null),
            horaires_seances: Cast::string($data['horaires_seances'] ?? null),
            id: Cast::int($data['id'] ?? null),
            inscriptions: Cast::string($data['inscriptions'] ?? null),
            jours: Cast::listOf($data['jours'] ?? null, 'raw'),
            label: Cast::string($data['label'] ?? null),
            latitude: Cast::float($data['latitude'] ?? null),
            longitude: Cast::float($data['longitude'] ?? null),
            mail_demandeur: Cast::string($data['mail_demandeur'] ?? null),
            mail_structure: Cast::string($data['mail_structure'] ?? null),
            nom_demandeur: Cast::string($data['nom_demandeur'] ?? null),
            nom_salle: Cast::string($data['nom_salle'] ?? null),
            nom_structure: Cast::string($data['nom_structure'] ?? null),
            nombre_personnes: Cast::string($data['nombre_personnes'] ?? null),
            nombre_seances: Cast::string($data['nombre_seances'] ?? null),
            objectif: Cast::string($data['objectif'] ?? null),
            prenom_demandeur: Cast::string($data['prenom_demandeur'] ?? null),
            public: Cast::string($data['public'] ?? null),
            site_web: Cast::string($data['site_web'] ?? null),
            telephone: Cast::string($data['telephone'] ?? null),
            thumbnail: Cast::string($data['thumbnail'] ?? null),
            titre: Cast::string($data['titre'] ?? null),
            twitter: Cast::string($data['twitter'] ?? null),
            type: Cast::string($data['type'] ?? null),
            ville_salle: Cast::string($data['ville_salle'] ?? null),
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
