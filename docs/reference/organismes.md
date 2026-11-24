<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Clubs et organismes

Organismes FFBB (clubs, comités, ligues), équipes engagées et contacts.
Un « organisme » se désigne par son **identifiant numérique** (ex. `10238`), pas par son code (`HDF0059038`) : voir `searchOrganismes()` pour passer de l'un à l'autre.

Guide avec exemples : [02-clubs-et-equipes](../guides/02-clubs-et-equipes.md)

| Méthode | Retour | Description |
|---|---|---|
| [`getOrganisme()`](#getorganisme) | `array<string, mixed>\|null` | Détail d'un organisme (77 champs par défaut). |
| [`getOrganismeForSearch()`](#getorganismeforsearch) | `array<string, mixed>\|null` | Version allégée de getOrganisme() pour les contextes de recherche (31 champs). |
| [`getEquipes()`](#getequipes) | `list<array<string, mixed>>\|null` | Uniquement les équipes engagées d'un club. |
| [`listCompetitions()`](#listcompetitions) | `list<array<string, mixed>>` | Liste de compétitions (par défaut : id + nom). |
| [`getClubContacts()`](#getclubcontacts) | `?ClubContacts` | Contacts d'un club : contact du club + membres (dirigeants). |
| [`getEngagementContacts()`](#getengagementcontacts) | `?EngagementContacts` | Contacts d'une équipe engagée : correspondant, entraîneur et adjoint. |

### `getOrganisme()`

Détail d'un organisme (77 champs par défaut).

Sur erreur (hors 404), l'organisme est reconstruit depuis Meilisearch.

```php
public function getOrganisme(string|int $organismeId, ?array $fields = null): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$organismeId` | `string\|int` | — | Identifiant numérique de l'organisme (ex. `10238`), pas son code `HDF…`. |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_organisme`

### `getOrganismeForSearch()`

Version allégée de getOrganisme() pour les contextes de recherche (31 champs).

```php
public function getOrganismeForSearch(string|int $organismeId): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$organismeId` | `string\|int` | — | Identifiant numérique de l'organisme (ex. `10238`), pas son code `HDF…`. |

**Retour :** `array<string, mixed>|null`

Équivalent Python : `get_organisme_for_search`

### `getEquipes()`

Uniquement les équipes engagées d'un club.

```php
public function getEquipes(string|int $organismeId): ?array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$organismeId` | `string\|int` | — | Identifiant numérique de l'organisme (ex. `10238`), pas son code `HDF…`. |

**Retour :** `list<array<string, mixed>>|null`

Équivalent Python : `get_equipes`

### `listCompetitions()`

Liste de compétitions (par défaut : id + nom).

```php
public function listCompetitions(int $limit = 10, ?array $fields = null): array
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$limit` | `int` | `10` | Nombre maximum d'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement). |
| `$fields` | `list<string>\|null` | `null` | Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python. |

**Retour :** `list<array<string, mixed>>`

Équivalent Python : `list_competitions`

### `getClubContacts()`

Contacts d'un club : contact du club + membres (dirigeants).

```php
public function getClubContacts(string|int $organismeId): ?ClubContacts
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$organismeId` | `string\|int` | — | Identifiant numérique de l'organisme (ex. `10238`), pas son code `HDF…`. |

**Retour :** `?ClubContacts`

Équivalent Python : `get_club_contacts`

### `getEngagementContacts()`

Contacts d'une équipe engagée : correspondant, entraîneur et adjoint.

```php
public function getEngagementContacts(string|int $id): ?EngagementContacts
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$id` | `string\|int` | — | Identifiant Directus de l'élément. |

**Retour :** `?EngagementContacts`

Équivalent Python : `get_engagement_contacts`
