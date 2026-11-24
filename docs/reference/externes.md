<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Intégrations externes

Collections Directus des partenaires de la FFBB : Genius Sports (stats live), Rematch (vidéos), équipes de France (EDF).

Guide avec exemples : [04-rencontres-et-listes](../guides/04-rencontres-et-listes.md)

| Méthode | Retour | Description |
|---|---|---|
| [`getGeniusSportMatch()`](#getgeniussportmatch) | `array<string, mixed>\|null` | Un match Genius Sports (statistiques live). |
| [`getRematchVideo()`](#getrematchvideo) | `array<string, mixed>\|null` | Une vidéo Rematch. |
| [`getEdfMatch()`](#getedfmatch) | `array<string, mixed>\|null` | Un match d'une équipe de France. |
| [`getEdfPlayer()`](#getedfplayer) | `array<string, mixed>\|null` | Un joueur ou une joueuse des équipes de France. |
| [`listGeniusSportMatches()`](#listgeniussportmatches) | `list<array<string, mixed>>` | Matchs Genius Sports (statistiques live). |
| [`listGeniusSportsLiveLogs()`](#listgeniussportslivelogs) | `list<array<string, mixed>>` | Journal des événements live Genius Sports. |
| [`listRematchVideos()`](#listrematchvideos) | `list<array<string, mixed>>` | Vidéos Rematch. |
| [`listEdfMatches()`](#listedfmatches) | `list<array<string, mixed>>` | Matchs des équipes de France. |
| [`listEdfPlayers()`](#listedfplayers) | `list<array<string, mixed>>` | Joueurs et joueuses des équipes de France. |
| [`listEdfTeams()`](#listedfteams) | `list<array<string, mixed>>` | Équipes de France. |
| [`listEdfRosters()`](#listedfrosters) | `list<array<string, mixed>>` | Effectifs des équipes de France. |

### `getGeniusSportMatch()`

Un match Genius Sports (statistiques live).

```php
public function getGeniusSportMatch(string|int $id, ?array $fields = null): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `string\|int` | — | Identifiant Directus de l'élément. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_genius_sport_match`

### `getRematchVideo()`

Une vidéo Rematch.

```php
public function getRematchVideo(string|int $id, ?array $fields = null): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `string\|int` | — | Identifiant Directus de l'élément. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_rematch_video`

### `getEdfMatch()`

Un match d'une équipe de France.

```php
public function getEdfMatch(string|int $id, ?array $fields = null): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `string\|int` | — | Identifiant Directus de l'élément. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_edf_match`

### `getEdfPlayer()`

Un joueur ou une joueuse des équipes de France.

```php
public function getEdfPlayer(string|int $id, ?array $fields = null): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `string\|int` | — | Identifiant Directus de l'élément. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `array<string, mixed>|null`

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

**Retour :** `list<array<string, mixed>>`

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

**Retour :** `list<array<string, mixed>>`

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

**Retour :** `list<array<string, mixed>>`

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

**Retour :** `list<array<string, mixed>>`

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

**Retour :** `list<array<string, mixed>>`

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

**Retour :** `list<array<string, mixed>>`

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

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_edf_rosters`
