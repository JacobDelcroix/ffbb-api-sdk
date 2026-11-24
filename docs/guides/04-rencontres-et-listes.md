# 04 — Rencontres et listes

Référence : [Ressources unitaires](../reference/ressources.md) · [Listes et pagination](../reference/listes.md) · [Intégrations externes](../reference/externes.md)

## Une rencontre

```php
$match = $ffbb->getRencontre('r1');

$match['nomEquipe1'].' '.$match['resultatEquipe1'].' - '.$match['resultatEquipe2'].' '.$match['nomEquipe2'];
$match['date_rencontre'];  // date et heure
$match['joue'];            // match joué ?
$match['numeroJournee'];
```

Même principe pour `getEngagement()`, `getSalle()`, `getTerrain()`, `getTournoi()`, `getFormation()`,
`getEntraineur()`, `getCommune()`, `getOfficiel()`, `getPratique()` : un tableau, ou `null` si l'élément n'existe pas.

## Les matchs d'une poule

```php
$rencontres = $ffbb->listRencontresByPoule(900);                 // 500 max
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
$derniersResultats = $ffbb->directus('ffbbserver_rencontres')
    ->filter(['_or' => [
        ['idOrganismeEquipe1' => ['_eq' => 10238]],
        ['idOrganismeEquipe2' => ['_eq' => 10238]],
    ]])
    ->where('joue', '_eq', true)
    ->sort('-date_rencontre')
    ->limit(10)
    ->get();
```

## Une page, toutes les pages, ou en flux

Pour chacune des 10 ressources (rencontres, salles, terrains, tournois, engagements, formations,
entraîneurs, communes, officiels, pratiques) :

```php
// Une page
$ffbb->listSalles(limit: 50, offset: 100, sort: ['libelle']);

// Toutes les pages en mémoire (20 pages max, 10 000 éléments max)
$ffbb->listAllSalles(filterCriteria: '{"commune":{"codePostal":{"_starts_with":"59"}}}', pageSize: 100);

// En flux : une page à la fois, pour les gros volumes
foreach ($ffbb->iterAllSalles(pageSize: 200) as $salle) {
    // ...
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
$lives = $ffbb->getLives();   // list<array>|null, jamais mis en cache
```

## Données des partenaires

Directus expose aussi les collections de partenaires de la FFBB :

```php
$ffbb->listGeniusSportMatches(limit: 20);   // statistiques live Genius Sports
$ffbb->listRematchVideos(limit: 20);        // vidéos Rematch
$ffbb->listEdfTeams();                      // équipes de France
$ffbb->listEdfPlayers(limit: 50, sort: ['last_name']);
```

Ces collections peuvent être restreintes selon la saison : un 403 Directus lève une `FfbbAuthenticationException`.
