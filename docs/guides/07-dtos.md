# 07 — DTOs

Référence : [DTOs](../reference/dtos.md) (toutes les classes et leurs propriétés)

Toutes les méthodes du SDK renvoient des objets typés. Il y en a de deux familles, toutes deux **générées**
par `php bin/generate-dtos` et régénérées automatiquement quand la FFBB ou le SDK Python changent
(voir [maintenance](../maintenance.md)).

| Famille | Namespace | Source | Exemples |
|---|---|---|---|
| Collections Directus | `CoachBasket\Ffbb\Data` | spec OpenAPI de Directus | `OrganismesItem`, `RencontresItem`, `PoulesClassementsItem` |
| Réponses Meilisearch et lives | `CoachBasket\Ffbb\Data\Models` | modèles du SDK Python + attributs observés | `SearchResult`, `OrganismesHit`, `RencontresHit`, `Live` |

## Ce que garantissent les DTOs

- **Toutes les propriétés sont nullables** : les données FFBB sont souvent partielles.
- **Conversions tolérantes** : `"1"` → `true`, `"12"` → `12`, `"3.5"` → `3.5`.
- **Dates en `DateTimeImmutable`** : `$match->date_rencontre?->format('d/m/Y H:i')`.
- **Relations toujours en objets** : `$equipe->idPoule` est un `PoulesItem`. Quand Directus ne développe pas
  la relation, seul l'identifiant est rempli :

  ```php
  $equipe = $ffbb->getEngagement($id);

  $equipe->idPoule->id;    // toujours renseigné
  $equipe->idPoule->nom;   // null si le champ idPoule.nom n'a pas été demandé
  ```

- **`$raw` garde la réponse complète**, y compris les champs absents de la spec ; `toArray()` la renvoie.

## Collections Directus

Une classe par collection : `ffbbserver_rencontres` → `RencontresItem`, `ffbbserver_poules_classements` →
`PoulesClassementsItem`, `edf_players` → `EdfPlayersItem`, `configuration` → `ConfigurationItem`…

```php
use CoachBasket\Ffbb\Data\ItemMap;

ItemMap::for('ffbbserver_engagements'); // EngagementsItem::class
ItemMap::CLASSES;                       // toutes les correspondances
```

Une collection sans DTO (ex. `ffbbsite_*`) renvoie un `Item` générique depuis le query builder :

```php
$page = $ffbb->directus('ffbbsite_pages')->first();   // Item

$page->title;               // lecture comme une propriété
$page->get('section.nom');  // notation pointée
```

## Réponses Meilisearch

Chaque recherche renvoie un `SearchResult` : `hits`, `estimatedTotalHits`, `facetDistribution`, `facetStats`,
`processingTimeMs`, plus `first()`, `count()`, `isEmpty()` et `facet($nom)`.

Les hits sont typés selon l'index (`OrganismesHit`, `SallesHit`…) avec leurs objets imbriqués
(`Commune`, `Geo`, `Logo`, `Organisateur`…). Ils sont générés depuis les modèles Python, puis complétés par les
attributs réellement observés dans l'index : les DTOs PHP en savent donc plus que le SDK Python
(ex. `RencontresHit::$joue`, `$resultatEquipe1`, `$resultatEquipe2`).

> [!NOTE]
> Le SDK Python inverse les modèles `TerrainsHit` et `TournoisHit`. Le générateur choisit, pour chaque index,
> le modèle qui correspond aux attributs observés : en PHP, `TerrainsHit` contient bien les terrains.

Les index de contenu (actualités, vidéos, RSS, galeries) changent souvent de schéma : leurs hits sont des
`ContentHit` (champs communs typés, le reste dans `$raw`, lisible avec `get('champ')`).

## Matchs en direct

```php
foreach ($ffbb->getLives() ?? [] as $live) {   // list<Live>
    $live->teamName_home;
    $live->score_home;
    $live->currentPeriod;
    $live->clock;          // ex. « 05:12 »
}
```

## Revenir aux tableaux

```php
$club->toArray();                                 // réponse brute d'un DTO
$resultat->toArray();                             // réponse Meilisearch brute
$ffbb->directus('ffbbserver_salles')->getRaw();   // tableaux Directus depuis le query builder
```
