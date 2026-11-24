<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Listes et pagination

Pour chaque ressource : `list{X}()` (une page), `listAll{X}()` (toutes les pages, en mémoire) et `iterAll{X}()` (générateur paresseux).
Les filtres sont des filtres Directus en JSON, ex. `{"idPoule":{"_eq":900}}`.

Guide avec exemples : [04-rencontres-et-listes](../guides/04-rencontres-et-listes.md)

| Méthode | Retour | Description |
|---|---|---|
| [`listRencontres()`](#listrencontres) | `list<array<string, mixed>>` | Une page de rencontres (matchs). |
| [`listAllRencontres()`](#listallrencontres) | `list<array<string, mixed>>` | Toutes les rencontres (matchs) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`iterAllRencontres()`](#iterallrencontres) | `Generator<int, array<string, mixed>>` | Parcourt les rencontres (matchs) page par page, sans tout charger en mémoire. |
| [`listSalles()`](#listsalles) | `list<array<string, mixed>>` | Une page de salles (gymnases). |
| [`listAllSalles()`](#listallsalles) | `list<array<string, mixed>>` | Toutes les salles (gymnases) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`iterAllSalles()`](#iterallsalles) | `Generator<int, array<string, mixed>>` | Parcourt les salles (gymnases) page par page, sans tout charger en mémoire. |
| [`listTerrains()`](#listterrains) | `list<array<string, mixed>>` | Une page de terrains 3x3 / extérieurs. |
| [`listAllTerrains()`](#listallterrains) | `list<array<string, mixed>>` | Toutes les terrains 3x3 / extérieurs correspondant au filtre, toutes pages confondues (20 pages max). |
| [`iterAllTerrains()`](#iterallterrains) | `Generator<int, array<string, mixed>>` | Parcourt les terrains 3x3 / extérieurs page par page, sans tout charger en mémoire. |
| [`listTournois()`](#listtournois) | `list<array<string, mixed>>` | Une page de tournois (dont 3x3). |
| [`listAllTournois()`](#listalltournois) | `list<array<string, mixed>>` | Toutes les tournois (dont 3x3) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`iterAllTournois()`](#iteralltournois) | `Generator<int, array<string, mixed>>` | Parcourt les tournois (dont 3x3) page par page, sans tout charger en mémoire. |
| [`listEngagements()`](#listengagements) | `list<array<string, mixed>>` | Une page de équipes engagées (une équipe d'un club dans une compétition). |
| [`listAllEngagements()`](#listallengagements) | `list<array<string, mixed>>` | Toutes les équipes engagées (une équipe d'un club dans une compétition) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`iterAllEngagements()`](#iterallengagements) | `Generator<int, array<string, mixed>>` | Parcourt les équipes engagées (une équipe d'un club dans une compétition) page par page, sans tout charger en mémoire. |
| [`listFormations()`](#listformations) | `list<array<string, mixed>>` | Une page de formations (entraîneurs, arbitres, dirigeants). |
| [`listAllFormations()`](#listallformations) | `list<array<string, mixed>>` | Toutes les formations (entraîneurs, arbitres, dirigeants) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`iterAllFormations()`](#iterallformations) | `Generator<int, array<string, mixed>>` | Parcourt les formations (entraîneurs, arbitres, dirigeants) page par page, sans tout charger en mémoire. |
| [`listEntraineurs()`](#listentraineurs) | `list<array<string, mixed>>` | Une page de entraîneurs. |
| [`listAllEntraineurs()`](#listallentraineurs) | `list<array<string, mixed>>` | Toutes les entraîneurs correspondant au filtre, toutes pages confondues (20 pages max). |
| [`iterAllEntraineurs()`](#iterallentraineurs) | `Generator<int, array<string, mixed>>` | Parcourt les entraîneurs page par page, sans tout charger en mémoire. |
| [`listCommunes()`](#listcommunes) | `list<array<string, mixed>>` | Une page de communes. |
| [`listAllCommunes()`](#listallcommunes) | `list<array<string, mixed>>` | Toutes les communes correspondant au filtre, toutes pages confondues (20 pages max). |
| [`iterAllCommunes()`](#iterallcommunes) | `Generator<int, array<string, mixed>>` | Parcourt les communes page par page, sans tout charger en mémoire. |
| [`listOfficiels()`](#listofficiels) | `list<array<string, mixed>>` | Une page de officiels (arbitres, OTM). |
| [`listAllOfficiels()`](#listallofficiels) | `list<array<string, mixed>>` | Toutes les officiels (arbitres, OTM) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`iterAllOfficiels()`](#iterallofficiels) | `Generator<int, array<string, mixed>>` | Parcourt les officiels (arbitres, OTM) page par page, sans tout charger en mémoire. |
| [`listPratiques()`](#listpratiques) | `list<array<string, mixed>>` | Une page de offres de pratique (basket santé, 3x3, micro-basket…). |
| [`listAllPratiques()`](#listallpratiques) | `list<array<string, mixed>>` | Toutes les offres de pratique (basket santé, 3x3, micro-basket…) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`iterAllPratiques()`](#iterallpratiques) | `Generator<int, array<string, mixed>>` | Parcourt les offres de pratique (basket santé, 3x3, micro-basket…) page par page, sans tout charger en mémoire. |
| [`listEngagementsByIds()`](#listengagementsbyids) | `list<array<string, mixed>>` | Engagements par identifiants (lots de 50 par requête). |
| [`listEngagementsByPoule()`](#listengagementsbypoule) | `list<array<string, mixed>>` | Équipes engagées dans une poule. |
| [`listEngagementsByPoules()`](#listengagementsbypoules) | `list<array<string, mixed>>` | Équipes engagées dans plusieurs poules (lots de 50 poules par requête). |
| [`listRencontresByPoule()`](#listrencontresbypoule) | `list<array<string, mixed>>` | Toutes les rencontres d'une poule (500 max). |
| [`listRencontresByPoules()`](#listrencontresbypoules) | `list<array<string, mixed>>` | Rencontres de plusieurs poules (lots de 50 poules par requête). |
| [`listEntraineursByIds()`](#listentraineursbyids) | `list<array<string, mixed>>` | Entraîneurs par numéro de licence. |

### `listRencontres()`

Une page de rencontres (matchs).

```php
public function listRencontres(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$offset` | `?int` | `null` | Nombre d'éléments à sauter. |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_rencontres`

### `listAllRencontres()`

Toutes les rencontres (matchs) correspondant au filtre, toutes pages confondues (20 pages max).

```php
public function listAllRencontres(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_all_rencontres`

### `iterAllRencontres()`

Parcourt les rencontres (matchs) page par page, sans tout charger en mémoire.

```php
public function iterAllRencontres(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `Generator<int, array<string, mixed>>`

Équivalent Python : `aiter_all_rencontres`

### `listSalles()`

Une page de salles (gymnases).

```php
public function listSalles(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$offset` | `?int` | `null` | Nombre d'éléments à sauter. |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_salles`

### `listAllSalles()`

Toutes les salles (gymnases) correspondant au filtre, toutes pages confondues (20 pages max).

```php
public function listAllSalles(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_all_salles`

### `iterAllSalles()`

Parcourt les salles (gymnases) page par page, sans tout charger en mémoire.

```php
public function iterAllSalles(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `Generator<int, array<string, mixed>>`

Équivalent Python : `aiter_all_salles`

### `listTerrains()`

Une page de terrains 3x3 / extérieurs.

```php
public function listTerrains(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$offset` | `?int` | `null` | Nombre d'éléments à sauter. |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_terrains`

### `listAllTerrains()`

Toutes les terrains 3x3 / extérieurs correspondant au filtre, toutes pages confondues (20 pages max).

```php
public function listAllTerrains(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_all_terrains`

### `iterAllTerrains()`

Parcourt les terrains 3x3 / extérieurs page par page, sans tout charger en mémoire.

```php
public function iterAllTerrains(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `Generator<int, array<string, mixed>>`

Équivalent Python : `aiter_all_terrains`

### `listTournois()`

Une page de tournois (dont 3x3).

```php
public function listTournois(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$offset` | `?int` | `null` | Nombre d'éléments à sauter. |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_tournois`

### `listAllTournois()`

Toutes les tournois (dont 3x3) correspondant au filtre, toutes pages confondues (20 pages max).

```php
public function listAllTournois(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_all_tournois`

### `iterAllTournois()`

Parcourt les tournois (dont 3x3) page par page, sans tout charger en mémoire.

```php
public function iterAllTournois(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `Generator<int, array<string, mixed>>`

Équivalent Python : `aiter_all_tournois`

### `listEngagements()`

Une page de équipes engagées (une équipe d'un club dans une compétition).

```php
public function listEngagements(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$offset` | `?int` | `null` | Nombre d'éléments à sauter. |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_engagements`

### `listAllEngagements()`

Toutes les équipes engagées (une équipe d'un club dans une compétition) correspondant au filtre, toutes pages confondues (20 pages max).

```php
public function listAllEngagements(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_all_engagements`

### `iterAllEngagements()`

Parcourt les équipes engagées (une équipe d'un club dans une compétition) page par page, sans tout charger en mémoire.

```php
public function iterAllEngagements(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `Generator<int, array<string, mixed>>`

Équivalent Python : `aiter_all_engagements`

### `listFormations()`

Une page de formations (entraîneurs, arbitres, dirigeants).

```php
public function listFormations(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$offset` | `?int` | `null` | Nombre d'éléments à sauter. |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_formations`

### `listAllFormations()`

Toutes les formations (entraîneurs, arbitres, dirigeants) correspondant au filtre, toutes pages confondues (20 pages max).

```php
public function listAllFormations(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_all_formations`

### `iterAllFormations()`

Parcourt les formations (entraîneurs, arbitres, dirigeants) page par page, sans tout charger en mémoire.

```php
public function iterAllFormations(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `Generator<int, array<string, mixed>>`

Équivalent Python : `aiter_all_formations`

### `listEntraineurs()`

Une page de entraîneurs.

```php
public function listEntraineurs(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$offset` | `?int` | `null` | Nombre d'éléments à sauter. |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_entraineurs`

### `listAllEntraineurs()`

Toutes les entraîneurs correspondant au filtre, toutes pages confondues (20 pages max).

```php
public function listAllEntraineurs(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_all_entraineurs`

### `iterAllEntraineurs()`

Parcourt les entraîneurs page par page, sans tout charger en mémoire.

```php
public function iterAllEntraineurs(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `Generator<int, array<string, mixed>>`

Équivalent Python : `aiter_all_entraineurs`

### `listCommunes()`

Une page de communes.

```php
public function listCommunes(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$offset` | `?int` | `null` | Nombre d'éléments à sauter. |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_communes`

### `listAllCommunes()`

Toutes les communes correspondant au filtre, toutes pages confondues (20 pages max).

```php
public function listAllCommunes(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_all_communes`

### `iterAllCommunes()`

Parcourt les communes page par page, sans tout charger en mémoire.

```php
public function iterAllCommunes(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `Generator<int, array<string, mixed>>`

Équivalent Python : `aiter_all_communes`

### `listOfficiels()`

Une page de officiels (arbitres, OTM).

```php
public function listOfficiels(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$offset` | `?int` | `null` | Nombre d'éléments à sauter. |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_officiels`

### `listAllOfficiels()`

Toutes les officiels (arbitres, OTM) correspondant au filtre, toutes pages confondues (20 pages max).

```php
public function listAllOfficiels(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_all_officiels`

### `iterAllOfficiels()`

Parcourt les officiels (arbitres, OTM) page par page, sans tout charger en mémoire.

```php
public function iterAllOfficiels(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `Generator<int, array<string, mixed>>`

Équivalent Python : `aiter_all_officiels`

### `listPratiques()`

Une page de offres de pratique (basket santé, 3x3, micro-basket…).

```php
public function listPratiques(int $limit = 10, ?string $filterCriteria = null, ?array $sort = null, ?int $offset = null, ?string $search = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$offset` | `?int` | `null` | Nombre d'éléments à sauter. |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_pratiques`

### `listAllPratiques()`

Toutes les offres de pratique (basket santé, 3x3, micro-basket…) correspondant au filtre, toutes pages confondues (20 pages max).

```php
public function listAllPratiques(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_all_pratiques`

### `iterAllPratiques()`

Parcourt les offres de pratique (basket santé, 3x3, micro-basket…) page par page, sans tout charger en mémoire.

```php
public function iterAllPratiques(?string $filterCriteria = null, ?array $sort = null, ?string $search = null, int $pageSize = 100, int $maxItems = 10000): Generator
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |
| `$search` | `?string` | `null` | Recherche plein texte Directus. |
| `$pageSize` | `int` | `100` | Taille de chaque page demandée à Directus. |
| `$maxItems` | `int` | `10000` | Nombre maximum d'éléments renvoyés au total. |

**Retour :** `Generator<int, array<string, mixed>>`

Équivalent Python : `aiter_all_pratiques`

### `listEngagementsByIds()`

Engagements par identifiants (lots de 50 par requête).

```php
public function listEngagementsByIds(array $ids): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$ids` | `list<int>` | — | Identifiants (découpés en lots de 50). |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_engagements_by_ids`

### `listEngagementsByPoule()`

Équipes engagées dans une poule.

```php
public function listEngagementsByPoule(int $pouleId): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$pouleId` | `int` | — | Identifiant de la poule. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_engagements_by_poule`

### `listEngagementsByPoules()`

Équipes engagées dans plusieurs poules (lots de 50 poules par requête).

```php
public function listEngagementsByPoules(array $pouleIds): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$pouleIds` | `list<int>` | — | Identifiants de poules. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_engagements_by_poules`

### `listRencontresByPoule()`

Toutes les rencontres d'une poule (500 max).

```php
public function listRencontresByPoule(int $pouleId): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$pouleId` | `int` | — | Identifiant de la poule. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_rencontres_by_poule`

### `listRencontresByPoules()`

Rencontres de plusieurs poules (lots de 50 poules par requête).

```php
public function listRencontresByPoules(array $pouleIds): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$pouleIds` | `list<int>` | — | Identifiants de poules. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_rencontres_by_poules`

### `listEntraineursByIds()`

Entraîneurs par numéro de licence.

```php
public function listEntraineursByIds(array $ids): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$ids` | `list<int\|string>` | — | Identifiants (découpés en lots de 50). |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_entraineurs_by_ids`
