<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;
use DateTimeImmutable;

/**
 * Collection Directus `ffbbserver_labellisation_programme` (schéma OpenAPI ItemsFfbbserverLabellisationProgramme).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class LabellisationProgrammeItem
{
    public const string COLLECTION = 'ffbbserver_labellisation_programme';

    public function __construct(
        public ?string $affiche = null,
        public ?string $code = null,
        public ?DateTimeImmutable $date_created = null,
        public ?DateTimeImmutable $date_updated = null,
        public ?bool $decouverte = null,
        public ?bool $demandeLabel = null,
        public ?string $engagement = null,
        public ?string $id = null,
        public ?LabellisationLabelItem $labellisationLabel = null,
        public ?string $libelle = null,
        public ?bool $licence = null,
        public ?string $lienHelloassoInitial = null,
        public ?string $lienHelloassoRenouvellement = null,
        public ?string $logo = null,
        public mixed $logo_horizontal = null,
        public mixed $logo_vertical = null,
        public ?int $montantInitial = null,
        public ?int $montantRenouvellement = null,
        public ?bool $paiement = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            affiche: Cast::string($data['affiche'] ?? null),
            code: Cast::string($data['code'] ?? null),
            date_created: Cast::dateTime($data['date_created'] ?? null),
            date_updated: Cast::dateTime($data['date_updated'] ?? null),
            decouverte: Cast::bool($data['decouverte'] ?? null),
            demandeLabel: Cast::bool($data['demandeLabel'] ?? null),
            engagement: Cast::string($data['engagement'] ?? null),
            id: Cast::string($data['id'] ?? null),
            labellisationLabel: Cast::related($data['labellisationLabel'] ?? null, LabellisationLabelItem::class),
            libelle: Cast::string($data['libelle'] ?? null),
            licence: Cast::bool($data['licence'] ?? null),
            lienHelloassoInitial: Cast::string($data['lienHelloassoInitial'] ?? null),
            lienHelloassoRenouvellement: Cast::string($data['lienHelloassoRenouvellement'] ?? null),
            logo: Cast::string($data['logo'] ?? null),
            logo_horizontal: $data['logo_horizontal'] ?? null,
            logo_vertical: $data['logo_vertical'] ?? null,
            montantInitial: Cast::int($data['montantInitial'] ?? null),
            montantRenouvellement: Cast::int($data['montantRenouvellement'] ?? null),
            paiement: Cast::bool($data['paiement'] ?? null),
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
