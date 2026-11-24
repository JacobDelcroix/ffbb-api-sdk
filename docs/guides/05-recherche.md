# 05 — Recherche (Meilisearch)

Référence : [Recherche](../reference/recherche.md)

La FFBB expose un Meilisearch qui alimente la recherche de l'app. Il est plus rapide que Directus, accepte la
recherche floue et la géolocalisation, et reste souvent accessible quand Directus est bloqué par le WAF.

## Résultat d'une recherche

Chaque méthode `search*` renvoie un `SearchResult` (ou `null` sans texte recherché), dont les hits sont des
objets typés selon l'index :

```php
$resultat = $ffbb->searchOrganismes('Ostrevent');   // ?SearchResult<OrganismesHit>

$resultat->hits;                 // list<OrganismesHit>
$resultat->first()?->nom;        // premier hit
$resultat->estimatedTotalHits;   // nombre estimé (corrigé après le filtrage client)
$resultat->facet('type');        // ['Club' => 4210, 'Comité départemental' => 101, …]
$resultat->facetDistribution;    // toutes les facettes
$resultat->isEmpty();

foreach ($resultat->hits as $club) {
    echo $club->nom.' ('.$club->commune?->libelle.')'.PHP_EOL;
    $club->_geo?->lat;           // coordonnées GPS
}
```

Les DTOs de hits sont générés depuis les modèles du SDK Python, **complétés par les attributs réellement
observés** dans chaque index (par exemple `joue`, `resultatEquipe1` et `resultatEquipe2` sur les rencontres,
absents du modèle Python). Liste complète des propriétés : [référence DTOs](../reference/dtos.md#réponses-meilisearch-et-lives).

Comme dans le SDK Python, deux comportements à connaître :

1. **Filtrage côté client** : un hit n'est gardé que si le texte recherché apparaît vraiment dans un de ses
   champs « nom » (nom du club, commune, équipes…). La recherche floue de Meilisearch ne remonte donc pas de faux positifs.
2. **Pagination complète** : `limit` fixe la taille de la première page, mais **toutes** les pages suivantes
   sont récupérées (par 1000) jusqu'à `estimatedTotalHits`. Une recherche large peut donc renvoyer beaucoup de hits.

## Les 13 index

| Méthode | Index | Hits | Contenu |
|---|---|---|---|
| `searchOrganismes()` | `ffbbserver_organismes` | `OrganismesHit` | clubs, comités, ligues |
| `searchEngagements()` | `ffbbserver_engagements` | `EngagementsHit` | équipes engagées |
| `searchCompetitions()` | `ffbbserver_competitions` | `CompetitionsHit` | compétitions |
| `searchRencontres()` | `ffbbserver_rencontres` | `RencontresHit` | matchs (fenêtre glissante d'environ deux semaines) |
| `searchSalles()` | `ffbbserver_salles` | `SallesHit` | salles |
| `searchTerrains()` | `ffbbserver_terrains` | `TerrainsHit` | terrains extérieurs / 3x3 |
| `searchTournois()` | `ffbbserver_tournois` | `TournoisHit` | tournois |
| `searchPratiques()` | `ffbbnational_pratiques` | `PratiquesHit` | offres de pratique |
| `searchFormations()` | `ffbbserver_formations` | `FormationsHit` | formations |
| `searchNews()` | `ffbbsite_news` | `ContentHit` | actualités |
| `searchYoutubeVideos()` | `youtube_videos` | `ContentHit` | vidéos YouTube |
| `searchRss()` | `ffbbnational_rss` | `ContentHit` | flux RSS |
| `searchGaleries()` | `ffbbnational_galeries` | `ContentHit` | galeries photos |

Les index de contenu changent souvent de schéma côté FFBB : `ContentHit` type les champs communs (`id`, `title`,
`type`, `url`, `thumbnail`, `date`) et garde le reste dans `->raw` (`$hit->get('auteur')`).

Chacune existe aussi en version multiple (`searchMultipleOrganismes(['Douai', 'Lens'])`) : plusieurs recherches
dans un seul appel HTTP, un résultat par texte.

## Filtres et tri Meilisearch

Les filtres suivent la [syntaxe Meilisearch](https://www.meilisearch.com/docs/learn/filtering_and_sorting/filter_expression_reference) ;
plusieurs filtres dans le tableau sont combinés en ET.

```php
// Équipes féminines d'une catégorie (valeurs à vérifier dans facetDistribution)
$ffbb->searchEngagements('', filter: ['idCompetition.sexe = "F"', 'idCompetition.categorie.code = "U15"']);

// Rencontres organisées par un comité
$ffbb->searchRencontres('', filter: ['organisateur.nom = "COMITE DU NORD DE BASKET-BALL"']);
```

Seuls les attributs déclarés filtrables (ou triables) côté FFBB sont acceptés ; un filtre sur un autre champ
lève une `FfbbHttpException` (400). Les facettes ci-dessous sont filtrables ; pour découvrir les valeurs possibles,
lis `facetDistribution` dans un résultat.

Facettes demandées par défaut :

- organismes : `type_association.libelle`, `type`, `labellisation`, `offresPratiques`
- engagements : `clubPro`, `idCompetition.categorie.code`, `idCompetition.categorie.libelle`, `idCompetition.code`,
  `idCompetition.nom`, `idCompetition.sexe`, `idPoule.nom`, `niveau.code`, `niveau.libelle`
- rencontres : `competitionId.categorie.code`, `competitionId.typeCompetition`, `niveau`, `competitionId.sexe`,
  `organisateur.nom`, `organisateur.id`, `competitionId.nomExtended`
- tournois : `sexe`, `tournoiTypes3x3.libelle`, `tournoiType`

## Recherche géographique

```php
// Clubs à moins de 15 km, du plus proche au plus loin
$ffbb->searchOrganismesByGeo(lat: 50.30, lng: 3.21, radiusKm: 15);

// Salles autour d'un point, les plus lointaines d'abord
use CoachBasket\Ffbb\Search\GeoSortOrder;
$ffbb->searchSallesByGeo(50.30, 3.21, radiusKm: 5, geoSort: GeoSortOrder::FarthestFirst);

// Équipes à moins de 30 km, féminines ou mixtes, en pré-régionale ou départementale 2 seniors
// sexes : M, F, MI (traduits en Masculin / Féminin / Mixte, filtre sur idCompetition.sexe)
// niveauCodes : codes exacts de niveau.code (PRF, SED2F, U13R1M…), pas de code générique « DEP » / « REG »
$ffbb->searchEngagementsFiltered(50.30, 3.21, radiusKm: 30, sexes: ['F', 'MI'], niveauCodes: ['PRF', 'SED2F']);

// Clubs d'une commune (nom exact, insensible à la casse, filtre sur commune.libelle)
$ffbb->searchOrganismesByCity('Douai');
```

## Recherche universelle

```php
$resultats = $ffbb->multiSearch('Ostrevent');  // list<SearchResult>, un par index, dans l'ordre du tableau ci-dessus

foreach ($resultats as $resultat) {
    echo $resultat->indexUid.' : '.$resultat->count().' résultat(s)'.PHP_EOL;
}
```

## Requêtes sur mesure

Pour des paramètres que les méthodes n'exposent pas (offset, facettes choisies…), construis les requêtes
toi-même et passe-les au moteur de recherche. Il renvoie les tableaux Meilisearch : type-les avec `SearchResult::fromArray()`.

```php
use CoachBasket\Ffbb\Data\Models\SearchResult;
use CoachBasket\Ffbb\Search\Index;
use CoachBasket\Ffbb\Search\MultiSearchQuery;

$brut = $ffbb->search->recursiveSmartMultiSearch([
    new MultiSearchQuery(Index::Salles, q: 'gymnase', limit: 50, facets: ['commune.libelle']),
]);

$salles = SearchResult::fromArray($brut[0], Index::Salles->hitClass());   // SearchResult<SallesHit>

// Sans filtrage client ni pagination récursive : la réponse Meilisearch brute
$brut = $ffbb->search->multiSearch([MultiSearchQuery::for(Index::Organismes, 'Douai', limit: 5)]);
```
