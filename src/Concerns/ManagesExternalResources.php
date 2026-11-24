<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Concerns;

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Data\EdfMatchesItem;
use CoachBasket\Ffbb\Data\EdfPlayersItem;
use CoachBasket\Ffbb\Data\EdfRostersItem;
use CoachBasket\Ffbb\Data\EdfTeamsItem;
use CoachBasket\Ffbb\Data\GeniusSportMatchesItem;
use CoachBasket\Ffbb\Data\GeniusSportsLiveLogsItem;
use CoachBasket\Ffbb\Data\RematchVideosItem;

/**
 * Intégrations externes exposées par Directus : Genius Sports, Rematch, équipes de France
 * (miroir de ExternalMixin).
 *
 * FICHIER GÉNÉRÉ par tools/generate_concerns.py — modifier le générateur plutôt que ce fichier.
 */
trait ManagesExternalResources
{
    /**
     * Un match Genius Sports (statistiques live).
     *
     * @param  list<string>|null  $fields
     */
    public function getGeniusSportMatch(int|string $id, ?array $fields = null): ?GeniusSportMatchesItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_GENIUS_SPORT_MATCHES, $id, $fields), GeniusSportMatchesItem::class);
    }

    /**
     * Une vidéo Rematch.
     *
     * @param  list<string>|null  $fields
     */
    public function getRematchVideo(int|string $id, ?array $fields = null): ?RematchVideosItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_REMATCH_VIDEOS, $id, $fields), RematchVideosItem::class);
    }

    /**
     * Un match d'une équipe de France.
     *
     * @param  list<string>|null  $fields
     */
    public function getEdfMatch(int|string $id, ?array $fields = null): ?EdfMatchesItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_EDF_MATCHES, $id, $fields), EdfMatchesItem::class);
    }

    /**
     * Un joueur ou une joueuse des équipes de France.
     *
     * @param  list<string>|null  $fields
     */
    public function getEdfPlayer(int|string $id, ?array $fields = null): ?EdfPlayersItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_EDF_PLAYERS, $id, $fields), EdfPlayersItem::class);
    }

    /**
     * Matchs Genius Sports (statistiques live).
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<GeniusSportMatchesItem>
     */
    public function listGeniusSportMatches(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return GeniusSportMatchesItem::collect($this->listDirectusItems(Config::ENDPOINT_GENIUS_SPORT_MATCHES, $limit, $fields, $filterCriteria, $sort));
    }

    /**
     * Journal des événements live Genius Sports.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<GeniusSportsLiveLogsItem>
     */
    public function listGeniusSportsLiveLogs(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return GeniusSportsLiveLogsItem::collect($this->listDirectusItems(Config::ENDPOINT_GENIUS_SPORTS_LIVE_LOGS, $limit, $fields, $filterCriteria, $sort));
    }

    /**
     * Vidéos Rematch.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<RematchVideosItem>
     */
    public function listRematchVideos(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return RematchVideosItem::collect($this->listDirectusItems(Config::ENDPOINT_REMATCH_VIDEOS, $limit, $fields, $filterCriteria, $sort));
    }

    /**
     * Matchs des équipes de France.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<EdfMatchesItem>
     */
    public function listEdfMatches(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return EdfMatchesItem::collect($this->listDirectusItems(Config::ENDPOINT_EDF_MATCHES, $limit, $fields, $filterCriteria, $sort));
    }

    /**
     * Joueurs et joueuses des équipes de France.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<EdfPlayersItem>
     */
    public function listEdfPlayers(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return EdfPlayersItem::collect($this->listDirectusItems(Config::ENDPOINT_EDF_PLAYERS, $limit, $fields, $filterCriteria, $sort));
    }

    /**
     * Équipes de France.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<EdfTeamsItem>
     */
    public function listEdfTeams(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return EdfTeamsItem::collect($this->listDirectusItems(Config::ENDPOINT_EDF_TEAMS, $limit, $fields, $filterCriteria, $sort));
    }

    /**
     * Effectifs des équipes de France.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<EdfRostersItem>
     */
    public function listEdfRosters(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return EdfRostersItem::collect($this->listDirectusItems(Config::ENDPOINT_EDF_ROSTERS, $limit, $fields, $filterCriteria, $sort));
    }
}
