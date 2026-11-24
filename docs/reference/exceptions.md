<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Exceptions

Toutes les exceptions implémentent `FfbbException`. Les erreurs HTTP étendent `Saloon\Exceptions\Request\RequestException` (accès à la réponse via `getResponse()`).

Guide : [08-erreurs-cache-et-repli](../guides/08-erreurs-cache-et-repli.md)

| Exception | Parent | Quand |
|---|---|---|
| `FfbbException` | interface | Interface commune à toutes les exceptions du SDK (équivalent de FFBBError). |
| `FfbbHttpException` | `RequestException` | Erreur HTTP renvoyée par un service FFBB (équivalent de FFBBHTTPError). |
| `FfbbNotFoundException` | `FfbbHttpException` | HTTP 404 — ressource introuvable (FFBBNotFoundError). |
| `FfbbAuthenticationException` | `FfbbHttpException` | HTTP 401/403 — accès refusé par Directus ou bloqué par le WAF BunnyCDN (FFBBAuthenticationError). |
| `FfbbRateLimitException` | `FfbbHttpException` | HTTP 429 — trop de requêtes (FFBBRateLimitError). |
| `FfbbServerException` | `FfbbHttpException` | HTTP 5xx — erreur serveur FFBB (FFBBServerError). |
| `FfbbTransportException` | `RuntimeException` | Service FFBB injoignable : DNS, timeout, connexion refusée (FFBBTransportError). |
| `FfbbResponseValidationException` | `RuntimeException` | Réponse FFBB illisible ou incomplète (FFBBResponseValidationError). |
| `ValidationException` | `InvalidArgumentException` | Paramètre d'entrée invalide (ValidationError de input_validation.py). |
