# Maintenance : rester à jour avec la FFBB et le SDK Python

Le SDK dépend de deux choses qui bougent sans prévenir : **l'API FFBB** (schéma Directus, index Meilisearch,
WAF, jetons) et **le SDK Python** dont il est le portage (nouvelles méthodes, contournements, valeurs).
Chaque source a son mécanisme.

## 1. Découverte FFBB (`bin/discover`)

Workflow : `.github/workflows/ffbb-discovery.yml`, tous les jours à 04:23 UTC (et en manuel).

1. Récupère `server/specs/oas` (spec OpenAPI Directus) et la normalise (clés triées, `info.version` retirée).
2. Sonde chaque index Meilisearch (`q=""`, 20 hits), y compris tous ceux de l'instantané précédent, et relève les
   attributs observés et leur type JSON. Ces types complètent les DTOs de hits pour les attributs que le SDK Python ne modélise pas.
3. Compare avec `resources/discovery/openapi.json` et `resources/discovery/indexes.json` (`SchemaDiff`).
4. En cas de changement : met à jour les instantanés, **régénère les DTOs**, lance les tests et ouvre une PR
   `chore/ffbb-discovery` avec `resources/discovery/summary.md` en description.
   Le titre est préfixé ⚠️ si un changement est potentiellement cassant (suppression, changement de type).

Que faire d'une PR de découverte :

- **Ajouts seulement** : les DTOs ont déjà les nouveaux champs, on peut merger.
- **Suppression ou changement de type** : chercher le champ dans `src/` (listes de champs, méthodes, fallbacks)
  et adapter. Les champs Directus utilisés par défaut sont dans `src/Fields/FieldLists.php`.
- **Index indisponible** : vérifier les méthodes `search*` concernées et le fallback.

En local : `php bin/discover --dry-run` affiche le résumé sans rien écrire.

## 2. Synchronisation avec le SDK Python (`bin/sync-upstream`)

Workflow : `.github/workflows/upstream-sync.yml`, tous les jours à 05:41 UTC (et en manuel).

1. Clone `nickdesi/ffbb-data-client` et compare son `HEAD` à `.upstream-sha`.
2. `tools/extract_upstream.py` lit **statiquement** (module `ast`, aucun code exécuté) :
   - `config.py` → `resources/upstream/config.json` (URLs, User-Agents, endpoints, index, facettes, jetons de repli) ;
   - les façades → `resources/upstream/methods.json` (méthodes publiques synchrones) ;
   - les classes `*Fields` → `resources/upstream/fields.json`, puis `src/Fields/FieldLists.php` est régénéré ;
   - les modèles de réponse (`*Hit`, `Live` et leurs objets imbriqués) → `resources/upstream/models.json`
     (`tools/extract_models.py`), puis les DTOs de `src/Data/Models/` sont régénérés.
3. `tests/Unit/UpstreamParityTest.php` échoue si une méthode, un endpoint, un User-Agent, une facette
   ou une liste de champs diverge : la PR montre exactement ce qu'il reste à porter.
4. Si du code Python a changé (hors modèles), et si le secret `ANTHROPIC_API_KEY` est défini,
   **Claude Code** porte les changements en suivant `docs/prompts/upstream-sync.md`.
5. Une PR `chore/upstream-sync` est ouverte, même si les tests échouent. **Toujours relire avant de merger** :
   un portage de logique peut passer les tests et quand même se tromper.

En local :

```bash
git clone https://github.com/nickdesi/ffbb-data-client upstream
php bin/sync-upstream upstream
vendor/bin/pest --filter=Upstream
```

## Pourquoi deux mécanismes ?

Le repo Python peut s'arrêter. La découverte FFBB tourne directement sur `api.ffbb.com` : le schéma et les DTOs
restent à jour même sans lui. Le repo Python reste utile pour les **contournements** (User-Agents, hôtes de
repli, jetons) et les nouvelles méthodes.

## Secrets GitHub

| Secret | Utilisé par | Obligatoire |
|---|---|---|
| `API_FFBB_APP_BEARER_TOKEN`, `MEILISEARCH_BEARER_TOKEN` | découverte | non (lus sur `items/configuration`) |
| `ANTHROPIC_API_KEY` | portage automatique du code Python | non (sans lui, la PR ne contient que les données) |

Pense aussi à autoriser GitHub Actions à créer des PR : *Settings → Actions → General → Workflow permissions*.
