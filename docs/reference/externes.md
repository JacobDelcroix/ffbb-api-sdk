<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Intégrations externes

Collections Directus des partenaires de la FFBB : Genius Sports (stats live), Rematch (vidéos), équipes de France (EDF).

Guide avec exemples : [04-rencontres-et-listes](../guides/04-rencontres-et-listes.md)

| Méthode | Retour | Description |
|---|---|---|
| [`getGeniusSportMatch()`](#getgeniussportmatch) | `?GeniusSportMatchesItem` | Un match Genius Sports (statistiques live). |
| [`getRematchVideo()`](#getrematchvideo) | `?RematchVideosItem` | Une vidéo Rematch. |
| [`getEdfMatch()`](#getedfmatch) | `?EdfMatchesItem` | Un match d'une équipe de France. |
| [`getEdfPlayer()`](#getedfplayer) | `?EdfPlayersItem` | Un joueur ou une joueuse des équipes de France. |
| [`listGeniusSportMatches()`](#listgeniussportmatches) | `list<GeniusSportMatchesItem>` | Matchs Genius Sports (statistiques live). |
| [`listGeniusSportsLiveLogs()`](#listgeniussportslivelogs) | `list<GeniusSportsLiveLogsItem>` | Journal des événements live Genius Sports. |
| [`listRematchVideos()`](#listrematchvideos) | `list<RematchVideosItem>` | Vidéos Rematch. |
| [`listEdfMatches()`](#listedfmatches) | `list<EdfMatchesItem>` | Matchs des équipes de France. |
| [`listEdfPlayers()`](#listedfplayers) | `list<EdfPlayersItem>` | Joueurs et joueuses des équipes de France. |
| [`listEdfTeams()`](#listedfteams) | `list<EdfTeamsItem>` | Équipes de France. |
| [`listEdfRosters()`](#listedfrosters) | `list<EdfRostersItem>` | Effectifs des équipes de France. |

### `getGeniusSportMatch()`

Un match Genius Sports (statistiques live).

```php
public function getGeniusSportMatch(int|string $id, ?array $fields = null): ?GeniusSportMatchesItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `?GeniusSportMatchesItem`

Équivalent Python : `get_genius_sport_match`

### `getRematchVideo()`

Une vidéo Rematch.

```php
public function getRematchVideo(int|string $id, ?array $fields = null): ?RematchVideosItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `?RematchVideosItem`

Équivalent Python : `get_rematch_video`

### `getEdfMatch()`

Un match d'une équipe de France.

```php
public function getEdfMatch(int|string $id, ?array $fields = null): ?EdfMatchesItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `?EdfMatchesItem`

Équivalent Python : `get_edf_match`

### `getEdfPlayer()`

Un joueur ou une joueuse des équipes de France.

```php
public function getEdfPlayer(int|string $id, ?array $fields = null): ?EdfPlayersItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `?EdfPlayersItem`

Équivalent Python : `get_edf_player`

### `listGeniusSportMatches()`

Matchs Genius Sports (statistiques live).

```php
public function listGeniusSportMatches(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, array|string|null $sort = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `string\|list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |

**Retour :** `list<GeniusSportMatchesItem>`

Équivalent Python : `list_genius_sport_matches`

### `listGeniusSportsLiveLogs()`

Journal des événements live Genius Sports.

```php
public function listGeniusSportsLiveLogs(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, array|string|null $sort = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `string\|list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |

**Retour :** `list<GeniusSportsLiveLogsItem>`

Équivalent Python : `list_genius_sports_live_logs`

### `listRematchVideos()`

Vidéos Rematch.

```php
public function listRematchVideos(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, array|string|null $sort = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `string\|list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |

**Retour :** `list<RematchVideosItem>`

Équivalent Python : `list_rematch_videos`

### `listEdfMatches()`

Matchs des équipes de France.

```php
public function listEdfMatches(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, array|string|null $sort = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `string\|list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |

**Retour :** `list<EdfMatchesItem>`

Équivalent Python : `list_edf_matches`

### `listEdfPlayers()`

Joueurs et joueuses des équipes de France.

```php
public function listEdfPlayers(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, array|string|null $sort = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `string\|list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |

**Retour :** `list<EdfPlayersItem>`

Équivalent Python : `list_edf_players`

### `listEdfTeams()`

Équipes de France.

```php
public function listEdfTeams(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, array|string|null $sort = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `string\|list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |

**Retour :** `list<EdfTeamsItem>`

Équivalent Python : `list_edf_teams`

### `listEdfRosters()`

Effectifs des équipes de France.

```php
public function listEdfRosters(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, array|string|null $sort = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `string\|list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |

**Retour :** `list<EdfRostersItem>`

Équivalent Python : `list_edf_rosters`
