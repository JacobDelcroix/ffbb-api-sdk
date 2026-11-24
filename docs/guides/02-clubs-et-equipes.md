# 02 — Clubs et équipes

Référence : [Clubs et organismes](../reference/organismes.md) · [Recherche](../reference/recherche.md)

## Identifiant ou code ?

Un club (un « organisme » FFBB) a deux identifiants :

| | Exemple | Où on le voit |
|---|---|---|
| **identifiant** numérique | `10238` | API Directus, attendu par toutes les méthodes `get*` |
| **code** | `HDF0059038` | URL de competitions.ffbb.com, `codeClub` des engagements |

Pour passer du code à l'identifiant, cherche le nom du club puis garde le hit dont le `code` correspond :

```php
$code = 'HDF0059038'; // depuis https://competitions.ffbb.com/ligues/hdf/comites/0059/clubs/hdf0059038

$hits = $ffbb->searchOrganismes('Ostrevent')?->hits ?? [];
$club = array_values(array_filter($hits, fn ($h) => $h->code === strtoupper($code)))[0] ?? null;

$clubId = (int) $club->id; // 10238
```

## Trouver des clubs

```php
// Par nom (filtrage côté client : le texte doit apparaître dans le nom, la commune ou le département)
$resultat = $ffbb->searchOrganismes('Monchecourt');   // ?SearchResult<OrganismesHit>

foreach ($resultat->hits as $club) {
    echo $club->nom.' — '.$club->commune?->libelle.PHP_EOL;
}

// Tous les clubs d'une commune (nom exact)
$ffbb->searchOrganismesByCity('Douai');

// Autour d'un point GPS, du plus proche au plus loin
$ffbb->searchOrganismesByGeo(lat: 50.30, lng: 3.21, radiusKm: 15);

// Plusieurs recherches en un seul appel
[$ostrevent, $douai] = $ffbb->searchMultipleOrganismes(['Ostrevent', 'Douai']);
```

## Détail d'un club

```php
$club = $ffbb->getOrganisme(10238);   // ?OrganismesItem

$club->nom;                 // OSTREVENT BASKET BALL EAA MONCHECOURT
$club->commune?->libelle;   // CommunesItem
$club->mail;
$club->engagements;         // list<EngagementsItem>, avec compétition et poule
```

Par défaut, 77 champs sont demandés (le même jeu que le SDK Python). Pour un usage léger :

```php
$ffbb->getOrganismeForSearch(10238);               // 31 champs
$ffbb->getOrganisme(10238, ['id', 'nom', 'code']); // champs choisis
```

## Équipes engagées

```php
$equipes = $ffbb->getEquipes(10238);   // list<EngagementsItem>

foreach ($equipes as $equipe) {
    echo $equipe->idCompetition?->nom;   // ex. « U15 Féminine Départementale 2 »
    echo $equipe->idCompetition?->sexe;  // F / M
    echo $equipe->idPoule?->nom;         // ex. « Poule A »
    echo $equipe->numeroEquipe;          // 1, 2… si le club a plusieurs équipes
}
```

`getEquipes()` mémorise au passage la correspondance poule → compétition : elle sert à reconstruire une
poule via Meilisearch si Directus est bloqué (voir le [guide 08](08-erreurs-cache-et-repli.md)).

Pour les équipes d'une poule (tous clubs confondus) : `listEngagementsByPoule(900)`.

## Contacts

> [!WARNING]
> Ces méthodes renvoient des **données personnelles** (noms, téléphones, e-mails de dirigeants et de bénévoles).
> Ne les exposez pas publiquement : voir [legal.md](../legal.md).

```php
$contacts = $ffbb->getClubContacts(10238);

$contacts->organisme->nom;               // OrganismesItem
$contacts->clubContact?->email;          // contact du club
foreach ($contacts->membres as $membre) { // ContactInfo : nom, prenom, email, telephone, role
    echo "{$membre->prenom} {$membre->nom} ({$membre->role})";
}

$equipe = $ffbb->getEngagementContacts($engagementId);
$equipe->correspondant;      // ContactInfo|null
$equipe->entraineur;         // ContactInfo|null
$equipe->entraineurAdjoint;  // ContactInfo|null
```
