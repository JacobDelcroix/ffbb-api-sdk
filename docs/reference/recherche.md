<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Recherche (Meilisearch)

Recherche plein texte et géographique.
Chaque résultat est le tableau Meilisearch d'une requête : `hits`, `estimatedTotalHits`, `facetDistribution`… Comme dans le SDK Python, toutes les pages sont récupérées et les hits sont filtrés côté client.

Guide avec exemples : [05-recherche](../guides/05-recherche.md)

| Méthode | Retour | Description |
|---|---|---|
| [`multiSearch()`](#multisearch) | `list<SearchResult<object>>\|null` | Recherche universelle sur les 13 index (un résultat par index, dans l'ordre de l'enum Index). |
| [`searchCompetitions()`](#searchcompetitions) | `SearchResult<CompetitionsHit>\|null` | Recherche plein texte dans les compétitions (null si aucun nom). |
| [`searchMultipleCompetitions()`](#searchmultiplecompetitions) | `list<SearchResult<CompetitionsHit>>\|null` | Plusieurs recherches dans les compétitions, en un seul appel multi-search (un résultat par nom). |
| [`searchOrganismes()`](#searchorganismes) | `SearchResult<OrganismesHit>\|null` | Recherche plein texte dans les organismes (clubs, comités, ligues) (null si aucun nom). |
| [`searchMultipleOrganismes()`](#searchmultipleorganismes) | `list<SearchResult<OrganismesHit>>\|null` | Plusieurs recherches dans les organismes (clubs, comités, ligues), en un seul appel multi-search (un résultat par nom). |
| [`searchPratiques()`](#searchpratiques) | `SearchResult<PratiquesHit>\|null` | Recherche plein texte dans les offres de pratique (null si aucun nom). |
| [`searchMultiplePratiques()`](#searchmultiplepratiques) | `list<SearchResult<PratiquesHit>>\|null` | Plusieurs recherches dans les offres de pratique, en un seul appel multi-search (un résultat par nom). |
| [`searchRencontres()`](#searchrencontres) | `SearchResult<RencontresHit>\|null` | Recherche plein texte dans les rencontres (null si aucun nom). |
| [`searchMultipleRencontres()`](#searchmultiplerencontres) | `list<SearchResult<RencontresHit>>\|null` | Plusieurs recherches dans les rencontres, en un seul appel multi-search (un résultat par nom). |
| [`searchSalles()`](#searchsalles) | `SearchResult<SallesHit>\|null` | Recherche plein texte dans les salles (null si aucun nom). |
| [`searchMultipleSalles()`](#searchmultiplesalles) | `list<SearchResult<SallesHit>>\|null` | Plusieurs recherches dans les salles, en un seul appel multi-search (un résultat par nom). |
| [`searchTerrains()`](#searchterrains) | `SearchResult<TerrainsHit>\|null` | Recherche plein texte dans les terrains (null si aucun nom). |
| [`searchMultipleTerrains()`](#searchmultipleterrains) | `list<SearchResult<TerrainsHit>>\|null` | Plusieurs recherches dans les terrains, en un seul appel multi-search (un résultat par nom). |
| [`searchTournois()`](#searchtournois) | `SearchResult<TournoisHit>\|null` | Recherche plein texte dans les tournois (null si aucun nom). |
| [`searchMultipleTournois()`](#searchmultipletournois) | `list<SearchResult<TournoisHit>>\|null` | Plusieurs recherches dans les tournois, en un seul appel multi-search (un résultat par nom). |
| [`searchEngagements()`](#searchengagements) | `SearchResult<EngagementsHit>\|null` | Recherche plein texte dans les équipes engagées (null si aucun nom). |
| [`searchMultipleEngagements()`](#searchmultipleengagements) | `list<SearchResult<EngagementsHit>>\|null` | Plusieurs recherches dans les équipes engagées, en un seul appel multi-search (un résultat par nom). |
| [`searchFormations()`](#searchformations) | `SearchResult<FormationsHit>\|null` | Recherche plein texte dans les formations (null si aucun nom). |
| [`searchMultipleFormations()`](#searchmultipleformations) | `list<SearchResult<FormationsHit>>\|null` | Plusieurs recherches dans les formations, en un seul appel multi-search (un résultat par nom). |
| [`searchNews()`](#searchnews) | `SearchResult<ContentHit>\|null` | Recherche plein texte dans les actualités ffbb.com (null si aucun nom). |
| [`searchMultipleNews()`](#searchmultiplenews) | `list<SearchResult<ContentHit>>\|null` | Plusieurs recherches dans les actualités ffbb.com, en un seul appel multi-search (un résultat par nom). |
| [`searchYoutubeVideos()`](#searchyoutubevideos) | `SearchResult<ContentHit>\|null` | Recherche plein texte dans les vidéos YouTube FFBB (null si aucun nom). |
| [`searchMultipleYoutubeVideos()`](#searchmultipleyoutubevideos) | `list<SearchResult<ContentHit>>\|null` | Plusieurs recherches dans les vidéos YouTube FFBB, en un seul appel multi-search (un résultat par nom). |
| [`searchRss()`](#searchrss) | `SearchResult<ContentHit>\|null` | Recherche plein texte dans les flux RSS FFBB (null si aucun nom). |
| [`searchMultipleRss()`](#searchmultiplerss) | `list<SearchResult<ContentHit>>\|null` | Plusieurs recherches dans les flux RSS FFBB, en un seul appel multi-search (un résultat par nom). |
| [`searchGaleries()`](#searchgaleries) | `SearchResult<ContentHit>\|null` | Recherche plein texte dans les galeries photos FFBB (null si aucun nom). |
| [`searchMultipleGaleries()`](#searchmultiplegaleries) | `list<SearchResult<ContentHit>>\|null` | Plusieurs recherches dans les galeries photos FFBB, en un seul appel multi-search (un résultat par nom). |
| [`searchOrganismesByGeo()`](#searchorganismesbygeo) | `SearchResult<OrganismesHit>\|null` | Clubs dans un rayon autour d'un point GPS, triés par distance. |
| [`searchOrganismesByCity()`](#searchorganismesbycity) | `SearchResult<OrganismesHit>\|null` | Clubs d'une commune (correspondance exacte sur le nom de la commune, insensible à la casse). |
| [`searchSallesByGeo()`](#searchsallesbygeo) | `SearchResult<SallesHit>\|null` | Salles dans un rayon autour d'un point GPS. |
| [`searchEngagementsByGeo()`](#searchengagementsbygeo) | `SearchResult<EngagementsHit>\|null` | Équipes engagées dans un rayon autour d'un point GPS. |
| [`searchEngagementsFiltered()`](#searchengagementsfiltered) | `SearchResult<EngagementsHit>\|null` | Équipes engagées autour d'un point, filtrées par sexe et niveau. |

### `multiSearch()`

Recherche universelle sur les 13 index (un résultat par index, dans l'ordre de l'enum Index).

```php
public function multiSearch(?string $name = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$limit` | `int\|null` | `10` | hits maximum par index (null = tous) |

**Retour :** `list<SearchResult<object>>|null`

Équivalent Python : `multi_search`

### `searchCompetitions()`

Recherche plein texte dans les compétitions (null si aucun nom).

```php
public function searchCompetitions(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<CompetitionsHit>|null`

Équivalent Python : `search_competitions`

### `searchMultipleCompetitions()`

Plusieurs recherches dans les compétitions, en un seul appel multi-search (un résultat par nom).

```php
public function searchMultipleCompetitions(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<CompetitionsHit>>|null`

Équivalent Python : `search_multiple_competitions`

### `searchOrganismes()`

Recherche plein texte dans les organismes (clubs, comités, ligues) (null si aucun nom).

```php
public function searchOrganismes(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<OrganismesHit>|null`

Équivalent Python : `search_organismes`

### `searchMultipleOrganismes()`

Plusieurs recherches dans les organismes (clubs, comités, ligues), en un seul appel multi-search (un résultat par nom).

```php
public function searchMultipleOrganismes(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<OrganismesHit>>|null`

Équivalent Python : `search_multiple_organismes`

### `searchPratiques()`

Recherche plein texte dans les offres de pratique (null si aucun nom).

```php
public function searchPratiques(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<PratiquesHit>|null`

Équivalent Python : `search_pratiques`

### `searchMultiplePratiques()`

Plusieurs recherches dans les offres de pratique, en un seul appel multi-search (un résultat par nom).

```php
public function searchMultiplePratiques(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<PratiquesHit>>|null`

Équivalent Python : `search_multiple_pratiques`

### `searchRencontres()`

Recherche plein texte dans les rencontres (null si aucun nom).

```php
public function searchRencontres(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<RencontresHit>|null`

Équivalent Python : `search_rencontres`

### `searchMultipleRencontres()`

Plusieurs recherches dans les rencontres, en un seul appel multi-search (un résultat par nom).

```php
public function searchMultipleRencontres(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<RencontresHit>>|null`

Équivalent Python : `search_multiple_rencontres`

### `searchSalles()`

Recherche plein texte dans les salles (null si aucun nom).

```php
public function searchSalles(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<SallesHit>|null`

Équivalent Python : `search_salles`

### `searchMultipleSalles()`

Plusieurs recherches dans les salles, en un seul appel multi-search (un résultat par nom).

```php
public function searchMultipleSalles(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<SallesHit>>|null`

Équivalent Python : `search_multiple_salles`

### `searchTerrains()`

Recherche plein texte dans les terrains (null si aucun nom).

```php
public function searchTerrains(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<TerrainsHit>|null`

Équivalent Python : `search_terrains`

### `searchMultipleTerrains()`

Plusieurs recherches dans les terrains, en un seul appel multi-search (un résultat par nom).

```php
public function searchMultipleTerrains(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<TerrainsHit>>|null`

Équivalent Python : `search_multiple_terrains`

### `searchTournois()`

Recherche plein texte dans les tournois (null si aucun nom).

```php
public function searchTournois(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<TournoisHit>|null`

Équivalent Python : `search_tournois`

### `searchMultipleTournois()`

Plusieurs recherches dans les tournois, en un seul appel multi-search (un résultat par nom).

```php
public function searchMultipleTournois(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<TournoisHit>>|null`

Équivalent Python : `search_multiple_tournois`

### `searchEngagements()`

Recherche plein texte dans les équipes engagées (null si aucun nom).

```php
public function searchEngagements(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<EngagementsHit>|null`

Équivalent Python : `search_engagements`

### `searchMultipleEngagements()`

Plusieurs recherches dans les équipes engagées, en un seul appel multi-search (un résultat par nom).

```php
public function searchMultipleEngagements(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<EngagementsHit>>|null`

Équivalent Python : `search_multiple_engagements`

### `searchFormations()`

Recherche plein texte dans les formations (null si aucun nom).

```php
public function searchFormations(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<FormationsHit>|null`

Équivalent Python : `search_formations`

### `searchMultipleFormations()`

Plusieurs recherches dans les formations, en un seul appel multi-search (un résultat par nom).

```php
public function searchMultipleFormations(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<FormationsHit>>|null`

Équivalent Python : `search_multiple_formations`

### `searchNews()`

Recherche plein texte dans les actualités ffbb.com (null si aucun nom).

```php
public function searchNews(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<ContentHit>|null`

Équivalent Python : `search_news`

### `searchMultipleNews()`

Plusieurs recherches dans les actualités ffbb.com, en un seul appel multi-search (un résultat par nom).

```php
public function searchMultipleNews(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<ContentHit>>|null`

Équivalent Python : `search_multiple_news`

### `searchYoutubeVideos()`

Recherche plein texte dans les vidéos YouTube FFBB (null si aucun nom).

```php
public function searchYoutubeVideos(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<ContentHit>|null`

Équivalent Python : `search_youtube_videos`

### `searchMultipleYoutubeVideos()`

Plusieurs recherches dans les vidéos YouTube FFBB, en un seul appel multi-search (un résultat par nom).

```php
public function searchMultipleYoutubeVideos(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<ContentHit>>|null`

Équivalent Python : `search_multiple_youtube_videos`

### `searchRss()`

Recherche plein texte dans les flux RSS FFBB (null si aucun nom).

```php
public function searchRss(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<ContentHit>|null`

Équivalent Python : `search_rss`

### `searchMultipleRss()`

Plusieurs recherches dans les flux RSS FFBB, en un seul appel multi-search (un résultat par nom).

```php
public function searchMultipleRss(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<ContentHit>>|null`

Équivalent Python : `search_multiple_rss`

### `searchGaleries()`

Recherche plein texte dans les galeries photos FFBB (null si aucun nom).

```php
public function searchGaleries(?string $name = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$name` | `?string` | `null` | Texte recherché (null : aucune requête). |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<ContentHit>|null`

Équivalent Python : `search_galeries`

### `searchMultipleGaleries()`

Plusieurs recherches dans les galeries photos FFBB, en un seul appel multi-search (un résultat par nom).

```php
public function searchMultipleGaleries(?array $names = null, ?array $filter = null, ?array $sort = null, ?int $limit = 10): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$names` | `list<string\|null>\|null` | `null` | Textes recherchés, un résultat par texte. |
| `$filter` | `list<string>\|null` | `null` | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$limit` | `?int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `list<SearchResult<ContentHit>>|null`

Équivalent Python : `search_multiple_galeries`

### `searchOrganismesByGeo()`

Clubs dans un rayon autour d'un point GPS, triés par distance.

```php
public function searchOrganismesByGeo(float $lat, float $lng, float $radiusKm = 10.0, string $q = '', ?int $limit = 20, GeoSortOrder $geoSort = GeoSortOrder::NearestFirst): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$lat` | `float` | — | Latitude du point de référence. |
| `$lng` | `float` | — | Longitude du point de référence. |
| `$radiusKm` | `float` | `10.0` | Rayon de recherche en kilomètres. |
| `$q` | `string` | `''` | Texte recherché en plus du filtre (chaîne vide : tous). |
| `$limit` | `?int` | `20` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$geoSort` | `GeoSortOrder` | `GeoSortOrder::NearestFirst` | Ordre de tri par distance. |

**Retour :** `SearchResult<OrganismesHit>|null`

Équivalent Python : `search_organismes_by_geo`

### `searchOrganismesByCity()`

Clubs d'une commune (correspondance exacte sur le nom de la commune, insensible à la casse).

Filtre sur `commune.libelle` : le Python filtre sur `commune`, qui n'est pas filtrable
sur l'index ffbbserver_organismes (HTTP 400 en direct).

```php
public function searchOrganismesByCity(string $cityName, string $q = '', int $limit = 200): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$cityName` | `string` | — | Nom exact de la commune. |
| `$q` | `string` | `''` | Texte recherché en plus du filtre (chaîne vide : tous). |
| `$limit` | `int` | `200` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `SearchResult<OrganismesHit>|null`

Équivalent Python : `search_organismes_by_city`

### `searchSallesByGeo()`

Salles dans un rayon autour d'un point GPS.

```php
public function searchSallesByGeo(float $lat, float $lng, float $radiusKm = 10.0, string $q = '', ?int $limit = 20, GeoSortOrder $geoSort = GeoSortOrder::NearestFirst): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$lat` | `float` | — | Latitude du point de référence. |
| `$lng` | `float` | — | Longitude du point de référence. |
| `$radiusKm` | `float` | `10.0` | Rayon de recherche en kilomètres. |
| `$q` | `string` | `''` | Texte recherché en plus du filtre (chaîne vide : tous). |
| `$limit` | `?int` | `20` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$geoSort` | `GeoSortOrder` | `GeoSortOrder::NearestFirst` | Ordre de tri par distance. |

**Retour :** `SearchResult<SallesHit>|null`

Équivalent Python : `search_salles_by_geo`

### `searchEngagementsByGeo()`

Équipes engagées dans un rayon autour d'un point GPS.

```php
public function searchEngagementsByGeo(float $lat, float $lng, float $radiusKm = 10.0, string $q = '', ?int $limit = 20, GeoSortOrder $geoSort = GeoSortOrder::NearestFirst): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$lat` | `float` | — | Latitude du point de référence. |
| `$lng` | `float` | — | Longitude du point de référence. |
| `$radiusKm` | `float` | `10.0` | Rayon de recherche en kilomètres. |
| `$q` | `string` | `''` | Texte recherché en plus du filtre (chaîne vide : tous). |
| `$limit` | `?int` | `20` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$geoSort` | `GeoSortOrder` | `GeoSortOrder::NearestFirst` | Ordre de tri par distance. |

**Retour :** `SearchResult<EngagementsHit>|null`

Équivalent Python : `search_engagements_by_geo`

### `searchEngagementsFiltered()`

Équipes engagées autour d'un point, filtrées par sexe et niveau.

Les deux filtres sont appliqués côté serveur. Le sexe porte sur `idCompetition.sexe` (le Python
filtre sur `sexe`, non filtrable : HTTP 400 en direct) ; les codes courts sont traduits vers les
valeurs stockées (M → Masculin, F → Féminin, MI → Mixte), toute autre valeur est transmise telle quelle.
Les codes de niveau sont les codes exacts de `niveau.code` (ex. PRM, SED2F, U13R1M) : il n'existe
pas de code générique « départemental » ou « régional ».

```php
public function searchEngagementsFiltered(float $lat, float $lng, float $radiusKm = 10.0, string $q = '', ?int $limit = 5000, ?array $sexes = null, ?array $niveauCodes = null): ?SearchResult
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$lat` | `float` | — | Latitude du point de référence. |
| `$lng` | `float` | — | Longitude du point de référence. |
| `$radiusKm` | `float` | `10.0` | Rayon de recherche en kilomètres. |
| `$q` | `string` | `''` | Texte recherché en plus du filtre (chaîne vide : tous). |
| `$limit` | `?int` | `5000` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$sexes` | `list<string>\|null` | `null` | ex. ['F', 'MI'] ou ['Féminin'] |
| `$niveauCodes` | `list<string>\|null` | `null` | ex. ['PRF', 'SED2F'] |

**Retour :** `SearchResult<EngagementsHit>|null`

Équivalent Python : `search_engagements_filtered`
