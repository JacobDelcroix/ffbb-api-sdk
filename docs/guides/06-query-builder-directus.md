# 06 — Query builder Directus

Référence : [Query builder](../reference/query-builder.md)

Les méthodes reprises du SDK Python couvrent les usages courants. Pour tout le reste, `directus()` donne accès
à **tous les paramètres de l'API Items de Directus** sur n'importe quelle collection.

```php
use CoachBasket\Ffbb\Data\RencontresItem;

$q = $ffbb->directus(RencontresItem::class);    // recommandé : l'IDE connaît le type des résultats
$q = $ffbb->directus('ffbbserver_rencontres');  // équivalent (ou 'items/ffbbserver_rencontres')
```

Les résultats sont hydratés dans le DTO de la collection (`RencontresItem`…). Une collection sans DTO
(ex. `ffbbsite_pages`) renvoie des `Item` génériques : `$page->title`, `$page->get('section.nom')`.
Les collections disponibles sont listées dans la [référence DTOs](../reference/dtos.md#réponses-directus) et,
de façon exhaustive, dans `resources/discovery/openapi.json`.

## Champs

```php
$q->fields(['id', 'date_rencontre', 'nomEquipe1', 'nomEquipe2'])
  ->fields('idPoule.nom')          // relation développée
  ->fields('salle.*');             // tous les champs de la relation
```

Sans `fields()`, Directus renvoie les champs de premier niveau (relations sous forme d'identifiant).

## Filtres

```php
// Conditions successives combinées en ET, champs pointés acceptés
$q->where('idPoule', '_eq', 900)
  ->where('joue', '_eq', true)
  ->where('competitionId.categorie.code', '_in', ['U13', 'U15']);

// Filtre complet (OU, imbrications…) en tableau ou en JSON
$q->filter(['_or' => [
    ['idOrganismeEquipe1' => ['_eq' => 10238]],
    ['idOrganismeEquipe2' => ['_eq' => 10238]],
]]);
```

Opérateurs : `_eq`, `_neq`, `_lt`, `_lte`, `_gt`, `_gte`, `_in`, `_nin`, `_null`, `_nnull`, `_contains`,
`_icontains`, `_starts_with`, `_ends_with`, `_between`, `_empty`, `_nempty`
([documentation Directus](https://docs.directus.io/reference/filter-rules.html)).

## Tri, pagination, recherche

```php
$q->sort('-date_rencontre')   // décroissant
  ->sort('numero')            // puis croissant
  ->limit(50)                 // -1 = tout (si l'instance l'autorise)
  ->offset(100);              // ou ->page(3)

$q->search('Monchecourt');    // plein texte sur les champs texte
```

## Relations imbriquées (`deep`)

```php
use CoachBasket\Ffbb\Data\PoulesItem;

$poule = $ffbb->directus(PoulesItem::class)
    ->fields(['id', 'nom', 'rencontres.*'])
    ->deep('rencontres', ['_limit' => 5, '_sort' => ['-date_rencontre']])
    ->find(900);   // ?PoulesItem

$poule->rencontres[0]->nomEquipe1;   // RencontresItem
```

## Agrégats

```php
// Nombre d'équipes dans une poule
$ffbb->directus('ffbbserver_engagements')->where('idPoule', '_eq', 900)->count();

// Nombre de rencontres par poule d'une compétition : les lignes d'agrégat ne sont pas des rencontres,
// on les lit en tableaux avec getRaw()
$ffbb->directus('ffbbserver_rencontres')
    ->where('competitionId', '_eq', 500)
    ->aggregate('count', '*')
    ->groupBy('idPoule')
    ->getRaw();   // [['idPoule' => '900', 'count' => '56'], ...]
```

## Exécuter

| Méthode | Renvoie |
|---|---|
| `get()` | liste de DTOs (`list<RencontresItem>`…) |
| `first()` | DTO ou `null` |
| `find($id)` | DTO ou `null` (seuls `fields`, `deep` et `alias` s'appliquent) |
| `cursor($pageSize = 100)` | générateur de DTOs sur tous les résultats, page par page |
| `count()` | `int` |
| `getRaw()` / `firstRaw()` / `findRaw($id)` | les mêmes résultats en tableaux Directus (agrégats, débogage) |
| `raw()` | réponse brute `['data' => …, 'meta' => …]` (avec `withMeta()`) |
| `toQuery()` | paramètres envoyés, sans requête (débogage) |

```php
$reponse = $ffbb->directus('ffbbserver_salles')
    ->where('commune.codePostal', '_starts_with', '59')
    ->withMeta('filter_count')
    ->limit(20)
    ->raw();

$reponse['meta']['filter_count']; // nombre total de salles correspondantes
```

> [!NOTE]
> Directus peut refuser certains champs ou collections (403) selon les droits du jeton public.
> Les requêtes passent par le même connector que le reste du SDK : retry, rotation de User-Agent et cache inclus.
