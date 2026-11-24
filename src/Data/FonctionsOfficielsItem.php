<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_fonctions_officiels` (schéma OpenAPI ItemsFfbbserverFonctionsOfficiels).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class FonctionsOfficielsItem
{
    public const string COLLECTION = 'ffbbserver_fonctions_officiels';

    public function __construct(
        public ?bool $afficher = null,
        public ?bool $attribuer = null,
        public ?bool $certificatMedical = null,
        public ?string $code = null,
        public ?string $date_created = null,
        public ?string $date_updated = null,
        public ?bool $designation = null,
        public ?bool $emarque = null,
        public ?string $id = null,
        public ?string $libelle = null,
        public ?string $niveau = null,
        public ?int $ordre = null,
        public ?bool $repartitionClub = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            afficher: Cast::bool($data['afficher'] ?? null),
            attribuer: Cast::bool($data['attribuer'] ?? null),
            certificatMedical: Cast::bool($data['certificatMedical'] ?? null),
            code: Cast::string($data['code'] ?? null),
            date_created: Cast::string($data['date_created'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            designation: Cast::bool($data['designation'] ?? null),
            emarque: Cast::bool($data['emarque'] ?? null),
            id: Cast::string($data['id'] ?? null),
            libelle: Cast::string($data['libelle'] ?? null),
            niveau: Cast::string($data['niveau'] ?? null),
            ordre: Cast::int($data['ordre'] ?? null),
            repartitionClub: Cast::bool($data['repartitionClub'] ?? null),
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
