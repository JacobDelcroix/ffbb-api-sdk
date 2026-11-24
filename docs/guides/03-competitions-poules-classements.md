# 03 — Compétitions, poules et classements

Référence : [Compétitions, poules et classements](../reference/competitions.md)

## Vocabulaire FFBB

- **Compétition** : un championnat ou une coupe pour une catégorie (ex. U15 Féminine Départementale 2).
- **Phase** : une étape de la compétition (brassage, phase 1, play-offs…).
- **Poule** : un groupe d'équipes qui se rencontrent ; c'est elle qui porte les rencontres et le classement.
- **Engagement** : une équipe d'un club inscrite dans une compétition et une poule.

## Compétition

```php
$competition = $ffbb->getCompetition(500);   // ?CompetitionsItem

$competition->nom;
$competition->sexe;
$competition->categorie?->code;   // ex. U15 (CategoriesChampionnatsItem)

foreach ($competition->poules ?? [] as $poule) {   // list<PoulesItem>
    echo $poule->id.' — '.$poule->nom;
}

foreach ($competition->phases ?? [] as $phase) {   // phases : brutes (structure non décrite par la spec)
    foreach ($phase['poules'] ?? [] as $poule) {
        echo $poule['id'].' — '.$poule['nom'];
    }
}
```

Les rencontres imbriquées sont limitées à 1000 (`deepLimit`). Pour une compétition volumineuse, demande
moins de champs ou baisse la limite : `getCompetition(500, deepLimit: '100', fields: ['id', 'nom', 'poules.id', 'poules.nom'])`.

Si Directus refuse l'accès direct (fréquent pour les **saisons archivées**), le SDK retente automatiquement
via le listing filtré (`filter[id][_eq]=500`), comme le SDK Python.

Liste rapide de compétitions : `listCompetitions(limit: 50)` (par défaut, champs `id` et `nom`).

## Poule

```php
$poule = $ffbb->getPoule(900);   // ?PoulesItem

$poule->nom;
$poule->rencontres;    // list<RencontresItem> : équipes, scores, salle, officiels
$poule->classements;   // list<PoulesClassementsItem>
```

## Classement

```php
$classement = $ffbb->getClassement(900);   // list<PoulesClassementsItem>

foreach ($classement as $ligne) {
    printf(
        "%d. %s — %d pts (%d J, %d V, %d D, diff. %+d)\n",
        $ligne->position,
        $ligne->idEngagement?->nom ?? $ligne->organisme?->nom,
        $ligne->points,
        $ligne->matchJoues,
        $ligne->gagnes,
        $ligne->perdus,
        $ligne->difference,
    );
}
```

Champs disponibles par ligne : `position`, `points`, `matchJoues`, `gagnes`, `perdus`, `nuls`,
`paniersMarques`, `paniersEncaisses`, `difference`, `quotient`, `nombreForfaits`, `nombreDefauts`,
`penalitesArbitrage`, `penalitesEntraineur`, `penalitesDiverses`, `horsClassement`,
`idEngagement` (`EngagementsItem` : `id`, `nom`, `nomUsuel`, `codeAbrege`, `numeroEquipe`, `logo`) et
`organisme` (`OrganismesItem` : `id`, `nom`, `logo`). Liste complète : [PoulesClassementsItem](../reference/dtos.md#poulesclassementsitem).

### Mettre en avant son équipe

```php
$maLigne = array_values(array_filter(
    $ffbb->getClassement(900) ?? [],
    fn ($ligne) => $ligne->organisme?->id === '10238',
))[0] ?? null;

$maLigne?->position;
```

> [!NOTE]
> Si Directus est bloqué, la poule est reconstruite depuis Meilisearch et le classement est **recalculé**
> à partir des rencontres jouées (2 points par victoire, 1 par défaite). Les pénalités et forfaits ne sont alors
> pas pris en compte.

## Saisons

```php
$saisons = $ffbb->getSaisons();      // list<SaisonsItem>, saisons actives ({"actif":{"_eq":true}})
$saisons[0]->libelle;                // « Saison 2026-2027 »
$saisons[0]->debut?->format('d/m/Y');

$ffbb->getSaisons(filterCriteria: null, fields: ['id', 'libelle', 'code', 'actif']); // toutes
```

Si Directus est indisponible, `getSaisons()` renvoie la saison en cours codée en dur (comme le SDK Python).
