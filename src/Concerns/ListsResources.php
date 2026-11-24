<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Concerns;

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Data\CommunesItem;
use CoachBasket\Ffbb\Data\EngagementsItem;
use CoachBasket\Ffbb\Data\EntraineursItem;
use CoachBasket\Ffbb\Data\FormationsItem;
use CoachBasket\Ffbb\Data\OfficielsItem;
use CoachBasket\Ffbb\Data\PratiquesItem;
use CoachBasket\Ffbb\Data\RencontresItem;
use CoachBasket\Ffbb\Data\SallesItem;
use CoachBasket\Ffbb\Data\TerrainsItem;
use CoachBasket\Ffbb\Data\TournoisItem;
use CoachBasket\Ffbb\Support\Json;
use CoachBasket\Ffbb\Support\Validator;
use Generator;

/**
 * Listes typées, paginées et en streaming (miroir de ListMixin / ListAllMixin
 * et des helpers batch de _RestFacade).
 *
 * Pour chaque ressource :
 *  - list{X}()     : une page (limit / offset) ;
 *  - listAll{X}()  : toutes les pages (max 20 × pageSize, maxItems au total) ;
 *  - iterAll{X}()  : générateur paresseux (équivalent de aiter_all_x).
 *
 * FICHIER GÉNÉRÉ par tools/generate_concerns.py — modifier le générateur plutôt que ce fichier.
 */
trait ListsResources
{
    /**
     * Une page de rencontres (matchs).
     *
     * @param  list<string>|null  $sort
     * @return list<RencontresItem>
     */
    public function listRencontres(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
    {
        return RencontresItem::collect($this->listDirectusItems(
            Config::ENDPOINT_RENCONTRES,
            limit: $limit,
            filter: Validator::filterCriteria($filterCriteria),
            sort: Validator::stringList($sort, 'sort'),
            offset: Validator::offset($offset),
            search: Validator::searchQuery($search, 'search'),
        ));
    }

    /**
     * Toutes les rencontres (matchs) correspondant au filtre, toutes pages confondues (20 pages max).
     *
     * @param  list<string>|null  $sort
     * @return list<RencontresItem>
     */
    public function listAllRencontres(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
    {
        return RencontresItem::collect($this->listAllDirectusItems(
            Config::ENDPOINT_RENCONTRES,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ));
    }

    /**
     * Parcourt les rencontres (matchs) page par page, sans tout charger en mémoire.
     *
     * @param  list<string>|null  $sort
     * @return Generator<int, RencontresItem>
     */
    public function iterAllRencontres(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
    {
        foreach ($this->iterAllDirectusItems(
            Config::ENDPOINT_RENCONTRES,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ) as $item) {
            yield RencontresItem::fromArray($item);
        }
    }

    /**
     * Une page de salles (gymnases).
     *
     * @param  list<string>|null  $sort
     * @return list<SallesItem>
     */
    public function listSalles(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
    {
        return SallesItem::collect($this->listDirectusItems(
            Config::ENDPOINT_SALLES,
            limit: $limit,
            filter: Validator::filterCriteria($filterCriteria),
            sort: Validator::stringList($sort, 'sort'),
            offset: Validator::offset($offset),
            search: Validator::searchQuery($search, 'search'),
        ));
    }

    /**
     * Toutes les salles (gymnases) correspondant au filtre, toutes pages confondues (20 pages max).
     *
     * @param  list<string>|null  $sort
     * @return list<SallesItem>
     */
    public function listAllSalles(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
    {
        return SallesItem::collect($this->listAllDirectusItems(
            Config::ENDPOINT_SALLES,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ));
    }

    /**
     * Parcourt les salles (gymnases) page par page, sans tout charger en mémoire.
     *
     * @param  list<string>|null  $sort
     * @return Generator<int, SallesItem>
     */
    public function iterAllSalles(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
    {
        foreach ($this->iterAllDirectusItems(
            Config::ENDPOINT_SALLES,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ) as $item) {
            yield SallesItem::fromArray($item);
        }
    }

    /**
     * Une page de terrains 3x3 / extérieurs.
     *
     * @param  list<string>|null  $sort
     * @return list<TerrainsItem>
     */
    public function listTerrains(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
    {
        return TerrainsItem::collect($this->listDirectusItems(
            Config::ENDPOINT_TERRAINS,
            limit: $limit,
            filter: Validator::filterCriteria($filterCriteria),
            sort: Validator::stringList($sort, 'sort'),
            offset: Validator::offset($offset),
            search: Validator::searchQuery($search, 'search'),
        ));
    }

    /**
     * Toutes les terrains 3x3 / extérieurs correspondant au filtre, toutes pages confondues (20 pages max).
     *
     * @param  list<string>|null  $sort
     * @return list<TerrainsItem>
     */
    public function listAllTerrains(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
    {
        return TerrainsItem::collect($this->listAllDirectusItems(
            Config::ENDPOINT_TERRAINS,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ));
    }

    /**
     * Parcourt les terrains 3x3 / extérieurs page par page, sans tout charger en mémoire.
     *
     * @param  list<string>|null  $sort
     * @return Generator<int, TerrainsItem>
     */
    public function iterAllTerrains(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
    {
        foreach ($this->iterAllDirectusItems(
            Config::ENDPOINT_TERRAINS,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ) as $item) {
            yield TerrainsItem::fromArray($item);
        }
    }

    /**
     * Une page de tournois (dont 3x3).
     *
     * @param  list<string>|null  $sort
     * @return list<TournoisItem>
     */
    public function listTournois(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
    {
        return TournoisItem::collect($this->listDirectusItems(
            Config::ENDPOINT_TOURNOIS,
            limit: $limit,
            filter: Validator::filterCriteria($filterCriteria),
            sort: Validator::stringList($sort, 'sort'),
            offset: Validator::offset($offset),
            search: Validator::searchQuery($search, 'search'),
        ));
    }

    /**
     * Toutes les tournois (dont 3x3) correspondant au filtre, toutes pages confondues (20 pages max).
     *
     * @param  list<string>|null  $sort
     * @return list<TournoisItem>
     */
    public function listAllTournois(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
    {
        return TournoisItem::collect($this->listAllDirectusItems(
            Config::ENDPOINT_TOURNOIS,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ));
    }

    /**
     * Parcourt les tournois (dont 3x3) page par page, sans tout charger en mémoire.
     *
     * @param  list<string>|null  $sort
     * @return Generator<int, TournoisItem>
     */
    public function iterAllTournois(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
    {
        foreach ($this->iterAllDirectusItems(
            Config::ENDPOINT_TOURNOIS,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ) as $item) {
            yield TournoisItem::fromArray($item);
        }
    }

    /**
     * Une page de équipes engagées (une équipe d'un club dans une compétition).
     *
     * @param  list<string>|null  $sort
     * @return list<EngagementsItem>
     */
    public function listEngagements(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
    {
        return EngagementsItem::collect($this->listDirectusItems(
            Config::ENDPOINT_ENGAGEMENTS,
            limit: $limit,
            filter: Validator::filterCriteria($filterCriteria),
            sort: Validator::stringList($sort, 'sort'),
            offset: Validator::offset($offset),
            search: Validator::searchQuery($search, 'search'),
        ));
    }

    /**
     * Toutes les équipes engagées (une équipe d'un club dans une compétition) correspondant au filtre, toutes pages confondues (20 pages max).
     *
     * @param  list<string>|null  $sort
     * @return list<EngagementsItem>
     */
    public function listAllEngagements(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
    {
        return EngagementsItem::collect($this->listAllDirectusItems(
            Config::ENDPOINT_ENGAGEMENTS,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ));
    }

    /**
     * Parcourt les équipes engagées (une équipe d'un club dans une compétition) page par page, sans tout charger en mémoire.
     *
     * @param  list<string>|null  $sort
     * @return Generator<int, EngagementsItem>
     */
    public function iterAllEngagements(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
    {
        foreach ($this->iterAllDirectusItems(
            Config::ENDPOINT_ENGAGEMENTS,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ) as $item) {
            yield EngagementsItem::fromArray($item);
        }
    }

    /**
     * Une page de formations (entraîneurs, arbitres, dirigeants).
     *
     * @param  list<string>|null  $sort
     * @return list<FormationsItem>
     */
    public function listFormations(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
    {
        return FormationsItem::collect($this->listDirectusItems(
            Config::ENDPOINT_FORMATIONS,
            limit: $limit,
            filter: Validator::filterCriteria($filterCriteria),
            sort: Validator::stringList($sort, 'sort'),
            offset: Validator::offset($offset),
            search: Validator::searchQuery($search, 'search'),
        ));
    }

    /**
     * Toutes les formations (entraîneurs, arbitres, dirigeants) correspondant au filtre, toutes pages confondues (20 pages max).
     *
     * @param  list<string>|null  $sort
     * @return list<FormationsItem>
     */
    public function listAllFormations(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
    {
        return FormationsItem::collect($this->listAllDirectusItems(
            Config::ENDPOINT_FORMATIONS,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ));
    }

    /**
     * Parcourt les formations (entraîneurs, arbitres, dirigeants) page par page, sans tout charger en mémoire.
     *
     * @param  list<string>|null  $sort
     * @return Generator<int, FormationsItem>
     */
    public function iterAllFormations(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
    {
        foreach ($this->iterAllDirectusItems(
            Config::ENDPOINT_FORMATIONS,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ) as $item) {
            yield FormationsItem::fromArray($item);
        }
    }

    /**
     * Une page de entraîneurs.
     *
     * @param  list<string>|null  $sort
     * @return list<EntraineursItem>
     */
    public function listEntraineurs(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
    {
        return EntraineursItem::collect($this->listDirectusItems(
            Config::ENDPOINT_ENTRAINEURS,
            limit: $limit,
            filter: Validator::filterCriteria($filterCriteria),
            sort: Validator::stringList($sort, 'sort'),
            offset: Validator::offset($offset),
            search: Validator::searchQuery($search, 'search'),
        ));
    }

    /**
     * Toutes les entraîneurs correspondant au filtre, toutes pages confondues (20 pages max).
     *
     * @param  list<string>|null  $sort
     * @return list<EntraineursItem>
     */
    public function listAllEntraineurs(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
    {
        return EntraineursItem::collect($this->listAllDirectusItems(
            Config::ENDPOINT_ENTRAINEURS,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ));
    }

    /**
     * Parcourt les entraîneurs page par page, sans tout charger en mémoire.
     *
     * @param  list<string>|null  $sort
     * @return Generator<int, EntraineursItem>
     */
    public function iterAllEntraineurs(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
    {
        foreach ($this->iterAllDirectusItems(
            Config::ENDPOINT_ENTRAINEURS,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ) as $item) {
            yield EntraineursItem::fromArray($item);
        }
    }

    /**
     * Une page de communes.
     *
     * @param  list<string>|null  $sort
     * @return list<CommunesItem>
     */
    public function listCommunes(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
    {
        return CommunesItem::collect($this->listDirectusItems(
            Config::ENDPOINT_COMMUNES,
            limit: $limit,
            filter: Validator::filterCriteria($filterCriteria),
            sort: Validator::stringList($sort, 'sort'),
            offset: Validator::offset($offset),
            search: Validator::searchQuery($search, 'search'),
        ));
    }

    /**
     * Toutes les communes correspondant au filtre, toutes pages confondues (20 pages max).
     *
     * @param  list<string>|null  $sort
     * @return list<CommunesItem>
     */
    public function listAllCommunes(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
    {
        return CommunesItem::collect($this->listAllDirectusItems(
            Config::ENDPOINT_COMMUNES,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ));
    }

    /**
     * Parcourt les communes page par page, sans tout charger en mémoire.
     *
     * @param  list<string>|null  $sort
     * @return Generator<int, CommunesItem>
     */
    public function iterAllCommunes(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
    {
        foreach ($this->iterAllDirectusItems(
            Config::ENDPOINT_COMMUNES,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ) as $item) {
            yield CommunesItem::fromArray($item);
        }
    }

    /**
     * Une page de officiels (arbitres, OTM).
     *
     * @param  list<string>|null  $sort
     * @return list<OfficielsItem>
     */
    public function listOfficiels(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
    {
        return OfficielsItem::collect($this->listDirectusItems(
            Config::ENDPOINT_OFFICIELS,
            limit: $limit,
            filter: Validator::filterCriteria($filterCriteria),
            sort: Validator::stringList($sort, 'sort'),
            offset: Validator::offset($offset),
            search: Validator::searchQuery($search, 'search'),
        ));
    }

    /**
     * Toutes les officiels (arbitres, OTM) correspondant au filtre, toutes pages confondues (20 pages max).
     *
     * @param  list<string>|null  $sort
     * @return list<OfficielsItem>
     */
    public function listAllOfficiels(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
    {
        return OfficielsItem::collect($this->listAllDirectusItems(
            Config::ENDPOINT_OFFICIELS,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ));
    }

    /**
     * Parcourt les officiels (arbitres, OTM) page par page, sans tout charger en mémoire.
     *
     * @param  list<string>|null  $sort
     * @return Generator<int, OfficielsItem>
     */
    public function iterAllOfficiels(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
    {
        foreach ($this->iterAllDirectusItems(
            Config::ENDPOINT_OFFICIELS,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ) as $item) {
            yield OfficielsItem::fromArray($item);
        }
    }

    /**
     * Une page de offres de pratique (basket santé, 3x3, micro-basket…).
     *
     * @param  list<string>|null  $sort
     * @return list<PratiquesItem>
     */
    public function listPratiques(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
    {
        return PratiquesItem::collect($this->listDirectusItems(
            Config::ENDPOINT_PRATIQUES,
            limit: $limit,
            filter: Validator::filterCriteria($filterCriteria),
            sort: Validator::stringList($sort, 'sort'),
            offset: Validator::offset($offset),
            search: Validator::searchQuery($search, 'search'),
        ));
    }

    /**
     * Toutes les offres de pratique (basket santé, 3x3, micro-basket…) correspondant au filtre, toutes pages confondues (20 pages max).
     *
     * @param  list<string>|null  $sort
     * @return list<PratiquesItem>
     */
    public function listAllPratiques(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
    {
        return PratiquesItem::collect($this->listAllDirectusItems(
            Config::ENDPOINT_PRATIQUES,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ));
    }

    /**
     * Parcourt les offres de pratique (basket santé, 3x3, micro-basket…) page par page, sans tout charger en mémoire.
     *
     * @param  list<string>|null  $sort
     * @return Generator<int, PratiquesItem>
     */
    public function iterAllPratiques(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
    {
        foreach ($this->iterAllDirectusItems(
            Config::ENDPOINT_PRATIQUES,
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ) as $item) {
            yield PratiquesItem::fromArray($item);
        }
    }

    // ------------------------------------------------------------------
    // Helpers batch (par lots de 50 identifiants)
    // ------------------------------------------------------------------

    /**
     * Engagements par identifiants (lots de 50 par requête).
     *
     * @param  list<int>  $ids
     * @return list<EngagementsItem>
     */
    public function listEngagementsByIds(array $ids): array
    {
        $results = [];

        foreach (array_chunk($ids, Config::BATCH_CHUNK_SIZE) as $chunk) {
            array_push($results, ...$this->listEngagements(count($chunk), Json::encode(['id' => ['_in' => $chunk]])));
        }

        return $results;
    }

    /**
     * Équipes engagées dans une poule.
     *
     * @return list<EngagementsItem>
     */
    public function listEngagementsByPoule(int $pouleId): array
    {
        return $this->listEngagements(250, Json::encode(['idPoule' => ['_eq' => $pouleId]]));
    }

    /**
     * Équipes engagées dans plusieurs poules (lots de 50 poules par requête).
     *
     * @param  list<int>  $pouleIds
     * @return list<EngagementsItem>
     */
    public function listEngagementsByPoules(array $pouleIds): array
    {
        $results = [];

        foreach (array_chunk($pouleIds, Config::BATCH_CHUNK_SIZE) as $chunk) {
            array_push($results, ...$this->listEngagements(250, Json::encode(['idPoule' => ['_in' => $chunk]])));
        }

        return $results;
    }

    /**
     * Toutes les rencontres d'une poule (500 max).
     *
     * @return list<RencontresItem>
     */
    public function listRencontresByPoule(int $pouleId): array
    {
        return $this->listRencontres(500, Json::encode(['idPoule' => ['_eq' => $pouleId]]));
    }

    /**
     * Rencontres de plusieurs poules (lots de 50 poules par requête).
     *
     * @param  list<int>  $pouleIds
     * @return list<RencontresItem>
     */
    public function listRencontresByPoules(array $pouleIds): array
    {
        $results = [];

        foreach (array_chunk($pouleIds, Config::BATCH_CHUNK_SIZE) as $chunk) {
            array_push($results, ...$this->listRencontres(500, Json::encode(['idPoule' => ['_in' => $chunk]])));
        }

        return $results;
    }

    /**
     * Entraîneurs par numéro de licence.
     *
     * @param  list<int|string>  $ids
     * @return list<EntraineursItem>
     */
    public function listEntraineursByIds(array $ids): array
    {
        $results = [];

        foreach (array_chunk($ids, Config::BATCH_CHUNK_SIZE) as $chunk) {
            $filter = Json::encode(['idLicence' => ['_in' => array_map('strval', $chunk)]]);
            array_push($results, ...$this->listEntraineurs(count($chunk), $filter));
        }

        return $results;
    }
}
