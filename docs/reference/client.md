<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Client

Création du client, query builder Directus, préchargement du cache.

Guide avec exemples : [01-demarrage](../guides/01-demarrage.md)

| Méthode | Retour | Description |
|---|---|---|
| [`create()`](#create) | `self` | Crée un client prêt à l'emploi. |
| [`withMockClient()`](#withmockclient) | `self` | Branche un MockClient Saloon sur les deux connectors (tests). |
| [`directus()`](#directus) | `QueryBuilder<T>` | Query builder Directus complet sur n'importe quelle collection. |
| [`warmOrganismeCache()`](#warmorganismecache) | `void` | Pré-charge un organisme et ses équipes dans le cache. |
| [`warmCompetitionCache()`](#warmcompetitioncache) | `void` | Pré-charge une compétition et toutes ses poules dans le cache. |
| [`close()`](#close) | `void` | Rien à fermer côté PHP (pas de session persistante) ; présent pour la parité d'API. |

### `create()`

Crée un client prêt à l'emploi.

Les jetons manquants sont résolus par TokenManager (env → cache → items/configuration → repli).

```php
public static function create(?string $meilisearchBearerToken = null, ?string $apiBearerToken = null, ?CacheInterface $cache = null, ?int $cacheTtl = 1800, ?string $apiBaseUrl = null, ?string $meilisearchBaseUrl = null): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$meilisearchBearerToken` | `?string` | `null` | Jeton Meilisearch (null : résolution automatique). |
| `$apiBearerToken` | `?string` | `null` | Jeton Directus (null : résolution automatique). |
| `$cache` | `CacheInterface\|null` | `null` | cache PSR-16 (Laravel : Cache::store()). Par défaut : mémoire du process. |
| `$cacheTtl` | `int\|null` | `1800` | TTL du cache HTTP Directus en secondes (1800 comme en Python, null = désactivé) |
| `$apiBaseUrl` | `?string` | `null` | URL Directus (défaut : `https://api.ffbb.com/`). |
| `$meilisearchBaseUrl` | `?string` | `null` | URL Meilisearch (défaut : `https://meilisearch-prod.ffbb.app/`). |

**Retour :** `self`

### `withMockClient()`

Branche un MockClient Saloon sur les deux connectors (tests).

```php
public function withMockClient(MockClient $mockClient): self
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$mockClient` | `MockClient` | — | MockClient Saloon à brancher sur les deux connectors. |

**Retour :** `self`

### `directus()`

Query builder Directus complet sur n'importe quelle collection.

Accepte un nom de collection ou une classe DTO (qui donne le type des résultats à l'IDE) :

```php
$ffbb->directus(RencontresItem::class)->where('idPoule', '_eq', 900)->sort('-date_rencontre')->get();
$ffbb->directus('ffbbserver_rencontres')->where('joue', '_eq', true)->first();
```

```php
public function directus(string $collection): QueryBuilder
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$collection` | `class-string<T>\|string` | — | Collection Directus, ex. `ffbbserver_rencontres` (le préfixe `items/` est optionnel). |

**Retour :** `QueryBuilder<T>`

### `warmOrganismeCache()`

Pré-charge un organisme et ses équipes dans le cache.

```php
public function warmOrganismeCache(int|string $organismeId): void
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$organismeId` | `int\|string` | — | Identifiant numérique de l'organisme (ex. `10238`), pas son code `HDF…`. |

**Retour :** `void`

Équivalent Python : `warm_organisme_cache`

### `warmCompetitionCache()`

Pré-charge une compétition et toutes ses poules dans le cache.

```php
public function warmCompetitionCache(int|string $competitionId): void
```

| Paramètre | Type | Défaut | Description |
|---|---|---|---|
| `$competitionId` | `int\|string` | — | Identifiant de la compétition. |

**Retour :** `void`

Équivalent Python : `warm_competition_cache`

### `close()`

Rien à fermer côté PHP (pas de session persistante) ; présent pour la parité d'API.

```php
public function close(): void
```

**Retour :** `void`

Équivalent Python : `close`
