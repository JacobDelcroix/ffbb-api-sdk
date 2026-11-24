<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

use CoachBasket\Ffbb\Support\Cast;

/**
 * Collection Directus `ffbbserver_membres` (schéma OpenAPI ItemsFfbbserverMembres).
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final readonly class MembresItem
{
    public const string COLLECTION = 'ffbbserver_membres';

    public function __construct(
        public ?bool $accordDiffusionSiteWeb = null,
        public ?string $adresse1 = null,
        public ?string $adresse2 = null,
        public ?string $codeFonction = null,
        public ?string $codePostal = null,
        public ?string $date_created = null,
        public ?string $date_updated = null,
        public ?string $id = null,
        public ?string $idLicence = null,
        public OrganismesItem|string|int|null $idOrganisme = null,
        public ?string $libelleFonction = null,
        public ?string $mail = null,
        public ?string $nom = null,
        public ?string $prenom = null,
        public ?string $telephoneFixe = null,
        public ?string $telephonePortable = null,
        public ?string $ville = null,
        /** @var array<string, mixed> Réponse brute complète */
        public array $raw = [],
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            accordDiffusionSiteWeb: Cast::bool($data['accordDiffusionSiteWeb'] ?? null),
            adresse1: Cast::string($data['adresse1'] ?? null),
            adresse2: Cast::string($data['adresse2'] ?? null),
            codeFonction: Cast::string($data['codeFonction'] ?? null),
            codePostal: Cast::string($data['codePostal'] ?? null),
            date_created: Cast::string($data['date_created'] ?? null),
            date_updated: Cast::string($data['date_updated'] ?? null),
            id: Cast::string($data['id'] ?? null),
            idLicence: Cast::string($data['idLicence'] ?? null),
            idOrganisme: Cast::relation($data['idOrganisme'] ?? null, OrganismesItem::class),
            libelleFonction: Cast::string($data['libelleFonction'] ?? null),
            mail: Cast::string($data['mail'] ?? null),
            nom: Cast::string($data['nom'] ?? null),
            prenom: Cast::string($data['prenom'] ?? null),
            telephoneFixe: Cast::string($data['telephoneFixe'] ?? null),
            telephonePortable: Cast::string($data['telephonePortable'] ?? null),
            ville: Cast::string($data['ville'] ?? null),
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
