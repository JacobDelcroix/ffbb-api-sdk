<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Concerns;

use CoachBasket\Ffbb\Data\Models\CompetitionsHit;
use CoachBasket\Ffbb\Data\Models\ContentHit;
use CoachBasket\Ffbb\Data\Models\EngagementsHit;
use CoachBasket\Ffbb\Data\Models\FormationsHit;
use CoachBasket\Ffbb\Data\Models\OrganismesHit;
use CoachBasket\Ffbb\Data\Models\PratiquesHit;
use CoachBasket\Ffbb\Data\Models\RencontresHit;
use CoachBasket\Ffbb\Data\Models\SallesHit;
use CoachBasket\Ffbb\Data\Models\SearchResult;
use CoachBasket\Ffbb\Data\Models\TerrainsHit;
use CoachBasket\Ffbb\Data\Models\TournoisHit;
use CoachBasket\Ffbb\Search\GeoSortOrder;
use CoachBasket\Ffbb\Search\Index;
use CoachBasket\Ffbb\Search\MeilisearchSearcher;
use CoachBasket\Ffbb\Search\MultiSearchQuery;
use CoachBasket\Ffbb\Support\Validator;

/**
 * Recherche Meilisearch (miroir de _SearchFacade / MeilisearchFFBBClient).
 *
 * Chaque recherche renvoie un SearchResult typé : hits (DTO de l'index), estimatedTotalHits,
 * facetDistribution, facetStats… Comme en Python, toutes les pages sont récupérées jusqu'à
 * estimatedTotalHits et les hits sont filtrés côté client (HitMatcher).
 *
 * @property-read MeilisearchSearcher $search
 *
 * FICHIER GÉNÉRÉ par tools/generate_concerns.py — modifier le générateur plutôt que ce fichier.
 */
trait SearchesMeilisearch
{
    /**
     * Recherche universelle sur les 13 index (un résultat par index, dans l'ordre de l'enum Index).
     *
     * @return list<SearchResult<object>>|null
     */
    public function multiSearch(?string $name = null): ?array
    {
        $queries = MultiSearchQuery::forAllIndexes(Validator::searchQuery($name, 'name'));
        $results = $this->search->recursiveSmartMultiSearch($queries);

        if ($results === null) {
            return null;
        }

        $typed = [];

        foreach ($queries as $i => $query) {
            $typed[] = SearchResult::fromArray($results[$i] ?? [], $query->index->hitClass());
        }

        return $typed;
    }

    /**
     * Exécute une recherche par texte et type les résultats avec le DTO de l'index.
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<object>>|null
     */
    protected function searchMultiple(Index $index, ?array $names, ?array $filter, ?array $sort, ?int $limit): ?array
    {
        if ($names === null || $names === []) {
            return null;
        }

        $queries = array_map(
            static fn (?string $name): MultiSearchQuery => MultiSearchQuery::for($index, $name, $limit, $filter, $sort),
            array_values($names),
        );

        $results = $this->search->recursiveSmartMultiSearch($queries);

        return $results === null
            ? null
            : array_map(static fn (array $result): SearchResult => SearchResult::fromArray($result, $index->hitClass()), $results);
    }

    /**
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<object>|null
     */
    protected function searchOne(Index $index, ?string $name, ?array $filter, ?array $sort, ?int $limit): ?SearchResult
    {
        $results = $this->searchMultiple($index, $name !== null ? [$name] : null, $filter, $sort, $limit);

        return $results[0] ?? null;
    }

    private static function geoRadius(float $lat, float $lng, float $radiusKm): string
    {
        return sprintf('_geoRadius(%s, %s, %d)', self::num($lat), self::num($lng), (int) ($radiusKm * 1000));
    }

    private static function geoPoint(float $lat, float $lng, GeoSortOrder $order): string
    {
        return sprintf('_geoPoint(%s, %s):%s', self::num($lat), self::num($lng), $order->value);
    }

    /**
     * Représentation d'un flottant identique à str(float) en Python (45.0 → "45.0").
     */
    private static function num(float $value): string
    {
        $repr = (string) $value;

        return str_contains($repr, '.') || str_contains($repr, 'E') ? $repr : $repr.'.0';
    }

    /**
     * Recherche plein texte dans les compétitions (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<CompetitionsHit>|null
     */
    public function searchCompetitions(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::Competitions, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les compétitions, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<CompetitionsHit>>|null
     */
    public function searchMultipleCompetitions(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::Competitions, $names, $filter, $sort, $limit);
    }

    /**
     * Recherche plein texte dans les organismes (clubs, comités, ligues) (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<OrganismesHit>|null
     */
    public function searchOrganismes(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::Organismes, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les organismes (clubs, comités, ligues), en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<OrganismesHit>>|null
     */
    public function searchMultipleOrganismes(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::Organismes, $names, $filter, $sort, $limit);
    }

    /**
     * Recherche plein texte dans les offres de pratique (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<PratiquesHit>|null
     */
    public function searchPratiques(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::Pratiques, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les offres de pratique, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<PratiquesHit>>|null
     */
    public function searchMultiplePratiques(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::Pratiques, $names, $filter, $sort, $limit);
    }

    /**
     * Recherche plein texte dans les rencontres (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<RencontresHit>|null
     */
    public function searchRencontres(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::Rencontres, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les rencontres, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<RencontresHit>>|null
     */
    public function searchMultipleRencontres(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::Rencontres, $names, $filter, $sort, $limit);
    }

    /**
     * Recherche plein texte dans les salles (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<SallesHit>|null
     */
    public function searchSalles(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::Salles, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les salles, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<SallesHit>>|null
     */
    public function searchMultipleSalles(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::Salles, $names, $filter, $sort, $limit);
    }

    /**
     * Recherche plein texte dans les terrains (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<TerrainsHit>|null
     */
    public function searchTerrains(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::Terrains, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les terrains, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<TerrainsHit>>|null
     */
    public function searchMultipleTerrains(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::Terrains, $names, $filter, $sort, $limit);
    }

    /**
     * Recherche plein texte dans les tournois (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<TournoisHit>|null
     */
    public function searchTournois(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::Tournois, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les tournois, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<TournoisHit>>|null
     */
    public function searchMultipleTournois(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::Tournois, $names, $filter, $sort, $limit);
    }

    /**
     * Recherche plein texte dans les équipes engagées (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<EngagementsHit>|null
     */
    public function searchEngagements(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::Engagements, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les équipes engagées, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<EngagementsHit>>|null
     */
    public function searchMultipleEngagements(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::Engagements, $names, $filter, $sort, $limit);
    }

    /**
     * Recherche plein texte dans les formations (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<FormationsHit>|null
     */
    public function searchFormations(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::Formations, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les formations, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<FormationsHit>>|null
     */
    public function searchMultipleFormations(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::Formations, $names, $filter, $sort, $limit);
    }

    /**
     * Recherche plein texte dans les actualités ffbb.com (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<ContentHit>|null
     */
    public function searchNews(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::News, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les actualités ffbb.com, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<ContentHit>>|null
     */
    public function searchMultipleNews(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::News, $names, $filter, $sort, $limit);
    }

    /**
     * Recherche plein texte dans les vidéos YouTube FFBB (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<ContentHit>|null
     */
    public function searchYoutubeVideos(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::YoutubeVideos, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les vidéos YouTube FFBB, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<ContentHit>>|null
     */
    public function searchMultipleYoutubeVideos(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::YoutubeVideos, $names, $filter, $sort, $limit);
    }

    /**
     * Recherche plein texte dans les flux RSS FFBB (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<ContentHit>|null
     */
    public function searchRss(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::Rss, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les flux RSS FFBB, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<ContentHit>>|null
     */
    public function searchMultipleRss(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::Rss, $names, $filter, $sort, $limit);
    }

    /**
     * Recherche plein texte dans les galeries photos FFBB (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<ContentHit>|null
     */
    public function searchGaleries(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {
        return $this->searchOne(Index::Galeries, $name, $filter, $sort, $limit);
    }

    /**
     * Plusieurs recherches dans les galeries photos FFBB, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<ContentHit>>|null
     */
    public function searchMultipleGaleries(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {
        return $this->searchMultiple(Index::Galeries, $names, $filter, $sort, $limit);
    }

    // ------------------------------------------------------------------
    // Recherches géographiques
    // ------------------------------------------------------------------

    /**
     * Clubs dans un rayon autour d'un point GPS, triés par distance.
     *
     * @return SearchResult<OrganismesHit>|null
     */
    public function searchOrganismesByGeo(float $lat, float $lng, float $radiusKm = 10.0, string $q = '', ?int $limit = 20, GeoSortOrder $geoSort = GeoSortOrder::NearestFirst): ?SearchResult
    {
        return $this->searchOrganismes($q, [self::geoRadius($lat, $lng, $radiusKm)], [self::geoPoint($lat, $lng, $geoSort)], $limit);
    }

    /**
     * Clubs d'une commune (correspondance exacte sur le nom de la commune).
     *
     * @return SearchResult<OrganismesHit>|null
     */
    public function searchOrganismesByCity(string $cityName, string $q = '', int $limit = 200): ?SearchResult
    {
        return $this->searchOrganismes($q, [sprintf('commune = "%s"', $cityName)], null, $limit);
    }

    /**
     * Salles dans un rayon autour d'un point GPS.
     *
     * @return SearchResult<SallesHit>|null
     */
    public function searchSallesByGeo(float $lat, float $lng, float $radiusKm = 10.0, string $q = '', ?int $limit = 20, GeoSortOrder $geoSort = GeoSortOrder::NearestFirst): ?SearchResult
    {
        return $this->searchSalles($q, [self::geoRadius($lat, $lng, $radiusKm)], [self::geoPoint($lat, $lng, $geoSort)], $limit);
    }

    /**
     * Équipes engagées dans un rayon autour d'un point GPS.
     *
     * @return SearchResult<EngagementsHit>|null
     */
    public function searchEngagementsByGeo(float $lat, float $lng, float $radiusKm = 10.0, string $q = '', ?int $limit = 20, GeoSortOrder $geoSort = GeoSortOrder::NearestFirst): ?SearchResult
    {
        return $this->searchEngagements($q, [self::geoRadius($lat, $lng, $radiusKm)], [self::geoPoint($lat, $lng, $geoSort)], $limit);
    }

    /**
     * Équipes engagées autour d'un point, filtrées par sexe et niveau.
     *
     * @param  list<string>|null  $sexes  ex. ['F', 'M']
     * @param  list<string>|null  $niveauCodes  ex. ['DEP', 'REG']
     * @return SearchResult<EngagementsHit>|null
     */
    public function searchEngagementsFiltered(float $lat, float $lng, float $radiusKm = 10.0, string $q = '', ?int $limit = 5000, ?array $sexes = null, ?array $niveauCodes = null): ?SearchResult
    {
        $filters = [self::geoRadius($lat, $lng, $radiusKm)];

        if ($sexes !== null && $sexes !== []) {
            $filters[] = implode(' OR ', array_map(static fn (string $s): string => sprintf('sexe = "%s"', $s), $sexes));
        }

        if ($niveauCodes !== null && $niveauCodes !== []) {
            $filters[] = implode(' OR ', array_map(static fn (string $n): string => sprintf('niveau.code = "%s"', $n), $niveauCodes));
        }

        return $this->searchEngagements($q, $filters, null, $limit);
    }
}
