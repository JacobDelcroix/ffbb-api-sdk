<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# DTOs

Classes générées par `bin/generate-dtos` depuis la spec OpenAPI Directus (`resources/discovery/openapi.json`).
Toutes les propriétés sont nullables. Une relation vaut l'objet DTO quand Directus la développe (`fields=relation.*`), sinon son identifiant. `$raw` conserve la réponse complète.

```php
use CoachBasket\Ffbb\Data\RencontresItem;

$rencontre = RencontresItem::fromArray($ffbb->getRencontre($id));
$liste = RencontresItem::collect($ffbb->listRencontresByPoule(900));
```

Guide avec exemples : [07-dtos](../guides/07-dtos.md)

| Collection Directus | DTO | Propriétés |
|---|---|---|
| `ffbbnational_categories` | [`CategoriesItem`](#categoriesitem) | 4 |
| `ffbbnational_galeries` | [`GaleriesItem`](#galeriesitem) | 10 |
| `ffbbnational_galeries_ffbbnational_tags` | [`GaleriesFfbbnationalTagsItem`](#galeriesffbbnationaltagsitem) | 3 |
| `ffbbnational_galeries_files` | [`GaleriesFilesItem`](#galeriesfilesitem) | 3 |
| `ffbbnational_pratiques` | [`PratiquesItem`](#pratiquesitem) | 45 |
| `ffbbnational_rss` | [`RssItem`](#rssitem) | 19 |
| `ffbbnational_rss_ffbbnational_categories` | [`RssFfbbnationalCategoriesItem`](#rssffbbnationalcategoriesitem) | 3 |
| `ffbbnational_rss_ffbbnational_tags` | [`RssFfbbnationalTagsItem`](#rssffbbnationaltagsitem) | 3 |
| `ffbbnational_tags` | [`TagsItem`](#tagsitem) | 4 |
| `ffbbserver_cartographies` | [`CartographiesItem`](#cartographiesitem) | 11 |
| `ffbbserver_categories_age` | [`CategoriesAgeItem`](#categoriesageitem) | 8 |
| `ffbbserver_categories_championnats` | [`CategoriesChampionnatsItem`](#categorieschampionnatsitem) | 6 |
| `ffbbserver_communes` | [`CommunesItem`](#communesitem) | 7 |
| `ffbbserver_competitions` | [`CompetitionsItem`](#competitionsitem) | 29 |
| `ffbbserver_engagements` | [`EngagementsItem`](#engagementsitem) | 43 |
| `ffbbserver_entraineurs` | [`EntraineursItem`](#entraineursitem) | 8 |
| `ffbbserver_fonctions_officiels` | [`FonctionsOfficielsItem`](#fonctionsofficielsitem) | 13 |
| `ffbbserver_formations` | [`FormationsItem`](#formationsitem) | 29 |
| `ffbbserver_formations_domain` | [`FormationsDomainItem`](#formationsdomainitem) | 3 |
| `ffbbserver_formations_files` | [`FormationsFilesItem`](#formationsfilesitem) | 3 |
| `ffbbserver_formations_theme` | [`FormationsThemeItem`](#formationsthemeitem) | 3 |
| `ffbbserver_labellisation_label` | [`LabellisationLabelItem`](#labellisationlabelitem) | 4 |
| `ffbbserver_labellisation_programme` | [`LabellisationProgrammeItem`](#labellisationprogrammeitem) | 19 |
| `ffbbserver_labellisations_organismes` | [`LabellisationsOrganismesItem`](#labellisationsorganismesitem) | 7 |
| `ffbbserver_membres` | [`MembresItem`](#membresitem) | 17 |
| `ffbbserver_officiels` | [`OfficielsItem`](#officielsitem) | 5 |
| `ffbbserver_officiels_rencontres` | [`OfficielsRencontresItem`](#officielsrencontresitem) | 10 |
| `ffbbserver_offres_pratiques` | [`OffresPratiquesItem`](#offrespratiquesitem) | 6 |
| `ffbbserver_organismes` | [`OrganismesItem`](#organismesitem) | 35 |
| `ffbbserver_organismes_ffbbserver_offres_pratiques` | [`OrganismesFfbbserverOffresPratiquesItem`](#organismesffbbserveroffrespratiquesitem) | 3 |
| `ffbbserver_organismes_ffbbserver_organismes` | [`OrganismesFfbbserverOrganismesItem`](#organismesffbbserverorganismesitem) | 3 |
| `ffbbserver_poules` | [`PoulesItem`](#poulesitem) | 8 |
| `ffbbserver_poules_classements` | [`PoulesClassementsItem`](#poulesclassementsitem) | 28 |
| `ffbbserver_rencontres` | [`RencontresItem`](#rencontresitem) | 43 |
| `ffbbserver_revetements` | [`RevetementsItem`](#revetementsitem) | 6 |
| `ffbbserver_saisons` | [`SaisonsItem`](#saisonsitem) | 9 |
| `ffbbserver_salles` | [`SallesItem`](#sallesitem) | 13 |
| `ffbbserver_sessions` | [`SessionsItem`](#sessionsitem) | 17 |
| `ffbbserver_terrains` | [`TerrainsItem`](#terrainsitem) | 12 |
| `ffbbserver_tournois` | [`TournoisItem`](#tournoisitem) | 27 |
| `ffbbserver_tournois_ffbbserver_types_tournois3x3` | [`TournoisFfbbserverTypesTournois3x3Item`](#tournoisffbbservertypestournois3x3item) | 3 |
| `ffbbserver_types_associations` | [`TypesAssociationsItem`](#typesassociationsitem) | 8 |
| `ffbbserver_types_competitions` | [`TypesCompetitionsItem`](#typescompetitionsitem) | 4 |
| `ffbbserver_types_divisions` | [`TypesDivisionsItem`](#typesdivisionsitem) | 10 |
| `ffbbserver_types_pratiques_sportives` | [`TypesPratiquesSportivesItem`](#typespratiquessportivesitem) | 5 |
| `ffbbserver_types_tournois` | [`TypesTournoisItem`](#typestournoisitem) | 6 |
| `ffbbserver_types_tournois3x3` | [`TypesTournois3x3Item`](#typestournois3x3item) | 8 |

## CategoriesItem

Collection `ffbbnational_categories`.

| Propriété | Type |
|---|---|
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `title` | `?string` |

## GaleriesItem

Collection `ffbbnational_galeries`.

| Propriété | Type |
|---|---|
| `cover` | `mixed` |
| `creator` | `?string` |
| `date` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?int` |
| `images` | `?array` |
| `surtitle` | `?string` |
| `tags` | `?array` |
| `title` | `?string` |

## GaleriesFfbbnationalTagsItem

Collection `ffbbnational_galeries_ffbbnational_tags`.

| Propriété | Type |
|---|---|
| `ffbbnational_galeries_id` | `GaleriesItem\|int\|string\|null` |
| `ffbbnational_tags_id` | `TagsItem\|int\|string\|null` |
| `id` | `?int` |

## GaleriesFilesItem

Collection `ffbbnational_galeries_files`.

| Propriété | Type |
|---|---|
| `directus_files_id` | `mixed` |
| `ffbbnational_galeries_id` | `GaleriesItem\|int\|string\|null` |
| `id` | `?int` |

## PratiquesItem

Collection `ffbbnational_pratiques`.

| Propriété | Type |
|---|---|
| `action` | `?string` |
| `adresse` | `?string` |
| `adresse_salle` | `?string` |
| `adresse_structure` | `?string` |
| `affiche` | `mixed` |
| `affiche_externe` | `?string` |
| `assurance` | `?string` |
| `cartographie` | `CartographiesItem\|int\|string\|null` |
| `code` | `?string` |
| `code_structure` | `?string` |
| `cp_salle` | `?string` |
| `date_created` | `?string` |
| `date_debut` | `?string` |
| `date_demande` | `?int` |
| `date_fin` | `?string` |
| `date_inscription` | `?string` |
| `date_updated` | `?string` |
| `date_validation_ffbb` | `?string` |
| `description` | `?string` |
| `email` | `?string` |
| `engagement` | `?string` |
| `facebook` | `?string` |
| `horaires_seances` | `?string` |
| `id` | `?string` |
| `inscriptions` | `?string` |
| `jours` | `mixed` |
| `label` | `?string` |
| `latitude` | `?float` |
| `longitude` | `?float` |
| `mail_demandeur` | `?string` |
| `mail_structure` | `?string` |
| `nom_demandeur` | `?string` |
| `nom_salle` | `?string` |
| `nom_structure` | `?string` |
| `nombre_personnes` | `?string` |
| `nombre_seances` | `?string` |
| `objectif` | `?string` |
| `prenom_demandeur` | `?string` |
| `public` | `?string` |
| `site_web` | `?string` |
| `telephone` | `?string` |
| `titre` | `?string` |
| `twitter` | `?string` |
| `type` | `?string` |
| `ville_salle` | `?string` |

## RssItem

Collection `ffbbnational_rss`.

| Propriété | Type |
|---|---|
| `categories` | `?array` |
| `chapo` | `?string` |
| `cover` | `mixed` |
| `creator` | `?string` |
| `date` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `highlight` | `?bool` |
| `id` | `?string` |
| `img` | `?string` |
| `img_credits` | `?string` |
| `img_legend` | `?string` |
| `link` | `?string` |
| `match_id` | `?string` |
| `surtitle` | `?string` |
| `tags` | `?array` |
| `text` | `mixed` |
| `texte` | `?string` |
| `title` | `?string` |

## RssFfbbnationalCategoriesItem

Collection `ffbbnational_rss_ffbbnational_categories`.

| Propriété | Type |
|---|---|
| `ffbbnational_categories_id` | `CategoriesItem\|int\|string\|null` |
| `ffbbnational_rss_id` | `RssItem\|int\|string\|null` |
| `id` | `?int` |

## RssFfbbnationalTagsItem

Collection `ffbbnational_rss_ffbbnational_tags`.

| Propriété | Type |
|---|---|
| `ffbbnational_rss_id` | `RssItem\|int\|string\|null` |
| `ffbbnational_tags_id` | `TagsItem\|int\|string\|null` |
| `id` | `?int` |

## TagsItem

Collection `ffbbnational_tags`.

| Propriété | Type |
|---|---|
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `title` | `?string` |

## CartographiesItem

Collection `ffbbserver_cartographies`.

| Propriété | Type |
|---|---|
| `adresse` | `?string` |
| `codePostal` | `?string` |
| `coordonnees` | `mixed` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `latitude` | `?float` |
| `longitude` | `?float` |
| `status` | `?string` |
| `title` | `?string` |
| `ville` | `?string` |

## CategoriesAgeItem

Collection `ffbbserver_categories_age`.

| Propriété | Type |
|---|---|
| `ageMaxi` | `?int` |
| `ageMini` | `?int` |
| `code` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `libelle` | `?string` |
| `sexe` | `?string` |

## CategoriesChampionnatsItem

Collection `ffbbserver_categories_championnats`.

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `libelle` | `?string` |
| `ordre` | `?int` |

## CommunesItem

Collection `ffbbserver_communes`.

| Propriété | Type |
|---|---|
| `codeInsee` | `?string` |
| `codePostal` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `departement` | `?string` |
| `id` | `?string` |
| `libelle` | `?string` |

## CompetitionsItem

Collection `ffbbserver_competitions`.

| Propriété | Type |
|---|---|
| `categorie` | `CategoriesChampionnatsItem\|int\|string\|null` |
| `code` | `?string` |
| `compare_old_site` | `?bool` |
| `competition_origine` | `int\|self\|string\|null` |
| `competition_origine_niveau` | `?int` |
| `competition_origine_nom` | `?string` |
| `creationEnCours` | `?bool` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `emarqueV2` | `?bool` |
| `etat` | `?string` |
| `id` | `?string` |
| `idCompetitionPere` | `int\|self\|string\|null` |
| `liveStat` | `?bool` |
| `logo` | `mixed` |
| `nom` | `?string` |
| `ordre` | `?int` |
| `organisateur` | `OrganismesItem\|int\|string\|null` |
| `phase_code` | `?string` |
| `phases` | `?array` |
| `poules` | `?array` |
| `pro` | `?bool` |
| `publicationInternet` | `?string` |
| `saison` | `SaisonsItem\|int\|string\|null` |
| `sexe` | `?string` |
| `slug` | `?string` |
| `toUpdate` | `?bool` |
| `typeCompetition` | `?string` |
| `typeCompetitionGenerique` | `TypesCompetitionsItem\|int\|string\|null` |

## EngagementsItem

Collection `ffbbserver_engagements`.

| Propriété | Type |
|---|---|
| `adresseCorrespondantEquipe` | `?string` |
| `classement` | `?array` |
| `clubPro` | `?bool` |
| `codeAbrege` | `?string` |
| `communeCorrespondantEquipe` | `?string` |
| `complementAdresseCorrespondantEquipe` | `?string` |
| `creation` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `emailCorrespondantEquipe` | `?string` |
| `entraineur` | `EntraineursItem\|int\|string\|null` |
| `entraineurAdjoint` | `EntraineursItem\|int\|string\|null` |
| `forfaitGeneral` | `?bool` |
| `id` | `?string` |
| `idCompetition` | `CompetitionsItem\|int\|string\|null` |
| `idOrganisme` | `OrganismesItem\|int\|string\|null` |
| `idOrganismeCtc` | `OrganismesItem\|int\|string\|null` |
| `idPoule` | `PoulesItem\|int\|string\|null` |
| `logo` | `mixed` |
| `logo_genius` | `?string` |
| `modification` | `?string` |
| `niveau` | `TypesDivisionsItem\|int\|string\|null` |
| `nom` | `?string` |
| `nomCorrespondantEquipe` | `?string` |
| `nomCtc` | `?string` |
| `nomEquipe` | `?string` |
| `nomOfficiel` | `?string` |
| `nomUsuel` | `?string` |
| `numeroEquipe` | `?string` |
| `photo` | `?string` |
| `position` | `?int` |
| `positionVariation` | `?int` |
| `position_n1` | `?int` |
| `positions` | `mixed` |
| `pouleId` | `?string` |
| `rencontres_domiciles` | `?array` |
| `rencontres_exterieur` | `?array` |
| `telephoneFixeCorrespondantEquipe` | `?string` |
| `telephonePortableCorrespondantEquipe` | `?string` |
| `telephoneTravailCorrespondantEquipe` | `?string` |
| `toUpdate` | `?bool` |
| `typeEntenteCtc` | `?string` |
| `url_competition` | `?string` |

## EntraineursItem

Collection `ffbbserver_entraineurs`.

| Propriété | Type |
|---|---|
| `adresse1` | `?string` |
| `adresse2` | `?string` |
| `commune` | `CommunesItem\|int\|string\|null` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `idLicence` | `?string` |
| `nom` | `?string` |
| `prenom` | `?string` |

## FonctionsOfficielsItem

Collection `ffbbserver_fonctions_officiels`.

| Propriété | Type |
|---|---|
| `afficher` | `?bool` |
| `attribuer` | `?bool` |
| `certificatMedical` | `?bool` |
| `code` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `designation` | `?bool` |
| `emarque` | `?bool` |
| `id` | `?string` |
| `libelle` | `?string` |
| `niveau` | `?string` |
| `ordre` | `?int` |
| `repartitionClub` | `?bool` |

## FormationsItem

Collection `ffbbserver_formations`.

| Propriété | Type |
|---|---|
| `certification` | `?string` |
| `content` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `description` | `?string` |
| `domain` | `FormationsDomainItem\|int\|string\|null` |
| `duration_hours` | `?string` |
| `files` | `?array` |
| `goals` | `?string` |
| `id` | `?string` |
| `idOrigin` | `?string` |
| `idOriginHash` | `?string` |
| `image` | `mixed` |
| `level` | `?string` |
| `modalities` | `?string` |
| `mode` | `?string` |
| `pedagogy` | `?string` |
| `prerequisites` | `?string` |
| `programIdFbi` | `?string` |
| `public` | `?string` |
| `reference` | `?string` |
| `results` | `?string` |
| `sessions` | `?array` |
| `sort` | `?int` |
| `status` | `?string` |
| `theme` | `FormationsThemeItem\|int\|string\|null` |
| `title` | `?string` |
| `user_created` | `?string` |
| `user_updated` | `?string` |

## FormationsDomainItem

Collection `ffbbserver_formations_domain`.

| Propriété | Type |
|---|---|
| `id` | `?string` |
| `name` | `?string` |
| `sort` | `?int` |

## FormationsFilesItem

Collection `ffbbserver_formations_files`.

| Propriété | Type |
|---|---|
| `directus_files_id` | `mixed` |
| `ffbbserver_formations_id` | `FormationsItem\|int\|string\|null` |
| `id` | `?int` |

## FormationsThemeItem

Collection `ffbbserver_formations_theme`.

| Propriété | Type |
|---|---|
| `id` | `?string` |
| `name` | `?string` |
| `sort` | `?int` |

## LabellisationLabelItem

Collection `ffbbserver_labellisation_label`.

| Propriété | Type |
|---|---|
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `libelle` | `?string` |

## LabellisationProgrammeItem

Collection `ffbbserver_labellisation_programme`.

| Propriété | Type |
|---|---|
| `affiche` | `?string` |
| `code` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `decouverte` | `?bool` |
| `demandeLabel` | `?bool` |
| `engagement` | `?string` |
| `id` | `?string` |
| `labellisationLabel` | `LabellisationLabelItem\|int\|string\|null` |
| `libelle` | `?string` |
| `licence` | `?bool` |
| `lienHelloassoInitial` | `?string` |
| `lienHelloassoRenouvellement` | `?string` |
| `logo` | `?string` |
| `logo_horizontal` | `mixed` |
| `logo_vertical` | `mixed` |
| `montantInitial` | `?int` |
| `montantRenouvellement` | `?int` |
| `paiement` | `?bool` |

## LabellisationsOrganismesItem

Collection `ffbbserver_labellisations_organismes`.

| Propriété | Type |
|---|---|
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `debut` | `?string` |
| `fin` | `?string` |
| `id` | `?string` |
| `idLabellisationProgramme` | `LabellisationProgrammeItem\|int\|string\|null` |
| `idOrganisme` | `OrganismesItem\|int\|string\|null` |

## MembresItem

Collection `ffbbserver_membres`.

| Propriété | Type |
|---|---|
| `accordDiffusionSiteWeb` | `?bool` |
| `adresse1` | `?string` |
| `adresse2` | `?string` |
| `codeFonction` | `?string` |
| `codePostal` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `idLicence` | `?string` |
| `idOrganisme` | `OrganismesItem\|int\|string\|null` |
| `libelleFonction` | `?string` |
| `mail` | `?string` |
| `nom` | `?string` |
| `prenom` | `?string` |
| `telephoneFixe` | `?string` |
| `telephonePortable` | `?string` |
| `ville` | `?string` |

## OfficielsItem

Collection `ffbbserver_officiels`.

| Propriété | Type |
|---|---|
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `nom` | `?string` |
| `numeroNational` | `?string` |
| `prenom` | `?string` |

## OfficielsRencontresItem

Collection `ffbbserver_officiels_rencontres`.

| Propriété | Type |
|---|---|
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `distanceKm` | `?float` |
| `fonction` | `FonctionsOfficielsItem\|int\|string\|null` |
| `id` | `?string` |
| `indemnite` | `?float` |
| `officiel` | `OfficielsItem\|int\|string\|null` |
| `ordre` | `?int` |
| `presence` | `?string` |
| `rencontre` | `RencontresItem\|int\|string\|null` |

## OffresPratiquesItem

Collection `ffbbserver_offres_pratiques`.

| Propriété | Type |
|---|---|
| `categoriePratique` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `title` | `?string` |
| `typePratique` | `?string` |

## OrganismesItem

Collection `ffbbserver_organismes`.

| Propriété | Type |
|---|---|
| `adresse` | `?string` |
| `adresseClubPro` | `?string` |
| `cartographie` | `CartographiesItem\|int\|string\|null` |
| `code` | `?string` |
| `commune` | `CommunesItem\|int\|string\|null` |
| `communeClubPro` | `CommunesItem\|int\|string\|null` |
| `competitions` | `?array` |
| `dateAffiliation` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `engagements` | `?array` |
| `entreprise` | `?bool` |
| `handibasket` | `?bool` |
| `horsAssociation` | `?bool` |
| `id` | `?string` |
| `labellisation` | `?array` |
| `logo` | `mixed` |
| `logo_base64` | `?string` |
| `mail` | `?string` |
| `membres` | `?array` |
| `nom` | `?string` |
| `nomClubPro` | `?string` |
| `nom_simple` | `?string` |
| `offresPratiques` | `?array` |
| `omnisport` | `?bool` |
| `organisme_id_pere` | `int\|self\|string\|null` |
| `organismes_fils` | `?array` |
| `saison` | `?string` |
| `saison_en_cours` | `?bool` |
| `salle` | `SallesItem\|int\|string\|null` |
| `telephone` | `?string` |
| `type` | `?string` |
| `type_association` | `TypesAssociationsItem\|int\|string\|null` |
| `urlSiteWeb` | `?string` |
| `url_competition` | `?string` |

## OrganismesFfbbserverOffresPratiquesItem

Collection `ffbbserver_organismes_ffbbserver_offres_pratiques`.

| Propriété | Type |
|---|---|
| `ffbbserver_offres_pratiques_id` | `OffresPratiquesItem\|int\|string\|null` |
| `ffbbserver_organismes_id` | `OrganismesItem\|int\|string\|null` |
| `id` | `?int` |

## OrganismesFfbbserverOrganismesItem

Collection `ffbbserver_organismes_ffbbserver_organismes`.

| Propriété | Type |
|---|---|
| `ffbbserver_organismes_id` | `OrganismesItem\|int\|string\|null` |
| `id` | `?int` |
| `related_ffbbserver_organismes_id` | `OrganismesItem\|int\|string\|null` |

## PoulesItem

Collection `ffbbserver_poules`.

| Propriété | Type |
|---|---|
| `classements` | `?array` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `engagements` | `?array` |
| `id` | `?string` |
| `id_competition` | `CompetitionsItem\|int\|string\|null` |
| `nom` | `?string` |
| `rencontres` | `?array` |

## PoulesClassementsItem

Collection `ffbbserver_poules_classements`.

| Propriété | Type |
|---|---|
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `difference` | `?int` |
| `gagnes` | `?int` |
| `horsClassement` | `?bool` |
| `id` | `?string` |
| `idCompetition` | `CompetitionsItem\|int\|string\|null` |
| `idEngagement` | `EngagementsItem\|int\|string\|null` |
| `idPoule` | `PoulesItem\|int\|string\|null` |
| `matchJoues` | `?int` |
| `match_joues` | `?int` |
| `nombreDefauts` | `?int` |
| `nombreForfaits` | `?int` |
| `nuls` | `?int` |
| `organisme` | `OrganismesItem\|int\|string\|null` |
| `organisme_nom` | `?string` |
| `paniersEncaisses` | `?int` |
| `paniersMarques` | `?int` |
| `penalites` | `?int` |
| `penalitesArbitrage` | `?int` |
| `penalitesDiverses` | `?int` |
| `penalitesEntraineur` | `?int` |
| `perdus` | `?int` |
| `pointInitiaux` | `?int` |
| `points` | `?int` |
| `pointsInitiaux` | `?int` |
| `position` | `?int` |
| `quotient` | `?float` |

## RencontresItem

Collection `ffbbserver_rencontres`.

| Propriété | Type |
|---|---|
| `competitionId` | `CompetitionsItem\|int\|string\|null` |
| `creation` | `?string` |
| `date` | `?string` |
| `dateSaisieResultat` | `?string` |
| `date_created` | `?string` |
| `date_rencontre` | `?string` |
| `date_updated` | `?string` |
| `defautEquipe1` | `?bool` |
| `defautEquipe2` | `?bool` |
| `etat` | `?string` |
| `forfaitEquipe1` | `?bool` |
| `forfaitEquipe2` | `?bool` |
| `gsId` | `mixed` |
| `handicap1` | `?int` |
| `handicap2` | `?int` |
| `horaire` | `?int` |
| `id` | `?string` |
| `idEngagementEquipe1` | `EngagementsItem\|int\|string\|null` |
| `idEngagementEquipe2` | `EngagementsItem\|int\|string\|null` |
| `idOrganismeEquipe1` | `OrganismesItem\|int\|string\|null` |
| `idOrganismeEquipe2` | `OrganismesItem\|int\|string\|null` |
| `idPoule` | `PoulesItem\|int\|string\|null` |
| `joue` | `?bool` |
| `modification` | `?string` |
| `nomEquipe1` | `?string` |
| `nomEquipe2` | `?string` |
| `numero` | `?int` |
| `numeroJournee` | `?string` |
| `officiels` | `?array` |
| `penaliteEquipe1` | `?bool` |
| `penaliteEquipe2` | `?bool` |
| `pratique` | `?string` |
| `rematch_videos` | `?array` |
| `remise` | `?bool` |
| `resultatEquipe1` | `?int` |
| `resultatEquipe2` | `?int` |
| `saison` | `SaisonsItem\|int\|string\|null` |
| `salle` | `SallesItem\|int\|string\|null` |
| `status` | `?string` |
| `toUpdate` | `?bool` |
| `uniqueKey` | `?string` |
| `url_competition` | `?string` |
| `validee` | `?bool` |

## RevetementsItem

Collection `ffbbserver_revetements`.

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `libelle` | `?string` |
| `terrain` | `?string` |

## SaisonsItem

Collection `ffbbserver_saisons`.

| Propriété | Type |
|---|---|
| `actif` | `?bool` |
| `code` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `debut` | `?string` |
| `enCours` | `?bool` |
| `fin` | `?string` |
| `id` | `?string` |
| `libelle` | `?string` |

## SallesItem

Collection `ffbbserver_salles`.

| Propriété | Type |
|---|---|
| `adresse` | `?string` |
| `adresseComplement` | `?string` |
| `capaciteSpectateur` | `?string` |
| `cartographie` | `CartographiesItem\|int\|string\|null` |
| `commune` | `CommunesItem\|int\|string\|null` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `libelle` | `?string` |
| `libelle2` | `?string` |
| `mail` | `?string` |
| `numero` | `?string` |
| `telephone` | `?string` |

## SessionsItem

Collection `ffbbserver_sessions`.

| Propriété | Type |
|---|---|
| `date_created` | `?string` |
| `date_end` | `?string` |
| `date_start` | `?string` |
| `date_updated` | `?string` |
| `entity` | `?string` |
| `formations` | `FormationsItem\|int\|string\|null` |
| `id` | `?string` |
| `idOrigin` | `?string` |
| `place` | `?string` |
| `postal_code` | `?string` |
| `reference` | `?string` |
| `sort` | `?int` |
| `status` | `?string` |
| `subscribeBtn` | `?string` |
| `title` | `?string` |
| `user_created` | `?string` |
| `user_updated` | `?string` |

## TerrainsItem

Collection `ffbbserver_terrains`.

| Propriété | Type |
|---|---|
| `accesLibre` | `?bool` |
| `cartographie` | `CartographiesItem\|int\|string\|null` |
| `commune` | `CommunesItem\|int\|string\|null` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `largeur` | `?int` |
| `longueur` | `?int` |
| `natureSol` | `RevetementsItem\|int\|string\|null` |
| `nom` | `?string` |
| `numero` | `?int` |
| `rue` | `?string` |

## TournoisItem

Collection `ffbbserver_tournois`.

| Propriété | Type |
|---|---|
| `adresse` | `?string` |
| `adresseComplement` | `?string` |
| `ageMax` | `?int` |
| `ageMin` | `?int` |
| `cartographie` | `CartographiesItem\|int\|string\|null` |
| `categorieChampionnat3x3Id` | `?string` |
| `categorieChampionnat3x3Libelle` | `?string` |
| `code` | `?string` |
| `commune` | `CommunesItem\|int\|string\|null` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `debut` | `?string` |
| `description` | `?string` |
| `document_flyer` | `mixed` |
| `fin` | `?string` |
| `id` | `?string` |
| `mailOrganisateur` | `?string` |
| `nbParticipantPrevu` | `?int` |
| `nom` | `?string` |
| `nomOrganisateur` | `?string` |
| `sexe` | `?string` |
| `siteChoisi` | `?string` |
| `tarifOrganisateur` | `?string` |
| `telephoneOrganisateur` | `?string` |
| `tournoiType` | `TypesTournoisItem\|int\|string\|null` |
| `tournoiTypes3x3` | `?array` |
| `urlOrganisateur` | `?string` |

## TournoisFfbbserverTypesTournois3x3Item

Collection `ffbbserver_tournois_ffbbserver_types_tournois3x3`.

| Propriété | Type |
|---|---|
| `ffbbserver_tournois_id` | `TournoisItem\|int\|string\|null` |
| `ffbbserver_types_tournois_3x3_id` | `TypesTournois3x3Item\|int\|string\|null` |
| `id` | `?int` |

## TypesAssociationsItem

Collection `ffbbserver_types_associations`.

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `comite` | `?bool` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `ffbb` | `?bool` |
| `id` | `?string` |
| `libelle` | `?string` |
| `ligue` | `?bool` |

## TypesCompetitionsItem

Collection `ffbbserver_types_competitions`.

| Propriété | Type |
|---|---|
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `logo` | `mixed` |

## TypesDivisionsItem

Collection `ffbbserver_types_divisions`.

| Propriété | Type |
|---|---|
| `categorieChampionnat` | `CategoriesChampionnatsItem\|int\|string\|null` |
| `ccg` | `?int` |
| `code` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `libelle` | `?string` |
| `ordre` | `?int` |
| `point` | `?int` |
| `sexe` | `?string` |

## TypesPratiquesSportivesItem

Collection `ffbbserver_types_pratiques_sportives`.

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `libelle` | `?string` |

## TypesTournoisItem

Collection `ffbbserver_types_tournois`.

| Propriété | Type |
|---|---|
| `competition` | `?bool` |
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?string` |
| `isType3x3` | `?bool` |
| `libelle` | `?string` |

## TypesTournois3x3Item

Collection `ffbbserver_types_tournois3x3`.

| Propriété | Type |
|---|---|
| `date_created` | `?string` |
| `date_updated` | `?string` |
| `id` | `?int` |
| `libelle` | `?string` |
| `logo` | `mixed` |
| `type_league` | `?string` |
| `type_tournois` | `TypesTournoisItem\|int\|string\|null` |
| `user_created` | `?string` |
