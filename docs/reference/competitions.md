<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Compétitions, poules et classements

Compétitions avec leurs phases et poules, détail d'une poule (rencontres + classement), saisons.

Guide avec exemples : [03-competitions-poules-classements](../guides/03-competitions-poules-classements.md)

| Méthode | Retour | Description |
|---|---|---|
| [`getCompetition()`](#getcompetition) | `?CompetitionsItem` | Détail d'une compétition avec phases, poules et rencontres imbriquées. |
| [`getPoule()`](#getpoule) | `?PoulesItem` | Détail d'une poule avec rencontres et classements. |
| [`getClassement()`](#getclassement) | `list<PoulesClassementsItem>\|null` | Uniquement le classement d'une poule, trié comme le renvoie la FFBB. |
| [`getSaisons()`](#getsaisons) | `list<SaisonsItem>` | Saisons (par défaut : les saisons actives). |

### `getCompetition()`

Détail d'une compétition avec phases, poules et rencontres imbriquées.

- 403 Directus (saison archivée) → nouvel essai via le listing filtré ;
- 403 BunnyCDN → l'exception remonte (diagnostic CDN explicite) ;
- autre erreur HTTP / réseau → reconstruction depuis Meilisearch.

```php
public function getCompetition(int|string $competitionId, ?string $deepLimit = '1000', ?array $fields = null): ?CompetitionsItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$competitionId` | `int\|string` | — | Identifiant de la compétition. |
| `$deepLimit` | `?string` | `'1000'` | Nombre maximum d'éléments imbriqués (rencontres, classements) renvoyés par Directus. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `?CompetitionsItem`

Équivalent Python : `get_competition`

### `getPoule()`

Détail d'une poule avec rencontres et classements.

Sur erreur (hors 404), la poule est reconstruite depuis Meilisearch.

```php
public function getPoule(int|string $pouleId, ?string $deepLimit = '1000', ?array $fields = null): ?PoulesItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$pouleId` | `int\|string` | — | Identifiant de la poule. |
| `$deepLimit` | `?string` | `'1000'` | Nombre maximum d'éléments imbriqués (rencontres, classements) renvoyés par Directus. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `?PoulesItem`

Équivalent Python : `get_poule`

### `getClassement()`

Uniquement le classement d'une poule, trié comme le renvoie la FFBB.

```php
public function getClassement(int|string $pouleId): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$pouleId` | `int\|string` | — | Identifiant de la poule. |

**Retour :** `list<PoulesClassementsItem>|null`

Équivalent Python : `get_classement`

### `getSaisons()`

Saisons (par défaut : les saisons actives).

Si Directus est bloqué, renvoie la saison de repli codée en dur (comme le Python).

```php
public function getSaisons(?array $fields = null, ?string $filterCriteria = '{"actif":{"_eq":true}}'): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |
| `$filterCriteria` | `?string` | `'{"actif":{"_eq":true}}'` | Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`. |

**Retour :** `list<SaisonsItem>`

Équivalent Python : `get_saisons`
