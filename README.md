<div align="center">

# 🏀 FFBB API SDK pour PHP

### Client PHP non officiel pour les données de la Fédération Française de Basket-Ball, construit sur Saloon

**Clubs, équipes engagées, compétitions nationales, régionales et départementales, poules, classements, calendriers, résultats, salles, matchs en direct et recherche géographique : toutes les données de l'écosystème FFBB, typées et prêtes pour Laravel.**

*Portage PHP du SDK Python [`ffbb-data-client`](https://github.com/nickdesi/ffbb-data-client) de [nickdesi](https://github.com/nickdesi).*

<p align="center">
  <a href="https://github.com/JacobDelcroix/ffbb-api-sdk/actions/workflows/tests.yml"><img src="https://img.shields.io/github/actions/workflow/status/JacobDelcroix/ffbb-api-sdk/tests.yml?branch=main&label=tests&logo=github&style=for-the-badge" alt="Tests" /></a>
  <img src="https://img.shields.io/badge/PHP-8.3%20%7C%208.4%20%7C%208.5-777BB4?logo=php&logoColor=white&style=for-the-badge" alt="PHP 8.3+" />
  <a href="https://docs.saloon.dev"><img src="https://img.shields.io/badge/Saloon-v4-ff6b00?style=for-the-badge" alt="Saloon v4" /></a>
</p>

<p align="center">
  <a href="https://packagist.org/packages/jacobdelcroix/ffbb-api-sdk"><img src="https://img.shields.io/packagist/v/jacobdelcroix/ffbb-api-sdk?style=flat-square&label=Packagist" alt="Version Packagist" /></a>
  <a href="https://packagist.org/packages/jacobdelcroix/ffbb-api-sdk"><img src="https://img.shields.io/packagist/dt/jacobdelcroix/ffbb-api-sdk?style=flat-square" alt="Téléchargements" /></a>
  <a href="LICENSE"><img src="https://img.shields.io/badge/Licence-Apache--2.0-blue.svg?style=flat-square" alt="Licence Apache-2.0" /></a>
  <img src="https://img.shields.io/badge/Laravel-prêt-FF2D20?logo=laravel&logoColor=white&style=flat-square" alt="Laravel" />
  <img src="https://img.shields.io/badge/Tests-Pest-F28D1A?style=flat-square" alt="Pest" />
  <a href="https://github.com/nickdesi/ffbb-data-client"><img src="https://img.shields.io/badge/Python-ffbb--data--client-3776AB?logo=python&logoColor=white&style=flat-square" alt="Projet d'origine" /></a>
</p>

[⚡ Démarrage](#-démarrage-rapide) •
[🏆 Fonctionnalités](#-pourquoi-ce-sdk-) •
[🔥 Exemples](#-exemples) •
[📚 Documentation](#-documentation) •
[🔄 Mises à jour](#-rester-à-jour-automatiquement) •
[🙏 Crédits](#-crédits)

</div>

> [!WARNING]
> **SDK non officiel.** Il interroge les mêmes services que l'application mobile FFBB (API Directus
> `api.ffbb.com` et moteur Meilisearch), en reprenant ses en-têtes et ses jetons publics. La FFBB peut
> changer ses jetons, son pare-feu ou son schéma à tout moment. Lis [docs/legal.md](docs/legal.md)
> avant tout usage public ou commercial.

---

## 🏆 Pourquoi ce SDK ?

| Fonctionnalité | |
| :--- | :---: |
| **Parité avec le SDK Python** : les 107 méthodes publiques de `ffbb-data-client`, vérifiées par des tests | ✅ |
| **Connexion sans configuration** : jetons récupérés comme l'app mobile, avec repli sur plusieurs hôtes | ✅ |
| **Résilience face au WAF BunnyCDN** : rotation de User-Agent, retry exponentiel, reconstruction via Meilisearch | ✅ |
| **Query builder Directus complet** : `fields`, `filter`, `sort`, `search`, `deep`, `aggregate`, `groupBy`, `meta` | ✅ |
| **Réponses 100 % typées** : 68 DTOs Directus (spec OpenAPI) et 46 DTOs Meilisearch / lives, dates en `DateTimeImmutable` | ✅ |
| **Recherche Meilisearch** : 13 index, filtres, rayon GPS, recherche universelle | ✅ |
| **Pagination automatique** : listes complètes ou générateurs page par page | ✅ |
| **Cache PSR-16** : réponses, recherches et jetons ; branché sur le cache Laravel | ✅ |
| **Intégration Laravel** : service provider, façade `Ffbb`, config publiable | ✅ |
| **Mise à jour continue** : détection quotidienne des changements FFBB et du SDK Python, avec PR automatique | ✅ |

---

## 📦 Installation

```bash
composer require jacobdelcroix/ffbb-api-sdk
```

PHP 8.3+. En Laravel, le service provider est découvert automatiquement :

```bash
php artisan vendor:publish --tag=ffbb-config
```

---

## ⚡ Démarrage rapide

Aucun compte ni clé d'API à créer : `FfbbDataClient::create()` récupère et renouvelle seul les jetons publics.

```php
use CoachBasket\Ffbb\FfbbDataClient;

$ffbb = FfbbDataClient::create();

// 1. Trouver un club
$club = $ffbb->searchOrganismes('Ostrevent')->first();   // OrganismesHit
$club->id;    // '10238'
$club->code;  // 'HDF0059038'

// 2. Ses équipes engagées
foreach ($ffbb->getEquipes((int) $club->id) as $equipe) {   // EngagementsItem
    echo $equipe->competition?->nom.' — '.$equipe->poule?->nom.PHP_EOL;
}

// 3. Le classement et les matchs d'une poule
$classement = $ffbb->getClassement(900);           // list<PoulesClassementsItem>
$rencontres = $ffbb->listRencontresByPoule(900);   // list<RencontresItem>
```

Avec Laravel :

```php
use CoachBasket\Ffbb\Laravel\Facades\Ffbb;

$club = Ffbb::getOrganisme(10238);   // ?OrganismesItem
```

Toutes les méthodes renvoient des **objets typés** : l'IDE complète les propriétés, PHPStan vérifie les types,
les dates sont des `DateTimeImmutable` et les relations des objets au nom naturel (`$equipe->poule->nom`, champ
Directus `idPoule`). La réponse brute reste accessible via `->raw` / `toArray()`.

---

## 🔥 Exemples

### 📍 Clubs autour d'un point GPS

```php
$clubs = $ffbb->searchOrganismesByGeo(lat: 50.30, lng: 3.21, radiusKm: 15);

foreach ($clubs->hits as $club) {   // OrganismesHit
    echo $club->nom.' ('.$club->commune?->libelle.')'.PHP_EOL;
}
```

### 🎯 Équipes féminines départementales ou régionales autour de chez soi

```php
$equipes = $ffbb->searchEngagementsFiltered(50.30, 3.21, radiusKm: 30, sexes: ['F'], niveauCodes: ['DEP', 'REG']);
```

### 📅 Derniers résultats d'un club

```php
use CoachBasket\Ffbb\Data\RencontresItem;

$resultats = $ffbb->directus(RencontresItem::class)
    ->fields(['date_rencontre', 'nomEquipe1', 'nomEquipe2', 'resultatEquipe1', 'resultatEquipe2', 'idPoule.nom'])
    ->filter(['_or' => [
        ['idOrganismeEquipe1' => ['_eq' => 10238]],
        ['idOrganismeEquipe2' => ['_eq' => 10238]],
    ]])
    ->where('joue', '_eq', true)
    ->sort('-date_rencontre')
    ->limit(10)
    ->get();   // list<RencontresItem>

foreach ($resultats as $match) {
    echo $match->date_rencontre?->format('d/m')." {$match->nomEquipe1} {$match->resultatEquipe1}-{$match->resultatEquipe2} {$match->nomEquipe2}".PHP_EOL;
}
```

### 🏅 Classement formaté

```php
foreach ($ffbb->getClassement(900) ?? [] as $ligne) {
    printf("%d. %s — %d pts (%d V / %d D)\n", $ligne->position, $ligne->engagement?->nom, $ligne->points, $ligne->gagnes, $ligne->perdus);
}
```

### 📺 Matchs en direct

```php
foreach ($ffbb->getLives() ?? [] as $live) {   // Live
    echo "{$live->teamName_home} {$live->score_home} - {$live->score_out} {$live->teamName_out}".PHP_EOL;
}
```

### 🧵 Gros volumes, page par page

```php
foreach ($ffbb->iterAllSalles(filterCriteria: '{"commune":{"codePostal":{"_starts_with":"59"}}}', pageSize: 200) as $salle) {
    echo $salle->libelle.PHP_EOL;   // SallesItem, une page en mémoire à la fois
}
```

---

## 📚 Documentation

| | |
|---|---|
| 📖 **[Guides](docs/guides/README.md)** | Exemples commentés par thème : clubs, compétitions et classements, rencontres, recherche, query builder, DTOs, erreurs et cache, Laravel |
| 🗂️ **[Référence API](docs/reference/README.md)** | Toutes les méthodes, paramètres et types, regroupés par type de données (générée depuis le code) |
| 🔄 **[Maintenance](docs/maintenance.md)** | Comment le SDK suit les changements de la FFBB et du SDK Python |
| ⚖️ **[Cadre juridique](docs/legal.md)** | Droits de la FFBB, données personnelles, usages à risque |

### Fonctionnement en bref

| | |
|---|---|
| **Directus** `https://api.ffbb.com/` | collections `items/ffbbserver_*`, lives, spec OpenAPI |
| **Meilisearch** `https://meilisearch-prod.ffbb.app/` | recherche plein texte et géographique |
| **Jetons** | explicites → variables d'environnement → cache → `items/configuration` (4 hôtes × 4 User-Agents) → jetons publics de repli |
| **Retry** | 3 essais, backoff exponentiel ; User-Agent suivant sur 403 BunnyCDN ; jetons rafraîchis sur 401 |
| **Repli** | `getOrganisme`, `getCompetition`, `getPoule` reconstruisent les données depuis Meilisearch si Directus est bloqué |
| **Cache** | Directus 30 min, Meilisearch 5 min, jetons 6 h |

### Correspondance avec le SDK Python

Chaque méthode publique synchrone de `FFBBDataClient` existe en camelCase : `get_organisme` → `getOrganisme()`,
`search_organismes_by_geo` → `searchOrganismesByGeo()`. `aiter_all_x` devient le générateur `iterAllX()` ;
les variantes `*_async` ne sont pas portées. Comme en Python, les réponses sont des objets typés
(`OrganismesHit`, `Live`…), ici enrichis des attributs que les modèles Python ne décrivent pas. La table complète figure dans la [référence](docs/reference/README.md)
(« Équivalent Python » sur chaque méthode), et `tests/Unit/UpstreamParityTest.php` vérifie la correspondance.

---

## 🔄 Rester à jour automatiquement

Deux workflows GitHub tournent chaque jour et ouvrent une PR quand quelque chose change :

1. **Découverte FFBB** (`ffbb-discovery.yml`) : compare la spec OpenAPI de Directus et les attributs des index
   Meilisearch aux instantanés de `resources/discovery/`, **régénère les DTOs** et signale les changements cassants.
2. **Synchronisation Python** (`upstream-sync.yml`) : lit le code de `ffbb-data-client` sans l'exécuter
   (constantes, méthodes, listes de champs). Les tests de parité montrent ce qu'il reste à porter, et Claude Code
   peut proposer le portage dans la même PR.

Détails : [docs/maintenance.md](docs/maintenance.md).

---

## 🧪 Développement

```bash
composer install
composer test            # Pest, aucune requête réelle
composer lint            # Pint
composer docs            # régénère docs/reference
composer dtos            # régénère src/Data depuis la spec OpenAPI
php bin/discover --dry-run
```

Contributions bienvenues : fork, branche, `composer test`, puis Pull Request.

---

## 🙏 Crédits

- **[Fédération Française de Basket-Ball](https://www.ffbb.com)** : toutes les données exposées par ce SDK
  (clubs, compétitions, rencontres, classements, salles…) sont produites et publiées par la FFBB, ses ligues,
  ses comités et ses clubs. « FFBB » et « Fédération Française de Basket-Ball » sont des marques de leurs
  titulaires. Ce projet n'est ni affilié à la FFBB, ni approuvé par elle.
- **[nickdesi/ffbb-data-client](https://github.com/nickdesi/ffbb-data-client)** : ce SDK est le portage PHP
  de ce projet Python. La cartographie de l'API, les jeux de champs Directus, les User-Agents, les mécanismes de
  repli, les modèles de réponse et les instantanés de schéma de départ viennent de son travail. Si ce SDK te sert, pense à lui mettre une
  ⭐ aussi.
- **[Saloon](https://github.com/saloonphp/saloon)** de Sam Carré, pour la couche HTTP.

---

## 📄 Licence

Distribué sous licence **Apache-2.0**, comme le projet d'origine. Voir [LICENSE](LICENSE) et [NOTICE](NOTICE).

<div align="center">

**Fait pour la communauté du basket français 🇫🇷🏀**

</div>
