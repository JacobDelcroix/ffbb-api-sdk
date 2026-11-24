<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Ressources unitaires

Lecture d'un élément par identifiant (rencontre, engagement, salle…), lives, configuration, spec OpenAPI.

Guide avec exemples : [04-rencontres-et-listes](../guides/04-rencontres-et-listes.md)

| Méthode | Retour | Description |
|---|---|---|
| [`getConfiguration()`](#getconfiguration) | `?ConfigurationItem` | Configuration publique de l'app : jetons key_dh / key_ms, versions iOS / Android (null en cas d'erreur). |
| [`getLives()`](#getlives) | `list<Live>\|null` | Matchs suivis en direct (jamais mis en cache). |
| [`getOpenapiSpec()`](#getopenapispec) | `array<string, mixed>\|null` | Spécification OpenAPI exposée par Directus, en tableau (null en cas d'erreur). |
| [`getRencontre()`](#getrencontre) | `?RencontresItem` | Détail d'une rencontre (match) : équipes, date, score, salle, officiels (null si introuvable). |
| [`getEngagement()`](#getengagement) | `?EngagementsItem` | Détail d'un engagement : une équipe d'un club dans une compétition / poule (null si introuvable). |
| [`getFormation()`](#getformation) | `?FormationsItem` | Détail d'une formation (null si introuvable). |
| [`getEntraineur()`](#getentraineur) | `?EntraineursItem` | Détail d'un entraîneur (par numéro de licence) (null si introuvable). |
| [`getCommune()`](#getcommune) | `?CommunesItem` | Détail d'une commune (null si introuvable). |
| [`getOfficiel()`](#getofficiel) | `?OfficielsItem` | Détail d'un officiel (arbitre, OTM) (null si introuvable). |
| [`getSalle()`](#getsalle) | `?SallesItem` | Détail d'une salle : nom, adresse, commune, coordonnées (null si introuvable). |
| [`getTerrain()`](#getterrain) | `?TerrainsItem` | Détail d'un terrain (3x3 / extérieur) (null si introuvable). |
| [`getTournoi()`](#gettournoi) | `?TournoisItem` | Détail d'un tournoi (null si introuvable). |
| [`getPratique()`](#getpratique) | `?PratiquesItem` | Détail d'une offre de pratique (null si introuvable). |
| [`getSession()`](#getsession) | `?SessionsItem` | Une session de formation (null si introuvable). |
| [`listSessions()`](#listsessions) | `list<SessionsItem>` | Sessions de formation. |

### `getConfiguration()`

Configuration publique de l'app : jetons key_dh / key_ms, versions iOS / Android (null en cas d'erreur).

```php
public function getConfiguration(): ?ConfigurationItem
```

**Retour :** `?ConfigurationItem`

Équivalent Python : `get_configuration`

### `getLives()`

Matchs suivis en direct (jamais mis en cache).

```php
public function getLives(): ?array
```

**Retour :** `list<Live>|null`

Équivalent Python : `get_lives`

### `getOpenapiSpec()`

Spécification OpenAPI exposée par Directus, en tableau (null en cas d'erreur).

C'est un document de description d'API, pas une donnée FFBB : il n'a pas de DTO.

```php
public function getOpenapiSpec(): ?array
```

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_openapi_spec`

### `getRencontre()`

Détail d'une rencontre (match) : équipes, date, score, salle, officiels (null si introuvable).

```php
public function getRencontre(int|string $id): ?RencontresItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `?RencontresItem`

Équivalent Python : `get_rencontre`

### `getEngagement()`

Détail d'un engagement : une équipe d'un club dans une compétition / poule (null si introuvable).

```php
public function getEngagement(int|string $id): ?EngagementsItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `?EngagementsItem`

Équivalent Python : `get_engagement`

### `getFormation()`

Détail d'une formation (null si introuvable).

```php
public function getFormation(int|string $id): ?FormationsItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `?FormationsItem`

Équivalent Python : `get_formation`

### `getEntraineur()`

Détail d'un entraîneur (par numéro de licence) (null si introuvable).

```php
public function getEntraineur(int|string $id): ?EntraineursItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `?EntraineursItem`

Équivalent Python : `get_entraineur`

### `getCommune()`

Détail d'une commune (null si introuvable).

```php
public function getCommune(int|string $id): ?CommunesItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `?CommunesItem`

Équivalent Python : `get_commune`

### `getOfficiel()`

Détail d'un officiel (arbitre, OTM) (null si introuvable).

```php
public function getOfficiel(int|string $id): ?OfficielsItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `?OfficielsItem`

Équivalent Python : `get_officiel`

### `getSalle()`

Détail d'une salle : nom, adresse, commune, coordonnées (null si introuvable).

```php
public function getSalle(int|string $id): ?SallesItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `?SallesItem`

Équivalent Python : `get_salle`

### `getTerrain()`

Détail d'un terrain (3x3 / extérieur) (null si introuvable).

```php
public function getTerrain(int|string $id): ?TerrainsItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `?TerrainsItem`

Équivalent Python : `get_terrain`

### `getTournoi()`

Détail d'un tournoi (null si introuvable).

```php
public function getTournoi(int|string $id): ?TournoisItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `?TournoisItem`

Équivalent Python : `get_tournoi`

### `getPratique()`

Détail d'une offre de pratique (null si introuvable).

```php
public function getPratique(int|string $id): ?PratiquesItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `?PratiquesItem`

Équivalent Python : `get_pratique`

### `getSession()`

Une session de formation (null si introuvable).

```php
public function getSession(int|string $id, ?array $fields = null): ?SessionsItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `?SessionsItem`

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

**Retour :** `list<SessionsItem>`

Équivalent Python : `list_sessions`
