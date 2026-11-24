# 04 — Rencontres et listes

Référence : [Ressources unitaires](../reference/ressources.md) · [Listes et pagination](../reference/listes.md) · [Intégrations externes](../reference/externes.md)

## Une rencontre

```php
$match = $ffbb->getRencontre('r1');   // ?RencontresItem

echo "{$match->nomEquipe1} {$match->resultatEquipe1} - {$match->resultatEquipe2} {$match->nomEquipe2}";
$match->date_rencontre?->format('d/m/Y H:i');   // DateTimeImmutable
$match->joue;                                   // bool
$match->numeroJournee;
$match->salle?->libelle;                        // SallesItem
```

Même principe pour `getEngagement()`, `getSalle()`, `getTerrain()`, `getTournoi()`, `getFormation()`,
`getEntraineur()`, `getCommune()`, `getOfficiel()`, `getPratique()` : le DTO de la collection, ou `null` si l'élément n'existe pas.

## Les matchs d'une poule

```php
$rencontres = $ffbb->listRencontresByPoule(900);                 // list<RencontresItem>, 500 max
$rencontres = $ffbb->listRencontresByPoules([900, 901, 902]);    // par lots de 50 poules
```

## Calendrier et résultats d'un club

Les méthodes `list*` acceptent un **filtre Directus en JSON**. Pour un club, on filtre sur les deux côtés :

```php
$filtre = ['_and' => [
    ['_or' => [
        ['idOrganismeEquipe1' => ['_eq' => 10238]],
        ['idOrganismeEquipe2' => ['_eq' => 10238]],
    ]],
    ['joue' => ['_eq' => false]],
]];

$aVenir = $ffbb->listRencontres(limit: 20, filterCriteria: json_encode($filtre), sort: ['date_rencontre']);
```

C'est plus lisible avec le [query builder](06-query-builder-directus.md) :

```php
use CoachBasket\Ffbb\Data\RencontresItem;

$derniersResultats = $ffbb->directus(RencontresItem::class)
    ->filter(['_or' => [
        ['idOrganismeEquipe1' => ['_eq' => 10238]],
        ['idOrganismeEquipe2' => ['_eq' => 10238]],
    ]])
    ->where('joue', '_eq', true)
    ->sort('-date_rencontre')
    ->limit(10)
    ->get();   // list<RencontresItem>

foreach ($derniersResultats as $match) {
    echo $match->date_rencontre?->format('d/m').' : '.$match->nomEquipe1.' '.$match->resultatEquipe1.'-'.$match->resultatEquipe2.' '.$match->nomEquipe2.PHP_EOL;
}
```

## Une page, toutes les pages, ou en flux

Pour chacune des 10 ressources (rencontres, salles, terrains, tournois, engagements, formations,
entraîneurs, communes, officiels, pratiques) :

```php
// Une page : list<SallesItem>
$ffbb->listSalles(limit: 50, offset: 100, sort: ['libelle']);

// Toutes les pages en mémoire (20 pages max, 10 000 éléments max)
$ffbb->listAllSalles(filterCriteria: '{"commune":{"codePostal":{"_starts_with":"59"}}}', pageSize: 100);

// En flux : une page à la fois, pour les gros volumes
foreach ($ffbb->iterAllSalles(pageSize: 200) as $salle) {   // SallesItem
    echo $salle->libelle.' — '.$salle->commune?->libelle.PHP_EOL;
}
```

Le paramètre `search` fait une recherche plein texte Directus : `listSalles(search: 'Monchecourt')`.

## Recherche par lots

```php
$ffbb->listEngagementsByIds([123, 456, 789]);   // lots de 50 identifiants
$ffbb->listEntraineursByIds([12345678]);        // par numéro de licence
$ffbb->listEngagementsByPoules([900, 901]);
```

## Matchs en direct

```php
$lives = $ffbb->getLives();   // list<Live>|null, jamais mis en cache

foreach ($lives ?? [] as $live) {
    echo "{$live->teamName_home} {$live->score_home} - {$live->score_out} {$live->teamName_out} ({$live->currentPeriod})".PHP_EOL;
}
```

## Données des partenaires

Directus expose aussi les collections de partenaires de la FFBB :

```php
$ffbb->listGeniusSportMatches(limit: 20);   // list<GeniusSportMatchesItem>, statistiques live
$ffbb->listRematchVideos(limit: 20);        // list<RematchVideosItem>
$ffbb->listEdfTeams();                      // list<EdfTeamsItem>, équipes de France
$ffbb->listEdfPlayers(limit: 50, sort: ['last_name']);
```

Ces collections peuvent être restreintes selon la saison : un 403 Directus lève une `FfbbAuthenticationException`.
