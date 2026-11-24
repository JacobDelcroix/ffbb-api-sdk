# 07 — DTOs

Référence : [DTOs](../reference/dtos.md) (47 classes et leurs propriétés)

Les DTOs de `src/Data/` sont **générés** depuis la spec OpenAPI de Directus (`php bin/generate-dtos`) et
régénérés automatiquement quand la FFBB change son schéma (voir [maintenance](../maintenance.md)).
Une classe par collection : `ffbbserver_rencontres` → `RencontresItem`, `ffbbserver_poules_classements` →
`PoulesClassementsItem`, etc.

## Hydrater

```php
use CoachBasket\Ffbb\Data\OrganismesItem;
use CoachBasket\Ffbb\Data\RencontresItem;

$club = OrganismesItem::fromArray($ffbb->getOrganisme(10238));
$rencontres = RencontresItem::collect($ffbb->listRencontresByPoule(900));

// Ou directement depuis le query builder
$rencontres = $ffbb->directus('ffbbserver_rencontres')->where('idPoule', '_eq', 900)->getData();
$poule = $ffbb->directus('ffbbserver_poules')->findData(900);
```

## Ce que font les DTOs

- **Toutes les propriétés sont nullables** : les données FFBB sont souvent partielles.
- **Conversions tolérantes** : `"1"` → `true`, `"12"` → `12`, `"3.5"` → `3.5`.
- **Relations** : un objet DTO quand Directus a développé la relation, sinon l'identifiant brut.

  ```php
  $match = RencontresItem::fromArray($ffbb->getPoule(900)['rencontres'][0]);

  if ($match->idPoule instanceof \CoachBasket\Ffbb\Data\PoulesItem) {
      $match->idPoule->nom;
  } else {
      $match->idPoule;   // '900'
  }
  ```

- **`$raw`** garde la réponse complète, y compris les champs absents de la spec ; `toArray()` la renvoie.

## Trouver le DTO d'une collection

```php
use CoachBasket\Ffbb\Data\ItemMap;

ItemMap::for('ffbbserver_engagements'); // EngagementsItem::class
ItemMap::CLASSES;                       // toutes les correspondances
```

> [!NOTE]
> Les résultats Meilisearch (`search*`) n'ont pas de DTO : leurs documents n'ont pas exactement la même forme
> que les collections Directus. Ils restent des tableaux.
