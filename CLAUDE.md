# CLAUDE.md — ffbb-php-sdk

SDK PHP (Saloon v4) non officiel pour les données FFBB, portage de `nickdesi/ffbb-data-client` (Python).

## Commandes

- `composer test` : Pest (aucune requête réelle : `Config::preventStrayRequests()` dans `tests/Pest.php`)
- `composer lint` : Pint (preset laravel, fichiers générés exclus)
- `php bin/generate-dtos` : régénère `src/Data/*Item.php` (spec OpenAPI Directus) et `src/Data/Models/*` (modèles Python `resources/upstream/models.json` + attributs observés `resources/discovery/indexes.json`)
- `python3 tools/generate_concerns.py` : régénère les traits répétitifs (`ListsResources`, `ManagesResources`, `ManagesExternalResources`, `SearchesMeilisearch`)
- `composer docs` (`php bin/generate-api-reference`) : régénère `docs/reference/` depuis le code ; `tests/Unit/DocumentationTest.php` échoue si elle est obsolète ou si une méthode publique n'a pas de docblock
- `php bin/generate-fields` : régénère `src/Fields/FieldLists.php` depuis `resources/upstream/fields.json`
- `php bin/sync-upstream <clone Python>` : extrait constantes, méthodes et champs du Python (lecture `ast`, jamais d'exécution)
- `php bin/discover [--dry-run]` : compare l'API FFBB réelle aux instantanés (requêtes réelles)

## Architecture

- `FfbbDataClient` : façade unique, composée de traits dans `src/Concerns/` (un par mixin Python).
  Chaque méthode publique Python synchrone a son équivalent camelCase (vérifié par `tests/Unit/UpstreamParityTest.php`).
- `Connectors/` : `ApiFfbbConnector` (Directus, cache plugin), `MeilisearchConnector`, `ConfigurationConnector` (sans auth).
  `FfbbConnector` mappe les statuts HTTP vers `Exceptions/`; `RetriesFfbbRequests` = retry, rotation UA sur 403 BunnyCDN, refresh jetons sur 401.
- `Auth/TokenManager` : explicite → env → cache → `items/configuration` (hôtes × UA) → jetons de repli de `Config`.
- `Search/` : `MultiSearchQuery`, `Index` (index + facettes), `HitMatcher` (filtrage client = `is_valid_for_query`), `MeilisearchSearcher` (cache 5 min, pagination récursive).
- `Fallback/` : reconstruction organisme / compétition / poule depuis Meilisearch quand Directus est bloqué.
- `Directus/QueryBuilder` : accès complet aux paramètres Directus, au-delà de la parité Python.
- `Data/` : DTOs **générés** (ne pas éditer à la main), `Support/Cast` pour les conversions tolérantes.
- `Discovery/` : `Discoverer` (instantané) + `SchemaDiff` (comparaison, résumé Markdown).

## Conventions

- Valeurs renvoyées : **toujours des DTOs**. Directus → `Data\XxxItem` ; Meilisearch → `Data\Models\SearchResult<XxxHit>` ; lives → `Data\Models\Live`. Relations Directus toujours en DTO (id seul si non développée). Tableaux bruts via `->raw` / `toArray()` / `QueryBuilder::getRaw()`.
- Logique interne en tableaux : méthodes protégées `fetchOrganisme()`, `fetchCompetition()`, `fetchPoule()` ; les méthodes publiques hydratent avec `hydrateOne()` / `XxxItem::collect()`.
- Erreurs : 404 → `null` / `[]` ; autres erreurs HTTP → exceptions `Ffbb*Exception` (sauf méthodes à repli documentées).
- Documentation : guides écrits à la main dans `docs/guides/`, référence générée dans `docs/reference/`.
- Fichiers générés : `src/Data/*Item.php`, `src/Data/ItemMap.php`, `src/Data/Models/*` (sauf `SearchResult` et `ContentHit`), `src/Fields/FieldLists.php`, les 4 traits listés plus haut, `docs/reference/*`. Modifier le générateur, pas le fichier.
- Le SDK Python inverse `TerrainsHit` / `TournoisHit` : le générateur choisit le modèle par recouvrement des attributs observés, et `HitMatcher` applique les règles aux bons index.
- Tests : Pest + `MockClient` Saloon, helpers `ffbb()`, `directus()`, `bunnyBlock()`, `meili()` dans `tests/Pest.php`.
- Pour porter une méthode Python : lire la méthode Python, l'implémenter dans le trait `Concerns/` correspondant,
  ajouter un test Feature avec `MockClient`, relancer `php bin/sync-upstream` puis `composer test`.

## Points d'attention

- Ne jamais exécuter le code du repo Python (clone non fiable) : uniquement `tools/extract_upstream.py` (lecture `ast`).
- Les données de contacts (membres, entraîneurs, correspondants) sont des **données personnelles** (RGPD).
- Voir `docs/legal.md` avant tout usage public ou commercial.
