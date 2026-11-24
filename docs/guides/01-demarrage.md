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
// 1. Trouver le club : la recherche renvoie un résultat Meilisearch, avec les hits
$club = $ffbb->searchOrganismes('Ostrevent')['hits'][0];
// ['id' => '10238', 'code' => 'HDF0059038', 'nom' => 'OSTREVENT BASKET BALL EAA MONCHECOURT', ...]

// 2. Ses équipes engagées cette saison
$equipes = $ffbb->getEquipes((int) $club['id']);

// 3. Choisir une équipe : ici la première U15 féminine
$u15f = array_values(array_filter(
    $equipes,
    fn (array $e) => str_contains($e['idCompetition']['nom'] ?? '', 'U15') && ($e['idCompetition']['sexe'] ?? '') === 'F',
))[0];

// 4. Classement et matchs de sa poule
$pouleId = (int) $u15f['idPoule']['id'];
$classement = $ffbb->getClassement($pouleId);
$rencontres = $ffbb->listRencontresByPoule($pouleId);
```

## Forme des données

Par souci de parité avec le SDK Python, les méthodes renvoient les **tableaux bruts** de Directus ou de Meilisearch :

- un élément → `array<string, mixed>|null` (`null` si introuvable) ;
- une liste → `list<array<string, mixed>>` (`[]` si vide) ;
- une recherche → le résultat Meilisearch : `['hits' => [...], 'estimatedTotalHits' => 42, 'facetDistribution' => [...]]`.

Les relations Directus sont soit un identifiant, soit un sous-tableau quand le jeu de champs les développe
(ex. `$equipe['idPoule']['nom']`). Pour travailler avec des objets typés, voir les [DTOs](07-dtos.md).

## Suite

- [Clubs et équipes](02-clubs-et-equipes.md)
- [Référence API](../reference/README.md)
