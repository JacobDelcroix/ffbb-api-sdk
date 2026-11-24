<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Clubs et organismes

Organismes FFBB (clubs, comités, ligues), équipes engagées et contacts.
Un « organisme » se désigne par son **identifiant numérique** (ex. `10238`), pas par son code (`HDF0059038`) : voir `searchOrganismes()` pour passer de l'un à l'autre.

Guide avec exemples : [02-clubs-et-equipes](../guides/02-clubs-et-equipes.md)

| Méthode | Retour | Description |
|---|---|---|
| [`getOrganisme()`](#getorganisme) | `?OrganismesItem` | Détail d'un organisme : club, comité ou ligue (77 champs par défaut). |
| [`getOrganismeForSearch()`](#getorganismeforsearch) | `?OrganismesItem` | Version allégée de getOrganisme() pour les contextes de recherche (31 champs). |
| [`getEquipes()`](#getequipes) | `list<EngagementsItem>\|null` | Uniquement les équipes engagées d'un club, avec leur compétition et leur poule. |
| [`listCompetitions()`](#listcompetitions) | `list<CompetitionsItem>` | Liste de compétitions (par défaut : id et nom). |
| [`getClubContacts()`](#getclubcontacts) | `?ClubContacts` | Contacts d'un club : contact du club et membres (dirigeants). |
| [`getEngagementContacts()`](#getengagementcontacts) | `?EngagementContacts` | Contacts d'une équipe engagée : correspondant, entraîneur et adjoint. |

### `getOrganisme()`

Détail d'un organisme : club, comité ou ligue (77 champs par défaut).

Sur erreur (hors 404), l'organisme est reconstruit depuis Meilisearch.

```php
public function getOrganisme(int|string $organismeId, ?array $fields = null): ?OrganismesItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$organismeId` | `int\|string` | — | Identifiant numérique de l'organisme (ex. `10238`), pas son code `HDF…`. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `?OrganismesItem`

Équivalent Python : `get_organisme`

### `getOrganismeForSearch()`

Version allégée de getOrganisme() pour les contextes de recherche (31 champs).

```php
public function getOrganismeForSearch(int|string $organismeId): ?OrganismesItem
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$organismeId` | `int\|string` | — | Identifiant numérique de l'organisme (ex. `10238`), pas son code `HDF…`. |

**Retour :** `?OrganismesItem`

Équivalent Python : `get_organisme_for_search`

### `getEquipes()`

Uniquement les équipes engagées d'un club, avec leur compétition et leur poule.

```php
public function getEquipes(int|string $organismeId): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$organismeId` | `int\|string` | — | Identifiant numérique de l'organisme (ex. `10238`), pas son code `HDF…`. |

**Retour :** `list<EngagementsItem>|null`

Équivalent Python : `get_equipes`

### `listCompetitions()`

Liste de compétitions (par défaut : id et nom).

```php
public function listCompetitions(int $limit = 10, ?array $fields = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `list<CompetitionsItem>`

Équivalent Python : `list_competitions`

### `getClubContacts()`

Contacts d'un club : contact du club et membres (dirigeants).

Contient des données personnelles : voir docs/legal.md.

```php
public function getClubContacts(int|string $organismeId): ?ClubContacts
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$organismeId` | `int\|string` | — | Identifiant numérique de l'organisme (ex. `10238`), pas son code `HDF…`. |

**Retour :** `?ClubContacts`

Équivalent Python : `get_club_contacts`

### `getEngagementContacts()`

Contacts d'une équipe engagée : correspondant, entraîneur et adjoint.

Contient des données personnelles : voir docs/legal.md.

```php
public function getEngagementContacts(int|string $id): ?EngagementContacts
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `int\|string` | — | Identifiant Directus de l'élément. |

**Retour :** `?EngagementContacts`

Équivalent Python : `get_engagement_contacts`
