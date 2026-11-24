<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data\Models;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Objet imbriqué ExternalID (modèle Python, external_id.py).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class ExternalID
{
    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [
        'competition' => 'competitionId',
        'organismeEquipe1' => 'idOrganismeEquipe1',
        'organismeEquipe2' => 'idOrganismeEquipe2',
        'poule' => 'idPoule',
    ];

    public function __construct(
        /** Champ Directus : competitionId */
        public ?ExternalCompetitionID $competition = null,
        public ?string $nomEquipe1 = null,
        public ?string $nomEquipe2 = null,
        public ?int $numeroJournee = null,
        /** Champ Directus : idOrganismeEquipe1 */
        public ?IDOrganismeEquipe $organismeEquipe1 = null,
        /** Champ Directus : idOrganismeEquipe2 */
        public ?IDOrganismeEquipe $organismeEquipe2 = null,
        /** Champ Directus : idPoule */
        public ?IDPoule $poule = null,
        public ?Salle $salle = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            competition: Cast::object($data['competitionId'] ?? null, ExternalCompetitionID::class),
            nomEquipe1: Cast::string($data['nomEquipe1'] ?? null),
            nomEquipe2: Cast::string($data['nomEquipe2'] ?? null),
            numeroJournee: Cast::int($data['numeroJournee'] ?? null),
            organismeEquipe1: Cast::object($data['idOrganismeEquipe1'] ?? null, IDOrganismeEquipe::class),
            organismeEquipe2: Cast::object($data['idOrganismeEquipe2'] ?? null, IDOrganismeEquipe::class),
            poule: Cast::object($data['idPoule'] ?? null, IDPoule::class),
            salle: Cast::object($data['salle'] ?? null, Salle::class),
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
