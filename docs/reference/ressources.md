<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Ressources unitaires

Lecture d'un élément par identifiant (rencontre, engagement, salle…), lives, configuration, spec OpenAPI.

Guide avec exemples : [04-rencontres-et-listes](../guides/04-rencontres-et-listes.md)

| Méthode | Retour | Description |
|---|---|---|
| [`getConfiguration()`](#getconfiguration) | `array<string, mixed>\|null` | Configuration publique de l'app (jetons key_dh / key_ms, versions iOS / Android). |
| [`getLives()`](#getlives) | `list<array<string, mixed>>\|null` | Matchs suivis en direct. |
| [`getOpenapiSpec()`](#getopenapispec) | `array<string, mixed>\|null` | Spécification OpenAPI exposée par Directus (null en cas d'erreur). |
| [`getRencontre()`](#getrencontre) | `array<string, mixed>\|null` | Détail d'une rencontre (match) : équipes, date, score, salle, officiels (null si introuvable). |
| [`getEngagement()`](#getengagement) | `array<string, mixed>\|null` | Détail d'un engagement : une équipe d'un club dans une compétition / poule (null si introuvable). |
| [`getFormation()`](#getformation) | `array<string, mixed>\|null` | Détail d'une formation (null si introuvable). |
| [`getEntraineur()`](#getentraineur) | `array<string, mixed>\|null` | Détail d'un entraîneur (par numéro de licence) (null si introuvable). |
| [`getCommune()`](#getcommune) | `array<string, mixed>\|null` | Détail d'une commune (null si introuvable). |
| [`getOfficiel()`](#getofficiel) | `array<string, mixed>\|null` | Détail d'un officiel (arbitre, OTM) (null si introuvable). |
| [`getSalle()`](#getsalle) | `array<string, mixed>\|null` | Détail d'une salle : nom, adresse, commune, coordonnées (null si introuvable). |
| [`getTerrain()`](#getterrain) | `array<string, mixed>\|null` | Détail d'un terrain (3x3 / extérieur) (null si introuvable). |
| [`getTournoi()`](#gettournoi) | `array<string, mixed>\|null` | Détail d'un tournoi (null si introuvable). |
| [`getPratique()`](#getpratique) | `array<string, mixed>\|null` | Détail d'une offre de pratique (null si introuvable). |
| [`getSession()`](#getsession) | `array<string, mixed>\|null` | Une session de formation (null si introuvable). |
| [`listSessions()`](#listsessions) | `list<array<string, mixed>>` | Sessions de formation. |

### `getConfiguration()`

Configuration publique de l'app (jetons key_dh / key_ms, versions iOS / Android).

```php
public function getConfiguration(): ?array
```

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_configuration`

### `getLives()`

Matchs suivis en direct.

```php
public function getLives(): ?array
```

**Retour :** `list<array<string, mixed>>|null`

Équivalent Python : `get_lives`

### `getOpenapiSpec()`

Spécification OpenAPI exposée par Directus (null en cas d'erreur).

```php
public function getOpenapiSpec(): ?array
```

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_openapi_spec`

### `getRencontre()`

Détail d'une rencontre (match) : équipes, date, score, salle, officiels (null si introuvable).

```php
public function getRencontre(int|string $id): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_rencontre`

### `getEngagement()`

Détail d'un engagement : une équipe d'un club dans une compétition / poule (null si introuvable).

```php
public function getEngagement(int|string $id): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_engagement`

### `getFormation()`

Détail d'une formation (null si introuvable).

```php
public function getFormation(int|string $id): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_formation`

### `getEntraineur()`

Détail d'un entraîneur (par numéro de licence) (null si introuvable).

```php
public function getEntraineur(int|string $id): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_entraineur`

### `getCommune()`

Détail d'une commune (null si introuvable).

```php
public function getCommune(int|string $id): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_commune`

### `getOfficiel()`

Détail d'un officiel (arbitre, OTM) (null si introuvable).

```php
public function getOfficiel(int|string $id): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_officiel`

### `getSalle()`

Détail d'une salle : nom, adresse, commune, coordonnées (null si introuvable).

```php
public function getSalle(int|string $id): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_salle`

### `getTerrain()`

Détail d'un terrain (3x3 / extérieur) (null si introuvable).

```php
public function getTerrain(int|string $id): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_terrain`

### `getTournoi()`

Détail d'un tournoi (null si introuvable).

```php
public function getTournoi(int|string $id): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_tournoi`

### `getPratique()`

Détail d'une offre de pratique (null si introuvable).

```php
public function getPratique(int|string $id): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_pratique`

### `getSession()`

Une session de formation (null si introuvable).

```php
public function getSession(int|string $id, ?array $fields = null): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_session`

### `listSessions()`

Sessions de formation.

```php
public function listSessions(int $limit = 10, ?array $fields = null, ?string $filterCriteria = null, array|string|null $sort = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |
| `$filterCriteria` | `?string` | `null` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |
| `$sort` | `string\|list<string>\|null` | `null` | Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`). |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_sessions`
