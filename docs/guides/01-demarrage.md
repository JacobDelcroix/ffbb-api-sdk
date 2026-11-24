# 01 — Démarrage

## Installation

```bash
composer require jacobdelcroix/ffbb-api-sdk
```

PHP 8.3 ou plus récent. Dépendances : Saloon v4, son plugin de cache et `psr/simple-cache`.

## Créer le client

```php
use CoachBasket\Ffbb\FfbbDataClient;

$ffbb = FfbbDataClient::create();
```

Sans argument, le client :

- résout les **jetons** au premier appel : variables d'environnement, sinon l'endpoint public
  `items/configuration` (comme l'app mobile), sinon des jetons publics de repli ;
- met en **cache** les réponses Directus 30 minutes et les recherches Meilisearch 5 minutes, dans la mémoire
  du process (en Laravel, le cache de l'application : voir le [guide 09](09-laravel.md)).

Toutes les options :

```php
$ffbb = FfbbDataClient::create(
    meilisearchBearerToken: null,        // null = résolution automatique
    apiBearerToken: null,
    cache: $psr16Cache,                  // n'importe quel cache PSR-16
    cacheTtl: 1800,                      // secondes, null = pas de cache HTTP
    apiBaseUrl: 'https://api.ffbb.com/',
    meilisearchBaseUrl: 'https://meilisearch-prod.ffbb.app/',
);
```

Variables d'environnement reconnues :

| Variable | Rôle |
|---|---|
| `API_FFBB_APP_BEARER_TOKEN` | jeton Directus (les deux jetons doivent être définis ensemble) |
| `MEILISEARCH_BEARER_TOKEN` | jeton Meilisearch |
| `API_FFBB_BASE_URL` | URL Directus |
| `MEILISEARCH_URL` | URL Meilisearch |
| `FFBB_USER_AGENT` | User-Agent envoyé en premier (par défaut : celui de l'app Android) |

## Premier parcours : de mon club à mon classement

```php
// 1. Trouver le club : la recherche renvoie un SearchResult, avec des hits typés
$club = $ffbb->searchOrganismes('Ostrevent')->first();   // OrganismesHit
$club->id;     // '10238'
$club->code;   // 'HDF0059038'
$club->nom;    // 'OSTREVENT BASKET BALL EAA MONCHECOURT'

// 2. Ses équipes engagées cette saison
$equipes = $ffbb->getEquipes((int) $club->id);            // list<EngagementsItem>

// 3. Choisir une équipe : ici la première U15 féminine
$u15f = array_values(array_filter(
    $equipes,
    fn ($e) => str_contains($e->competition?->nom ?? '', 'U15') && $e->competition?->sexe === 'F',
))[0];

// 4. Classement et matchs de sa poule
$pouleId = (int) $u15f->poule->id;
$classement = $ffbb->getClassement($pouleId);              // list<PoulesClassementsItem>
$rencontres = $ffbb->listRencontresByPoule($pouleId);      // list<RencontresItem>
```

## Forme des données

**Toutes les méthodes renvoient des objets typés** : l'IDE complète les propriétés et PHPStan vérifie les types.

| Source | Type renvoyé | Exemple |
|---|---|---|
| un élément Directus | DTO de la collection, ou `null` si introuvable | `getOrganisme()` → `?OrganismesItem` |
| une liste Directus | liste de DTOs (`[]` si vide) | `listRencontres()` → `list<RencontresItem>` |
| une recherche | `SearchResult` dont les hits sont typés selon l'index | `searchSalles()` → `?SearchResult<SallesHit>` |
| les matchs en direct | `list<Live>` | `getLives()` |

Ce que garantissent les DTOs :

- **toutes les propriétés sont nullables** : les données FFBB sont souvent partielles ;
- **les conversions sont tolérantes** : `"1"` → `true`, `"72"` → `72`, et les dates sont des `DateTimeImmutable` ;
- **une relation est toujours un objet, au nom naturel** : `$equipe->poule` est un `PoulesItem` (champ Directus
  `idPoule`). Si Directus ne l'a pas développée, seul `->id` est rempli (`->nom` vaut `null`) ;
- **`->raw` (ou `toArray()`) conserve la réponse complète**, y compris les champs absents de la spec.

Détails : [guide 07 — DTOs](07-dtos.md).

## Suite

- [Clubs et équipes](02-clubs-et-equipes.md)
- [Référence API](../reference/README.md)
