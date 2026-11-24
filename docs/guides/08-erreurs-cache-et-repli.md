# 08 — Erreurs, cache et repli

Référence : [Exceptions](../reference/exceptions.md)

## Ce que renvoient les méthodes en cas de problème

| Situation | Comportement |
|---|---|
| Élément introuvable (404) | `get*()` → `null`, `list*()` → `[]` |
| Paramètre invalide (filtre non JSON, recherche > 200 caractères…) | `ValidationException`, **avant** tout appel réseau |
| Erreur réseau, 429, 5xx | jusqu'à **3 essais** avec backoff exponentiel (1 s, 2 s), puis exception |
| 403 BunnyCDN (WAF) | nouvel essai avec le **User-Agent suivant** (Android, Android ancien, iOS, Safari) |
| 401 | jetons rafraîchis une fois, puis nouvel essai |
| 403 Directus (droits, saison archivée) | `FfbbAuthenticationException`, sans nouvel essai |

Certaines méthodes ont un **repli** plutôt qu'une exception, comme dans le SDK Python :

| Méthode | Si Directus échoue |
|---|---|
| `getOrganisme()`, `getEquipes()`, `getClubContacts()` | organisme et engagements reconstruits depuis Meilisearch |
| `getCompetition()` | 403 Directus → listing filtré ; autre erreur → Meilisearch ; 403 BunnyCDN → exception |
| `getPoule()`, `getClassement()` | poule reconstruite depuis Meilisearch, classement recalculé depuis les matchs |
| `getSaisons()` | saison en cours codée en dur |
| `getConfiguration()`, `getOpenapiSpec()` | `null` |

## Attraper les erreurs

```php
use CoachBasket\Ffbb\Exceptions\FfbbAuthenticationException;
use CoachBasket\Ffbb\Exceptions\FfbbException;
use CoachBasket\Ffbb\Exceptions\FfbbTransportException;

try {
    $rencontre = $ffbb->getRencontre($id);
} catch (FfbbAuthenticationException $e) {
    if ($e->isBunnyCdnBlock()) {
        // l'IP du serveur est bloquée par le WAF de la FFBB : passer par Meilisearch
    }
} catch (FfbbTransportException $e) {
    // FFBB injoignable
} catch (FfbbException $e) {
    // toute autre erreur du SDK
    $e->getMessage();
}
```

Les erreurs HTTP (`FfbbHttpException` et ses enfants) étendent `RequestException` de Saloon :
`$e->getResponse()->status()`, `->body()`, `->headers()`.

## Jetons

`TokenManager` les résout dans cet ordre :

1. passés à `FfbbDataClient::create()` ;
2. variables d'environnement `API_FFBB_APP_BEARER_TOKEN` et `MEILISEARCH_BEARER_TOKEN` ;
3. cache (6 h) ;
4. `GET items/configuration` sur `api.ffbb.com`, `api.ffbb.app`, `bo.ffbb.com`, `bo.ffbb.app`, avec chaque User-Agent ;
5. jetons publics de repli (`Config::DEFAULT_FALLBACK_*`).

```php
$tokens = $ffbb->api->tokens->getTokens();
$tokens->source;      // TokenSource::Configuration, Environment, Cache, Fallback…
$ffbb->api->tokens->refresh();
```

## Cache

| Quoi | Durée | Réglage |
|---|---|---|
| Réponses Directus (`get*`, `list*`, query builder) | 30 min | `create(cacheTtl: …)`, `null` pour désactiver |
| Recherches Meilisearch | 5 min | `Config::MEILISEARCH_CACHE_TTL` |
| Jetons | 6 h | `TokenManager` |
| Lives, configuration | jamais | — |

Le cache est un cache PSR-16 : la mémoire du process par défaut, celui de Laravel avec le service provider.
Pour forcer une lecture fraîche :

```php
$fresh = FfbbDataClient::create(cacheTtl: null);
```

Préchauffer le cache avant un pic de trafic (ex. le samedi matin) :

```php
$ffbb->warmOrganismeCache(10238);   // organisme + équipes
$ffbb->warmCompetitionCache(500);   // compétition + toutes ses poules
```

## Conseils de production

- **Mets un cache persistant** (Redis, base de données) : sans lui, chaque requête PHP refait les appels.
- **Ne lance pas de rafales** : la FFBB peut bloquer une IP qui interroge trop. Préfère des tâches planifiées
  qui préchauffent le cache plutôt que des appels à chaque visite.
- Si ton serveur est bloqué par le WAF, `getOrganisme()` et `getPoule()` continuent via Meilisearch ;
  `getCompetition()` lève une exception (comportement du SDK Python, pour rendre le blocage visible).
