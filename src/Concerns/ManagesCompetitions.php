<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Concerns;

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Exceptions\FfbbAuthenticationException;
use CoachBasket\Ffbb\Exceptions\FfbbException;
use CoachBasket\Ffbb\Exceptions\FfbbHttpException;
use CoachBasket\Ffbb\Exceptions\FfbbNotFoundException;
use CoachBasket\Ffbb\Exceptions\FfbbTransportException;
use CoachBasket\Ffbb\Fallback\MeilisearchFallback;
use CoachBasket\Ffbb\Fallback\PouleCompetitionRegistry;
use CoachBasket\Ffbb\Fields\FieldSet;
use CoachBasket\Ffbb\Fields\QueryFields;
use CoachBasket\Ffbb\Support\Json;
use CoachBasket\Ffbb\Support\Validator;
use CoachBasket\Ffbb\Requests\Directus\GetItem;
use CoachBasket\Ffbb\Requests\Directus\ListItems;
use Throwable;

/**
 * Compétitions, poules, classements et saisons (miroir de CompetitionMixin).
 *
 * @property-read MeilisearchFallback $fallback
 * @property-read PouleCompetitionRegistry $registry
 */
trait ManagesCompetitions
{
    /**
     * Détail d'une compétition avec phases, poules et rencontres imbriquées.
     *
     * - 403 Directus (saison archivée) → nouvel essai via le listing filtré ;
     * - 403 BunnyCDN → l'exception remonte (diagnostic CDN explicite) ;
     * - autre erreur HTTP / réseau → reconstruction depuis Meilisearch.
     *
     * @param  list<string>|null  $fields
     * @return array<string, mixed>|null
     */
    public function getCompetition(int|string $competitionId, ?string $deepLimit = '1000', ?array $fields = null): ?array
    {
        $extra = [];

        if ($deepLimit !== null && $deepLimit !== '') {
            $extra['deep[phases][poules][rencontres][_limit]'] = $deepLimit;
        }

        $fields = $fields !== null && $fields !== [] ? $fields : QueryFields::competition(FieldSet::Default);

        try {
            $data = Json::unwrapData($this->sendDirectus(
                new GetItem(Config::ENDPOINT_COMPETITIONS, $competitionId, $fields, $extra, timeout: 3.0),
            ));
        } catch (FfbbAuthenticationException $e) {
            if ($e->isBunnyCdnBlock()) {
                throw $e;
            }

            return $this->getCompetitionViaFilter($competitionId, $fields);
        } catch (FfbbNotFoundException) {
            return null;
        } catch (FfbbHttpException|FfbbTransportException) {
            try {
                return $this->fallback->competition($competitionId);
            } catch (Throwable) {
                return null;
            }
        }

        if (! is_array($data) || $data === []) {
            return null;
        }

        $this->registry->registerFromCompetition($data, $competitionId);

        return $data;
    }

    /**
     * Repli : GET items/ffbbserver_competitions?filter[id][_eq]=<id>&limit=1.
     *
     * @param  list<string>  $fields
     * @return array<string, mixed>|null
     */
    protected function getCompetitionViaFilter(int|string $competitionId, array $fields): ?array
    {
        try {
            $items = $this->listDirectusItems(
                Config::ENDPOINT_COMPETITIONS,
                limit: 1,
                fields: $fields,
                extraQuery: ['filter[id][_eq]' => (string) $competitionId],
            );
        } catch (FfbbAuthenticationException $e) {
            if ($e->isBunnyCdnBlock()) {
                throw $e;
            }

            return null;
        } catch (FfbbException) {
            return null;
        }

        // Liste vide : saison archivée ou purgée par la FFBB.
        return $items[0] ?? null;
    }

    /**
     * Détail d'une poule avec rencontres et classements.
     *
     * Sur erreur (hors 404), la poule est reconstruite depuis Meilisearch.
     *
     * @param  list<string>|null  $fields
     * @return array<string, mixed>|null
     */
    public function getPoule(int|string $pouleId, ?string $deepLimit = '1000', ?array $fields = null): ?array
    {
        $extra = [];

        if ($deepLimit !== null && $deepLimit !== '') {
            $extra['deep[rencontres][_limit]'] = $deepLimit;
            $extra['deep[classements][_limit]'] = $deepLimit;
        }

        $fields = $fields !== null && $fields !== [] ? $fields : QueryFields::poule(FieldSet::Default);

        try {
            $data = Json::unwrapData($this->sendDirectus(
                new GetItem(Config::ENDPOINT_POULES, $pouleId, $fields, $extra, timeout: 3.0),
            ));
        } catch (FfbbNotFoundException) {
            return null;
        } catch (FfbbHttpException|FfbbTransportException) {
            try {
                return $this->fallback->poule($pouleId);
            } catch (Throwable) {
                return null;
            }
        }

        return is_array($data) && $data !== [] ? $data : null;
    }

    /**
     * Uniquement le classement d'une poule.
     *
     * @return list<array<string, mixed>>|null
     */
    public function getClassement(int|string $pouleId): ?array
    {
        $poule = $this->getPoule($pouleId, '1000', QueryFields::classement());

        if ($poule === null) {
            return null;
        }

        return array_values(array_filter((array) ($poule['classements'] ?? []), 'is_array'));
    }

    /**
     * Saisons (par défaut : les saisons actives).
     *
     * Si Directus est bloqué, renvoie la saison de repli codée en dur (comme le Python).
     *
     * @param  list<string>|null  $fields
     * @return list<array<string, mixed>>
     */
    public function getSaisons(?array $fields = null, ?string $filterCriteria = Config::DEFAULT_SAISONS_FILTER): array
    {
        $fields = Validator::stringList($fields, 'fields') ?? QueryFields::saison(FieldSet::Default);
        $filter = Validator::filterCriteria($filterCriteria);

        try {
            $data = Json::unwrapData($this->sendDirectus(
                new ListItems(Config::ENDPOINT_SAISONS, null, $fields, $filter, timeout: 3.0),
            ));
        } catch (FfbbNotFoundException) {
            return [];
        } catch (FfbbHttpException|FfbbTransportException) {
            return [Config::FALLBACK_SAISON];
        }

        return is_array($data) && array_is_list($data)
            ? array_values(array_filter($data, 'is_array'))
            : [];
    }
}
