"""Génère les traits répétitifs de src/Concerns/ (listes, getters, intégrations externes, recherche).

Usage : python3 tools/generate_concerns.py

Pour ajouter une ressource : compléter les tables ci-dessous, relancer le script,
puis `composer docs` et `composer test`. Les traits à logique propre
(ManagesOrganismes, ManagesCompetitions, InteractsWithDirectus) sont écrits à la main.
"""
from pathlib import Path

ROOT = Path(__file__).resolve().parent.parent
CONCERNS = ROOT / 'src' / 'Concerns'
HEADER = '''<?php

declare(strict_types=1);

namespace CoachBasket\\Ffbb\\Concerns;
'''
GENERATED = ' * FICHIER GÉNÉRÉ par tools/generate_concerns.py — modifier le générateur plutôt que ce fichier.'

# ressource (suffixe des méthodes) : (constante d'endpoint, DTO, libellé pluriel, libellé d'un élément)
RESOURCES = {
    'Rencontres': ('RENCONTRES', 'RencontresItem', 'rencontres (matchs)', "une rencontre (match) : équipes, date, score, salle, officiels"),
    'Salles': ('SALLES', 'SallesItem', 'salles (gymnases)', 'une salle : nom, adresse, commune, coordonnées'),
    'Terrains': ('TERRAINS', 'TerrainsItem', 'terrains 3x3 / extérieurs', 'un terrain (3x3 / extérieur)'),
    'Tournois': ('TOURNOIS', 'TournoisItem', 'tournois (dont 3x3)', 'un tournoi'),
    'Engagements': ('ENGAGEMENTS', 'EngagementsItem', "équipes engagées (une équipe d'un club dans une compétition)", "un engagement : une équipe d'un club dans une compétition / poule"),
    'Formations': ('FORMATIONS', 'FormationsItem', 'formations (entraîneurs, arbitres, dirigeants)', 'une formation'),
    'Entraineurs': ('ENTRAINEURS', 'EntraineursItem', 'entraîneurs', 'un entraîneur (par numéro de licence)'),
    'Communes': ('COMMUNES', 'CommunesItem', 'communes', 'une commune'),
    'Officiels': ('OFFICIELS', 'OfficielsItem', 'officiels (arbitres, OTM)', 'un officiel (arbitre, OTM)'),
    'Pratiques': ('PRATIQUES', 'PratiquesItem', 'offres de pratique (basket santé, 3x3, micro-basket…)', 'une offre de pratique'),
}
SINGULAR = {
    'Rencontre': 'Rencontres', 'Engagement': 'Engagements', 'Formation': 'Formations', 'Entraineur': 'Entraineurs',
    'Commune': 'Communes', 'Officiel': 'Officiels', 'Salle': 'Salles', 'Terrain': 'Terrains', 'Tournoi': 'Tournois',
    'Pratique': 'Pratiques',
}
EXTERNAL_GET = {
    'GeniusSportMatch': ('GENIUS_SPORT_MATCHES', 'GeniusSportMatchesItem', 'Un match Genius Sports (statistiques live).'),
    'RematchVideo': ('REMATCH_VIDEOS', 'RematchVideosItem', 'Une vidéo Rematch.'),
    'EdfMatch': ('EDF_MATCHES', 'EdfMatchesItem', "Un match d'une équipe de France."),
    'EdfPlayer': ('EDF_PLAYERS', 'EdfPlayersItem', 'Un joueur ou une joueuse des équipes de France.'),
}
EXTERNAL_LIST = {
    'GeniusSportMatches': ('GENIUS_SPORT_MATCHES', 'GeniusSportMatchesItem', 'Matchs Genius Sports (statistiques live).'),
    'GeniusSportsLiveLogs': ('GENIUS_SPORTS_LIVE_LOGS', 'GeniusSportsLiveLogsItem', 'Journal des événements live Genius Sports.'),
    'RematchVideos': ('REMATCH_VIDEOS', 'RematchVideosItem', 'Vidéos Rematch.'),
    'EdfMatches': ('EDF_MATCHES', 'EdfMatchesItem', 'Matchs des équipes de France.'),
    'EdfPlayers': ('EDF_PLAYERS', 'EdfPlayersItem', 'Joueurs et joueuses des équipes de France.'),
    'EdfTeams': ('EDF_TEAMS', 'EdfTeamsItem', 'Équipes de France.'),
    'EdfRosters': ('EDF_ROSTERS', 'EdfRostersItem', 'Effectifs des équipes de France.'),
}
# méthode : (case de l'enum Index, DTO de hit, libellé)
SEARCH = {
    'Competitions': ('Competitions', 'CompetitionsHit', 'compétitions'),
    'Organismes': ('Organismes', 'OrganismesHit', 'organismes (clubs, comités, ligues)'),
    'Pratiques': ('Pratiques', 'PratiquesHit', 'offres de pratique'),
    'Rencontres': ('Rencontres', 'RencontresHit', 'rencontres'),
    'Salles': ('Salles', 'SallesHit', 'salles'),
    'Terrains': ('Terrains', 'TerrainsHit', 'terrains'),
    'Tournois': ('Tournois', 'TournoisHit', 'tournois'),
    'Engagements': ('Engagements', 'EngagementsHit', 'équipes engagées'),
    'Formations': ('Formations', 'FormationsHit', 'formations'),
    'News': ('News', 'ContentHit', 'actualités ffbb.com'),
    'YoutubeVideos': ('YoutubeVideos', 'ContentHit', 'vidéos YouTube FFBB'),
    'Rss': ('Rss', 'ContentHit', 'flux RSS FFBB'),
    'Galeries': ('Galeries', 'ContentHit', 'galeries photos FFBB'),
}


def lists() -> str:
    dtos = sorted({dto for _, dto, _, _ in RESOURCES.values()})
    out = [HEADER, 'use CoachBasket\\Ffbb\\Config;']
    out += [f'use CoachBasket\\Ffbb\\Data\\{dto};' for dto in dtos]
    out += ['use CoachBasket\\Ffbb\\Support\\Json;', 'use CoachBasket\\Ffbb\\Support\\Validator;', 'use Generator;', '', '''/**
 * Listes typées, paginées et en streaming (miroir de ListMixin / ListAllMixin
 * et des helpers batch de _RestFacade).
 *
 * Pour chaque ressource :
 *  - list{X}()     : une page (limit / offset) ;
 *  - listAll{X}()  : toutes les pages (max 20 × pageSize, maxItems au total) ;
 *  - iterAll{X}()  : générateur paresseux (équivalent de aiter_all_x).
 *
''' + GENERATED + '''
 */
trait ListsResources
{''']
    for name, (const, dto, plural, _) in RESOURCES.items():
        out.append(f'''    /**
     * Une page de {plural}.
     *
     * @param  list<string>|null  $sort
     * @return list<{dto}>
     */
    public function list{name}(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
    {{
        return {dto}::collect($this->listDirectusItems(
            Config::ENDPOINT_{const},
            limit: $limit,
            filter: Validator::filterCriteria($filterCriteria),
            sort: Validator::stringList($sort, 'sort'),
            offset: Validator::offset($offset),
            search: Validator::searchQuery($search, 'search'),
        ));
    }}

    /**
     * Toutes les {plural} correspondant au filtre, toutes pages confondues (20 pages max).
     *
     * @param  list<string>|null  $sort
     * @return list<{dto}>
     */
    public function listAll{name}(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
    {{
        return {dto}::collect($this->listAllDirectusItems(
            Config::ENDPOINT_{const},
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ));
    }}

    /**
     * Parcourt les {plural} page par page, sans tout charger en mémoire.
     *
     * @param  list<string>|null  $sort
     * @return Generator<int, {dto}>
     */
    public function iterAll{name}(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
    {{
        foreach ($this->iterAllDirectusItems(
            Config::ENDPOINT_{const},
            Validator::filterCriteria($filterCriteria),
            Validator::stringList($sort, 'sort'),
            Validator::searchQuery($search, 'search'),
            $pageSize,
            $maxItems,
        ) as $item) {{
            yield {dto}::fromArray($item);
        }}
    }}
''')
    out.append('''    // ------------------------------------------------------------------
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
''')
    return '\n'.join(out)


def resources() -> str:
    dtos = sorted({RESOURCES[p][1] for p in SINGULAR.values()} | {'SessionsItem', 'ConfigurationItem'})
    out = [HEADER, 'use CoachBasket\\Ffbb\\Config;']
    out += [f'use CoachBasket\\Ffbb\\Data\\{dto};' for dto in dtos]
    out += ['use CoachBasket\\Ffbb\\Data\\Models\\Live;', 'use CoachBasket\\Ffbb\\Exceptions\\FfbbException;',
            'use CoachBasket\\Ffbb\\Exceptions\\FfbbNotFoundException;', 'use CoachBasket\\Ffbb\\Requests\\Directus\\GetConfiguration;',
            'use CoachBasket\\Ffbb\\Requests\\Directus\\GetLives;', 'use CoachBasket\\Ffbb\\Requests\\Directus\\GetOpenApiSpec;',
            'use CoachBasket\\Ffbb\\Support\\Json;', '', '''/**
 * Getters simples, lives, configuration, spec OpenAPI et sessions (miroir de GettersMixin).
 *
''' + GENERATED + '''
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
''']
    for singular, plural in SINGULAR.items():
        const, dto, _, one = RESOURCES[plural]
        out.append(f'''    /**
     * Détail d'{one} (null si introuvable).
     */
    public function get{singular}(int|string $id): ?{dto}
    {{
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_{const}, $id), {dto}::class);
    }}
''')
    out.append('''    /**
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
''')
    return '\n'.join(out)


def external() -> str:
    dtos = sorted({v[1] for v in EXTERNAL_GET.values()} | {v[1] for v in EXTERNAL_LIST.values()})
    out = [HEADER, 'use CoachBasket\\Ffbb\\Config;']
    out += [f'use CoachBasket\\Ffbb\\Data\\{dto};' for dto in dtos]
    out += ['', '''/**
 * Intégrations externes exposées par Directus : Genius Sports, Rematch, équipes de France
 * (miroir de ExternalMixin).
 *
''' + GENERATED + '''
 */
trait ManagesExternalResources
{''']
    for name, (const, dto, doc) in EXTERNAL_GET.items():
        out.append(f'''    /**
     * {doc}
     *
     * @param  list<string>|null  $fields
     */
    public function get{name}(int|string $id, ?array $fields = null): ?{dto}
    {{
        return self::hydrateOne($this->getDirectusItem(Config::ENDPOINT_{const}, $id, $fields), {dto}::class);
    }}
''')
    for name, (const, dto, doc) in EXTERNAL_LIST.items():
        out.append(f'''    /**
     * {doc}
     *
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @return list<{dto}>
     */
    public function list{name}(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, string|array|null $sort = null): array
    {{
        return {dto}::collect($this->listDirectusItems(Config::ENDPOINT_{const}, $limit, $fields, $filterCriteria, $sort));
    }}
''')
    out[-1] += '}\n'
    return '\n'.join(out)


def search() -> str:
    hits = sorted({v[1] for v in SEARCH.values()})
    out = [HEADER]
    out += [f'use CoachBasket\\Ffbb\\Data\\Models\\{h};' for h in hits]
    out += ['use CoachBasket\\Ffbb\\Data\\Models\\SearchResult;', 'use CoachBasket\\Ffbb\\Search\\GeoSortOrder;',
            'use CoachBasket\\Ffbb\\Search\\Index;', 'use CoachBasket\\Ffbb\\Search\\MeilisearchSearcher;',
            'use CoachBasket\\Ffbb\\Search\\MultiSearchQuery;', 'use CoachBasket\\Ffbb\\Support\\Validator;', '', '''/**
 * Recherche Meilisearch (miroir de _SearchFacade / MeilisearchFFBBClient).
 *
 * Chaque recherche renvoie un SearchResult typé : hits (DTO de l'index), estimatedTotalHits,
 * facetDistribution, facetStats… `limit` plafonne le nombre de hits (les pages suivantes sont
 * récupérées si `limit` dépasse la taille d'une page Meilisearch) ; `limit: null` récupère toutes les pages
 * jusqu'à estimatedTotalHits, comme le Python. Les hits sont filtrés côté client (HitMatcher).
 *
 * @property-read MeilisearchSearcher $search
 *
''' + GENERATED + '''
 */
trait SearchesMeilisearch
{
    /**
     * Recherche universelle sur les 13 index (un résultat par index, dans l'ordre de l'enum Index).
     *
     * @param  int|null  $limit  hits maximum par index (null = tous)
     * @return list<SearchResult<object>>|null
     */
    public function multiSearch(?string $name = null, ?int $limit = 10): ?array
    {
        $queries = MultiSearchQuery::forAllIndexes(Validator::searchQuery($name, 'name'), $limit);
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

    /**
     * Filtre d'égalité Meilisearch, valeur entre guillemets échappée.
     */
    private static function equals(string $attribute, string $value): string
    {
        return sprintf('%s = "%s"', $attribute, addcslashes($value, '"\\\\'));
    }

    /**
     * @param  list<string>  $values
     */
    private static function anyOf(string $attribute, array $values): string
    {
        return implode(' OR ', array_map(static fn (string $v): string => self::equals($attribute, $v), $values));
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
''']
    for name, (case, hit, label) in SEARCH.items():
        out.append(f'''    /**
     * Recherche plein texte dans les {label} (null si aucun nom).
     *
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return SearchResult<{hit}>|null
     */
    public function search{name}(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
    {{
        return $this->searchOne(Index::{case}, $name, $filter, $sort, $limit);
    }}

    /**
     * Plusieurs recherches dans les {label}, en un seul appel multi-search (un résultat par nom).
     *
     * @param  list<string|null>|null  $names
     * @param  list<string>|null  $filter
     * @param  list<string>|null  $sort
     * @return list<SearchResult<{hit}>>|null
     */
    public function searchMultiple{name}(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
    {{
        return $this->searchMultiple(Index::{case}, $names, $filter, $sort, $limit);
    }}
''')
    out.append('''    // ------------------------------------------------------------------
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
     * Clubs d'une commune (correspondance exacte sur le nom de la commune, insensible à la casse).
     *
     * Filtre sur `commune.libelle` : le Python filtre sur `commune`, qui n'est pas filtrable
     * sur l'index ffbbserver_organismes (HTTP 400 en direct).
     *
     * @return SearchResult<OrganismesHit>|null
     */
    public function searchOrganismesByCity(string $cityName, string $q = '', int $limit = 200): ?SearchResult
    {
        return $this->searchOrganismes($q, [self::equals('commune.libelle', $cityName)], null, $limit);
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
     * Les deux filtres sont appliqués côté serveur. Le sexe porte sur `idCompetition.sexe` (le Python
     * filtre sur `sexe`, non filtrable : HTTP 400 en direct) ; les codes courts sont traduits vers les
     * valeurs stockées (M → Masculin, F → Féminin, MI → Mixte), toute autre valeur est transmise telle quelle.
     * Les codes de niveau sont les codes exacts de `niveau.code` (ex. PRM, SED2F, U13R1M) : il n'existe
     * pas de code générique « départemental » ou « régional ».
     *
     * @param  list<string>|null  $sexes  ex. ['F', 'MI'] ou ['Féminin']
     * @param  list<string>|null  $niveauCodes  ex. ['PRF', 'SED2F']
     * @return SearchResult<EngagementsHit>|null
     */
    public function searchEngagementsFiltered(float $lat, float $lng, float $radiusKm = 10.0, string $q = '', ?int $limit = 5000, ?array $sexes = null, ?array $niveauCodes = null): ?SearchResult
    {
        $filters = [self::geoRadius($lat, $lng, $radiusKm)];

        if ($sexes !== null && $sexes !== []) {
            $filters[] = self::anyOf('idCompetition.sexe', array_map(static fn (string $s): string => match (strtoupper($s)) {
                'M' => 'Masculin',
                'F' => 'Féminin',
                'MI' => 'Mixte',
                default => $s,
            }, $sexes));
        }

        if ($niveauCodes !== null && $niveauCodes !== []) {
            $filters[] = self::anyOf('niveau.code', $niveauCodes);
        }

        return $this->searchEngagements($q, $filters, null, $limit);
    }
}
''')
    return '\n'.join(out)


def main() -> None:
    files = {
        'ListsResources.php': lists(),
        'ManagesResources.php': resources(),
        'ManagesExternalResources.php': external(),
        'SearchesMeilisearch.php': search(),
    }
    for name, content in files.items():
        (CONCERNS / name).write_text(content)
        print(f'src/Concerns/{name}')


if __name__ == '__main__':
    main()
