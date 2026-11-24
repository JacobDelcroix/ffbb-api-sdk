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
    public function __construct(
        public ?ExternalCompetitionID $competitionId = null,
        public ?IDOrganismeEquipe $idOrganismeEquipe1 = null,
        public ?IDOrganismeEquipe $idOrganismeEquipe2 = null,
        public ?IDPoule $idPoule = null,
        public ?string $nomEquipe1 = null,
        public ?string $nomEquipe2 = null,
        public ?int $numeroJournee = null,
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
            competitionId: Cast::object($data['competitionId'] ?? null, ExternalCompetitionID::class),
            idOrganismeEquipe1: Cast::object($data['idOrganismeEquipe1'] ?? null, IDOrganismeEquipe::class),
            idOrganismeEquipe2: Cast::object($data['idOrganismeEquipe2'] ?? null, IDOrganismeEquipe::class),
            idPoule: Cast::object($data['idPoule'] ?? null, IDPoule::class),
            nomEquipe1: Cast::string($data['nomEquipe1'] ?? null),
            nomEquipe2: Cast::string($data['nomEquipe2'] ?? null),
            numeroJournee: Cast::int($data['numeroJournee'] ?? null),
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
