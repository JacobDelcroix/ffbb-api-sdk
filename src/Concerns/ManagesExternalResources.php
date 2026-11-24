<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Concerns;

use CoachBasket\Ffbb\Config;

/**
 * Intégrations externes exposées par Directus : Genius Sports, Rematch, équipes de France
 * (miroir de ExternalMixin).
 *
 * Méthodes volontairement explicites (une par ressource) pour l'autocomplétion et PHPStan.
 */
trait ManagesExternalResources
{
    /**
     * Un match Genius Sports (statistiques live).
     *
     * @param  list<string>|null  $fields
     * @return array<string, mixed>|null
     */
    public function getGeniusSportMatch(int|string $id, ?array $fields = null): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_GENIUS_SPORT_MATCHES, $id, $fields);
    }

    /**
     * Une vidéo Rematch.
     *
     * @param  list<string>|null  $fields
     * @return array<string, mixed>|null
     */
    public function getRematchVideo(int|string $id, ?array $fields = null): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_REMATCH_VIDEOS, $id, $fields);
    }

    /**
     * Un match d'une équipe de France.
     *
     * @param  list<string>|null  $fields
     * @return array<string, mixed>|null
     */
    public function getEdfMatch(int|string $id, ?array $fields = null): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_EDF_MATCHES, $id, $fields);
    }

    /**
     * Un joueur ou une joueuse des équipes de France.
     *
     * @param  list<string>|null  $fields
     * @return array<string, mixed>|null
     */
    public function getEdfPlayer(int|string $id, ?array $fields = null): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_EDF_PLAYERS, $id, $fields);
    }

    /**
     * Matchs Genius Sports (statistiques live).
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<array<string, mixed>>
     */
    public function listGeniusSportMatches(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return $this->listDirectusItems(Config::ENDPOINT_GENIUS_SPORT_MATCHES, $limit, $fields, $filterCriteria, $sort);
    }

    /**
     * Journal des événements live Genius Sports.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<array<string, mixed>>
     */
    public function listGeniusSportsLiveLogs(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return $this->listDirectusItems(Config::ENDPOINT_GENIUS_SPORTS_LIVE_LOGS, $limit, $fields, $filterCriteria, $sort);
    }

    /**
     * Vidéos Rematch.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<array<string, mixed>>
     */
    public function listRematchVideos(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return $this->listDirectusItems(Config::ENDPOINT_REMATCH_VIDEOS, $limit, $fields, $filterCriteria, $sort);
    }

    /**
     * Matchs des équipes de France.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<array<string, mixed>>
     */
    public function listEdfMatches(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return $this->listDirectusItems(Config::ENDPOINT_EDF_MATCHES, $limit, $fields, $filterCriteria, $sort);
    }

    /**
     * Joueurs et joueuses des équipes de France.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<array<string, mixed>>
     */
    public function listEdfPlayers(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return $this->listDirectusItems(Config::ENDPOINT_EDF_PLAYERS, $limit, $fields, $filterCriteria, $sort);
    }

    /**
     * Équipes de France.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<array<string, mixed>>
     */
    public function listEdfTeams(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return $this->listDirectusItems(Config::ENDPOINT_EDF_TEAMS, $limit, $fields, $filterCriteria, $sort);
    }

    /**
     * Effectifs des équipes de France.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<array<string, mixed>>
     */
    public function listEdfRosters(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return $this->listDirectusItems(Config::ENDPOINT_EDF_ROSTERS, $limit, $fields, $filterCriteria, $sort);
    }
}
