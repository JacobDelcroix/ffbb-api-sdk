<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Concerns;

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Exceptions\FfbbException;
use CoachBasket\Ffbb\Exceptions\FfbbNotFoundException;
use CoachBasket\Ffbb\Requests\Directus\GetConfiguration;
use CoachBasket\Ffbb\Requests\Directus\GetLives;
use CoachBasket\Ffbb\Requests\Directus\GetOpenApiSpec;
use CoachBasket\Ffbb\Support\Json;

/**
 * Getters simples, lives, configuration, spec OpenAPI et sessions (miroir de GettersMixin).
 *
 * Méthodes volontairement explicites (une par ressource) pour l'autocomplétion et PHPStan.
 */
trait ManagesResources
{
    /**
     * Configuration publique de l'app (jetons key_dh / key_ms, versions iOS / Android).
     *
     * @return array<string, mixed>|null
     */
    public function getConfiguration(): ?array
    {
        try {
            $data = Json::unwrapData($this->sendDirectus(new GetConfiguration));
        } catch (FfbbException) {
            return null;
        }

        return is_array($data) && isset($data['key_dh'], $data['key_ms']) ? $data : null;
    }

    /**
     * Matchs suivis en direct.
     *
     * @return list<array<string, mixed>>|null
     */
    public function getLives(): ?array
    {
        try {
            $data = $this->sendDirectus(new GetLives);
        } catch (FfbbNotFoundException) {
            return null;
        }

        if ($data === null) {
            return null;
        }

        if (is_array($data) && array_key_exists('lives', $data)) {
            $data = $data['lives'];
        }

        return is_array($data) && array_is_list($data) ? array_values(array_filter($data, 'is_array')) : [];
    }

    /**
     * Spécification OpenAPI exposée par Directus (null en cas d'erreur).
     *
     * @return array<string, mixed>|null
     */
    public function getOpenapiSpec(): ?array
    {
        try {
            $data = $this->sendDirectus(new GetOpenApiSpec);
        } catch (FfbbException) {
            return null;
        }

        return is_array($data) ? $data : null;
    }

    /**
     * Détail d'une rencontre (match) : équipes, date, score, salle, officiels (null si introuvable).
     *
     * @return array<string, mixed>|null
     */
    public function getRencontre(int|string $id): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_RENCONTRES, $id);
    }

    /**
     * Détail d'un engagement : une équipe d'un club dans une compétition / poule (null si introuvable).
     *
     * @return array<string, mixed>|null
     */
    public function getEngagement(int|string $id): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_ENGAGEMENTS, $id);
    }

    /**
     * Détail d'une formation (null si introuvable).
     *
     * @return array<string, mixed>|null
     */
    public function getFormation(int|string $id): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_FORMATIONS, $id);
    }

    /**
     * Détail d'un entraîneur (par numéro de licence) (null si introuvable).
     *
     * @return array<string, mixed>|null
     */
    public function getEntraineur(int|string $id): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_ENTRAINEURS, $id);
    }

    /**
     * Détail d'une commune (null si introuvable).
     *
     * @return array<string, mixed>|null
     */
    public function getCommune(int|string $id): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_COMMUNES, $id);
    }

    /**
     * Détail d'un officiel (arbitre, OTM) (null si introuvable).
     *
     * @return array<string, mixed>|null
     */
    public function getOfficiel(int|string $id): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_OFFICIELS, $id);
    }

    /**
     * Détail d'une salle : nom, adresse, commune, coordonnées (null si introuvable).
     *
     * @return array<string, mixed>|null
     */
    public function getSalle(int|string $id): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_SALLES, $id);
    }

    /**
     * Détail d'un terrain (3x3 / extérieur) (null si introuvable).
     *
     * @return array<string, mixed>|null
     */
    public function getTerrain(int|string $id): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_TERRAINS, $id);
    }

    /**
     * Détail d'un tournoi (null si introuvable).
     *
     * @return array<string, mixed>|null
     */
    public function getTournoi(int|string $id): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_TOURNOIS, $id);
    }

    /**
     * Détail d'une offre de pratique (null si introuvable).
     *
     * @return array<string, mixed>|null
     */
    public function getPratique(int|string $id): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_PRATIQUES, $id);
    }

    /**
     * Une session de formation (null si introuvable).
     *
     * @param  list<string>|null  $fields
     * @return array<string, mixed>|null
     */
    public function getSession(int|string $id, ?array $fields = null): ?array
    {
        return $this->getDirectusItem(Config::ENDPOINT_SESSIONS, $id, $fields);
    }

    /**
     * Sessions de formation.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<array<string, mixed>>
     */
    public function listSessions(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return $this->listDirectusItems(Config::ENDPOINT_SESSIONS, $limit, $fields, $filterCriteria, $sort);
    }
}
