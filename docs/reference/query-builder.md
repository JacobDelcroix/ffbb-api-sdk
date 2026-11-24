<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Query builder Directus

Query builder Directus complet, pour aller au-delà des méthodes reprises du SDK Python.

Couvre tous les paramètres de l'API Items de Directus :
fields, filter, search, sort, limit, offset, page, aggregate, groupBy, deep, alias, meta.

    $ffbb->directus('ffbbserver_rencontres')
        ->fields(['id', 'date_rencontre', 'nomEquipe1', 'nomEquipe2', 'resultatEquipe1', 'resultatEquipe2'])
        ->where('idPoule', '_eq', 200000002901234)
        ->where('joue', '_eq', 1)
        ->sort('-date_rencontre')
        ->limit(50)
        ->get();

Obtenu via `$ffbb->directus('nom_de_collection')`. Les méthodes de construction renvoient le builder (chaînables) ; `get()`, `first()`, `find()`, `count()`, `cursor()`, `raw()`, `getData()` et `findData()` exécutent la requête.

Guide avec exemples : [06-query-builder-directus](../guides/06-query-builder-directus.md)

| Méthode | Retour | Description |
|---|---|---|
| [`fields()`](#fields) | `self` | Champs à renvoyer, notation pointée pour les relations ("idPoule.nom", "engagements.*", "*"). |
| [`filter()`](#filter) | `self` | Filtre Directus complet, en tableau ou en JSON ({"idPoule": {"_eq": 123}}). |
| [`where()`](#where) | `self` | Ajoute une condition (combinée en _and avec les précédentes). |
| [`search()`](#search) | `self` | Recherche plein texte Directus sur tous les champs texte de la collection. |
| [`sort()`](#sort) | `self` | Tri ; préfixer par "-" pour un tri décroissant ("-date_rencontre"). |
| [`limit()`](#limit) | `self` | -1 = tous les éléments (si l'instance Directus l'autorise). |
| [`offset()`](#offset) | `self` | Nombre d'éléments à sauter. |
| [`page()`](#page) | `self` | Numéro de page (à combiner avec limit(), alternative à offset()). |
| [`aggregate()`](#aggregate) | `self` | Agrégat Directus : count, countDistinct, countAll, sum, sumDistinct, avg, avgDistinct, min, max. |
| [`groupBy()`](#groupby) | `self` | Regroupe les résultats (avec aggregate()), ex. |
| [`deep()`](#deep) | `self` | Paramètres appliqués à une relation imbriquée, ex. |
| [`alias()`](#alias) | `self` | Renomme un champ dans la réponse, ex. |
| [`withMeta()`](#withmeta) | `self` | Métadonnées : "total_count", "filter_count" ou "*". |
| [`toQuery()`](#toquery) | `array<string, string>` | Paramètres de requête tels qu'envoyés à Directus. |
| [`get()`](#get) | `list<array<string, mixed>>` | Les éléments correspondant à la requête. |
| [`getData()`](#getdata) | `list<object>` | Les éléments hydratés dans le DTO de la collection (src/Data, généré depuis la spec OpenAPI). |
| [`findData()`](#finddata) | `?object` | Un élément par identifiant, hydraté dans son DTO. |
| [`raw()`](#raw) | `array<string, mixed>` | Réponse brute Directus : ['data' => [...], 'meta' => [...]]. |
| [`first()`](#first) | `array<string, mixed>\|null` | Le premier élément correspondant à la requête (limit 1). |
| [`find()`](#find) | `array<string, mixed>\|null` | Un élément par identifiant (seuls fields, deep et alias s'appliquent). |
| [`count()`](#count) | `int` | Nombre d'éléments correspondant au filtre (aggregate[count]=*). |
| [`cursor()`](#cursor) | `Generator<int, array<string, mixed>>` | Itère sur tous les résultats, page par page. |

### `fields()`

Champs à renvoyer, notation pointée pour les relations ("idPoule.nom", "engagements.*", "*").

```php
public function fields(array|string $fields): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$fields` | `string\|list<string>` | — | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `self`

### `filter()`

Filtre Directus complet, en tableau ou en JSON ({"idPoule": {"_eq": 123}}).

```php
public function filter(array|string $filter): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filter` | `array<string, mixed>\|string` | — | Filtres Meilisearch, ex. `['sexe = "F"']` (combinés en ET). |

**Retour :** `self`

### `where()`

Ajoute une condition (combinée en _and avec les précédentes).

Opérateurs : _eq, _neq, _lt, _lte, _gt, _gte, _in, _nin, _null, _nnull,
_contains, _icontains, _starts_with, _ends_with, _between, _empty, _nempty…
Le champ peut être pointé : "idCompetition.categorie.code".

```php
public function where(string $field, string $operator, mixed $value = true): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$field` | `string` | — | Champ, notation pointée pour les relations (`idCompetition.categorie.code`). |
| `$operator` | `string` | — | Opérateur Directus : `_eq`, `_neq`, `_in`, `_nin`, `_lt`, `_gte`, `_contains`, `_icontains`, `_starts_with`, `_between`, `_null`… |
| `$value` | `mixed` | `true` | Valeur comparée (tableau pour `_in`, `_nin`, `_between`). |

**Retour :** `self`

### `search()`

Recherche plein texte Directus sur tous les champs texte de la collection.

```php
public function search(string $search): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$search` | `string` | — | Recherche plein texte Directus. |

**Retour :** `self`

### `sort()`

Tri ; préfixer par "-" pour un tri décroissant ("-date_rencontre").

```php
public function sort(array|string $fields): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$fields` | `string\|list<string>` | — | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `self`

### `limit()`

-1 = tous les éléments (si l'instance Directus l'autorise).

```php
public function limit(int $limit): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | — | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |

**Retour :** `self`

### `offset()`

Nombre d'éléments à sauter.

```php
public function offset(int $offset): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$offset` | `int` | — | Nombre d'éléments à sauter. |

**Retour :** `self`

### `page()`

Numéro de page (à combiner avec limit(), alternative à offset()).

```php
public function page(int $page): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$page` | `int` | — | Numéro de page (commence à 1). |

**Retour :** `self`

### `aggregate()`

Agrégat Directus : count, countDistinct, countAll, sum, sumDistinct, avg, avgDistinct, min, max.

```php
public function aggregate(string $function, array|string $fields = '*'): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$function` | `string` | — | Fonction d'agrégat : `count`, `countDistinct`, `sum`, `avg`, `min`, `max`… |
| `$fields` | `string\|list<string>` | `'*'` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `self`

### `groupBy()`

Regroupe les résultats (avec aggregate()), ex. groupBy('idPoule').

```php
public function groupBy(array|string $fields): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$fields` | `string\|list<string>` | — | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `self`

### `deep()`

Paramètres appliqués à une relation imbriquée, ex. deep('rencontres', ['_limit' => 1000, '_sort' => ['-date_rencontre']]).

```php
public function deep(string $relation, array $query): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$relation` | `string` | — | Relation imbriquée, notation pointée (`idPoule.classements`). |
| `$query` | `array<string, mixed>` | — | Paramètres Directus appliqués à la relation : `_limit`, `_sort`, `_filter`… |

**Retour :** `self`

### `alias()`

Renomme un champ dans la réponse, ex. alias('equipe', 'nomEquipe1').

```php
public function alias(string $alias, string $field): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$alias` | `string` | — | Nom du champ dans la réponse. |
| `$field` | `string` | — | Champ, notation pointée pour les relations (`idCompetition.categorie.code`). |

**Retour :** `self`

### `withMeta()`

Métadonnées : "total_count", "filter_count" ou "*".

```php
public function withMeta(string $meta = '*'): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$meta` | `string` | `'*'` | Métadonnées : `total_count`, `filter_count` ou `*`. |

**Retour :** `self`

### `toQuery()`

Paramètres de requête tels qu'envoyés à Directus.

```php
public function toQuery(): array
```

**Retour :** `array<string, string>`

### `get()`

Les éléments correspondant à la requête.

```php
public function get(): array
```

**Retour :** `list<array<string, mixed>>`

### `getData()`

Les éléments hydratés dans le DTO de la collection (src/Data, généré depuis la spec OpenAPI).

```php
public function getData(): array
```

**Retour :** `list<object>`

### `findData()`

Un élément par identifiant, hydraté dans son DTO.

```php
public function findData(int|string $id): ?object
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `?object`

### `raw()`

Réponse brute Directus : ['data' => [...], 'meta' => [...]].

```php
public function raw(): array
```

**Retour :** `array<string, mixed>`

### `first()`

Le premier élément correspondant à la requête (limit 1).

```php
public function first(): ?array
```

**Retour :** `array<string, mixed>|null`

### `find()`

Un élément par identifiant (seuls fields, deep et alias s'appliquent).

```php
public function find(int|string $id): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `array<string, mixed>|null`

### `count()`

Nombre d'éléments correspondant au filtre (aggregate[count]=*).

```php
public function count(): int
```

**Retour :** `int`

### `cursor()`

Itère sur tous les résultats, page par page.

```php
public function cursor(int $pageSize = 100): Generator
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |

**Retour :** `Generator<int, array<string, mixed>>`
