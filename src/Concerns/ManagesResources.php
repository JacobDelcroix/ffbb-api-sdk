<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Concerns;

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Data\CommunesItem;
use CoachBasket\Ffbb\Data\ConfigurationItem;
use CoachBasket\Ffbb\Data\EngagementsItem;
use CoachBasket\Ffbb\Data\EntraineursItem;
use CoachBasket\Ffbb\Data\FormationsItem;
use CoachBasket\Ffbb\Data\OfficielsItem;
use CoachBasket\Ffbb\Data\PratiquesItem;
use CoachBasket\Ffbb\Data\RencontresItem;
use CoachBasket\Ffbb\Data\SallesItem;
use CoachBasket\Ffbb\Data\SessionsItem;
use CoachBasket\Ffbb\Data\TerrainsItem;
use CoachBasket\Ffbb\Data\TournoisItem;
use CoachBasket\Ffbb\Data\Models\Live;
use CoachBasket\Ffbb\Exceptions\FfbbException;
use CoachBasket\Ffbb\Exceptions\FfbbNotFoundException;
use CoachBasket\Ffbb\Requests\Directus\GetConfiguration;
use CoachBasket\Ffbb\Requests\Directus\GetLives;
use CoachBasket\Ffbb\Requests\Directus\GetOpenApiSpec;
use CoachBasket\Ffbb\Support\Json;

/**
 * Getters simples, lives, configuration, spec OpenAPI et sessions (miroir de GettersMixin).
 *
 * FICHIER GÉNÉRÉ par tools/generate_concerns.py — modifier le générateur plutôt que ce fichier.
 */
trait ManagesResources
{
    /**
     * Configuration publique de l'app : jetons key_dh / key_ms, versions iOS / Android (null en cas d'erreur).
     */
    public function getConfiguration(): ?ConfigurationItem
    {
        try {
            $data = Json::unwrapData($this->sendDirectus(new GetConfiguration));
        } catch (FfbbException) {
            return null;
        }

        return is_array($data) && isset($data['key_dh'], $data['key_ms']) ? ConfigurationItem::fromArray($data) : null;
    }

    /**
     * Matchs suivis en direct (jamais mis en cache).
     *
     * @return list<Live>|null
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

        return is_array($data) && array_is_list($data) ? Live::collect($data) : [];
    }

    /**
     * Spécification OpenAPI exposée par Directus, en tableau (null en cas d'erreur).
     *
     * C'est un document de description d'API, pas une donnée FFBB : il n'a pas de DTO.
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
     */
    public function getRencontre(int|string $id): ?RencontresItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_RENCONTRES, $id), RencontresItem::class);
    }

    /**
     * Détail d'un engagement : une équipe d'un club dans une compétition / poule (null si introuvable).
     */
    public function getEngagement(int|string $id): ?EngagementsItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_ENGAGEMENTS, $id), EngagementsItem::class);
    }

    /**
     * Détail d'une formation (null si introuvable).
     */
    public function getFormation(int|string $id): ?FormationsItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_FORMATIONS, $id), FormationsItem::class);
    }

    /**
     * Détail d'un entraîneur (par numéro de licence) (null si introuvable).
     */
    public function getEntraineur(int|string $id): ?EntraineursItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_ENTRAINEURS, $id), EntraineursItem::class);
    }

    /**
     * Détail d'une commune (null si introuvable).
     */
    public function getCommune(int|string $id): ?CommunesItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_COMMUNES, $id), CommunesItem::class);
    }

    /**
     * Détail d'un officiel (arbitre, OTM) (null si introuvable).
     */
    public function getOfficiel(int|string $id): ?OfficielsItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_OFFICIELS, $id), OfficielsItem::class);
    }

    /**
     * Détail d'une salle : nom, adresse, commune, coordonnées (null si introuvable).
     */
    public function getSalle(int|string $id): ?SallesItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_SALLES, $id), SallesItem::class);
    }

    /**
     * Détail d'un terrain (3x3 / extérieur) (null si introuvable).
     */
    public function getTerrain(int|string $id): ?TerrainsItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_TERRAINS, $id), TerrainsItem::class);
    }

    /**
     * Détail d'un tournoi (null si introuvable).
     */
    public function getTournoi(int|string $id): ?TournoisItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_TOURNOIS, $id), TournoisItem::class);
    }

    /**
     * Détail d'une offre de pratique (null si introuvable).
     */
    public function getPratique(int|string $id): ?PratiquesItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_PRATIQUES, $id), PratiquesItem::class);
    }

    /**
     * Une session de formation (null si introuvable).
     *
     * @param  list<string>|null  $fields
     */
    public function getSession(int|string $id, ?array $fields = null): ?SessionsItem
    {
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_SESSIONS, $id, $fields), SessionsItem::class);
    }

    /**
     * Sessions de formation.
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<SessionsItem>
     */
    public function listSessions(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {
        return SessionsItem::collect($this->listDirectusItems(Config::ENDPOINT_SESSIONS, $limit, $fields, $filterCriteria, $sort));
    }
}
