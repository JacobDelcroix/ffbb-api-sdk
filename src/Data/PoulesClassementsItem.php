<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_poules_classements` (schéma OpenAPI ItemsFfbbserverPoulesClassements).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class PoulesClassementsItem
{
    public const string COLLECTION = 'ffbbserver_poules_classements';

    /**
     * Propriétés renommées → nom du champ Directus (à utiliser dans fields(), where() et les filtres).
     *
     * @var array<string, string>
     */
    public const array DIRECTUS_FIELDS = [
        'competition' => 'idCompetition',
        'engagement' => 'idEngagement',
        'poule' => 'idPoule',
    ];

    public function __construct(
        /** Champ Directus : idCompetition */
        public ?CompetitionsItem $competition = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?int $difference = null,
        /** Champ Directus : idEngagement */
        public ?EngagementsItem $engagement = null,
        public ?int $gagnes = null,
        public ?bool $horsClassement = null,
        public ?string $id = null,
        public ?int $matchJoues = null,
        public ?int $match_joues = null,
        public ?int $nombreDefauts = null,
        public ?int $nombreForfaits = null,
        public ?int $nuls = null,
        public ?OrganismesItem $organisme = null,
        public ?string $organisme_nom = null,
        public ?int $paniersEncaisses = null,
        public ?int $paniersMarques = null,
        public ?int $penalites = null,
        public ?int $penalitesArbitrage = null,
        public ?int $penalitesDiverses = null,
        public ?int $penalitesEntraineur = null,
        public ?int $perdus = null,
        public ?int $pointInitiaux = null,
        public ?int $points = null,
        public ?int $pointsInitiaux = null,
        public ?int $position = null,
        /** Champ Directus : idPoule */
        public ?PoulesItem $poule = null,
        public ?float $quotient = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            competition: Cast::related($data['idCompetition'] ?? null, CompetitionsItem::class),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            difference: Cast::int($data['difference'] ?? null),
            engagement: Cast::related($data['idEngagement'] ?? null, EngagementsItem::class),
            gagnes: Cast::int($data['gagnes'] ?? null),
            horsClassement: Cast::bool($data['horsClassement'] ?? null),
            id: Cast::string($data['id'] ?? null),
            matchJoues: Cast::int($data['matchJoues'] ?? null),
            match_joues: Cast::int($data['match_joues'] ?? null),
            nombreDefauts: Cast::int($data['nombreDefauts'] ?? null),
            nombreForfaits: Cast::int($data['nombreForfaits'] ?? null),
            nuls: Cast::int($data['nuls'] ?? null),
            organisme: Cast::related($data['organisme'] ?? null, OrganismesItem::class),
            organisme_nom: Cast::string($data['organisme_nom'] ?? null),
            paniersEncaisses: Cast::int($data['paniersEncaisses'] ?? null),
            paniersMarques: Cast::int($data['paniersMarques'] ?? null),
            penalites: Cast::int($data['penalites'] ?? null),
            penalitesArbitrage: Cast::int($data['penalitesArbitrage'] ?? null),
            penalitesDiverses: Cast::int($data['penalitesDiverses'] ?? null),
            penalitesEntraineur: Cast::int($data['penalitesEntraineur'] ?? null),
            perdus: Cast::int($data['perdus'] ?? null),
            pointInitiaux: Cast::int($data['pointInitiaux'] ?? null),
            points: Cast::int($data['points'] ?? null),
            pointsInitiaux: Cast::int($data['pointsInitiaux'] ?? null),
            position: Cast::int($data['position'] ?? null),
            poule: Cast::related($data['idPoule'] ?? null, PoulesItem::class),
            quotient: Cast::float($data['quotient'] ?? null),
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
