<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Search;

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Data\Models;

/**
 * Index Meilisearch interrogés par l'app FFBB, avec leurs facettes par défaut
 * (miroir de MEILISEARCH_INDEX_* et MEILISEARCH_FACETS_* dans config.py).
 */
enum Index: string
{
    case Organismes = Config::MEILISEARCH_INDEX_ORGANISMES;
    case Rencontres = Config::MEILISEARCH_INDEX_RENCONTRES;
    case Terrains = Config::MEILISEARCH_INDEX_TERRAINS;
    case Competitions = Config::MEILISEARCH_INDEX_COMPETITIONS;
    case Salles = Config::MEILISEARCH_INDEX_SALLES;
    case Tournois = Config::MEILISEARCH_INDEX_TOURNOIS;
    case Pratiques = Config::MEILISEARCH_INDEX_PRATIQUES;
    case Engagements = Config::MEILISEARCH_INDEX_ENGAGEMENTS;
    case Formations = Config::MEILISEARCH_INDEX_FORMATIONS;
    case News = Config::MEILISEARCH_INDEX_NEWS;
    case YoutubeVideos = Config::MEILISEARCH_INDEX_YOUTUBE_VIDEOS;
    case Rss = Config::MEILISEARCH_INDEX_RSS;
    case Galeries = Config::MEILISEARCH_INDEX_GALERIES;

    /**
     * Facettes demandées par défaut pour cet index.
     *
     * @return list<string>|null
     */
    public function facets(): ?array
    {
        return match ($this) {
            self::Organismes => ['type_association.libelle', 'type', 'labellisation', 'offresPratiques'],
            self::Rencontres => [
                'competitionId.categorie.code',
                'competitionId.typeCompetition',
                'niveau',
                'competitionId.sexe',
                'organisateur.nom',
                'organisateur.id',
                'competitionId.nomExtended',
            ],
            self::Tournois => ['sexe', 'tournoiTypes3x3.libelle', 'tournoiType'],
            self::Pratiques => ['label', 'type'],
            self::Engagements => [
                'clubPro',
                'idCompetition.categorie.code',
                'idCompetition.categorie.libelle',
                'idCompetition.code',
                'idCompetition.nom',
                'idCompetition.sexe',
                'idPoule.nom',
                'niveau.code',
                'niveau.libelle',
            ],
            self::Formations => [
                'date_end_formatted',
                'date_start_formatted',
                'domain',
                'mode',
                'place',
                'places',
                'postal_code',
                'postal_codes',
                'theme',
                'type',
            ],
            self::News => ['category', 'categories', 'type'],
            self::YoutubeVideos => ['tags', 'type'],
            self::Rss => ['categories', 'tags'],
            self::Galeries => ['tags', 'type'],
            self::Terrains, self::Competitions, self::Salles => null,
        };
    }

    /**
     * DTO des hits de cet index.
     *
     * @return class-string
     */
    public function hitClass(): string
    {
        return match ($this) {
            self::Organismes => Models\OrganismesHit::class,
            self::Rencontres => Models\RencontresHit::class,
            self::Terrains => Models\TerrainsHit::class,
            self::Competitions => Models\CompetitionsHit::class,
            self::Salles => Models\SallesHit::class,
            self::Tournois => Models\TournoisHit::class,
            self::Pratiques => Models\PratiquesHit::class,
            self::Engagements => Models\EngagementsHit::class,
            self::Formations => Models\FormationsHit::class,
            self::News, self::YoutubeVideos, self::Rss, self::Galeries => Models\ContentHit::class,
        };
    }
}
