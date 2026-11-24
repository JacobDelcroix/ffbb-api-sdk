<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# DTOs

Toutes les méthodes renvoient des objets typés. Toutes les propriétés sont nullables (les données FFBB sont souvent partielles), les dates sont des `DateTimeImmutable`, et `$raw` / `toArray()` conservent la réponse complète.

Guide avec exemples : [07-dtos](../guides/07-dtos.md)

- [Réponses Directus](#réponses-directus) : un DTO par collection, généré depuis la spec OpenAPI
- [Réponses Meilisearch et lives](#réponses-meilisearch-et-lives) : hits par index, objets imbriqués, matchs en direct

## Réponses Directus

Générées par `bin/generate-dtos` depuis `resources/discovery/openapi.json`. Une relation est toujours un DTO (seul `id` est rempli si Directus ne la développe pas) et porte un nom naturel : `idPoule` devient `poule`. La colonne « Champ Directus » donne le nom à utiliser dans `fields()`, `where()` et les filtres (constante `DIRECTUS_FIELDS`). Une collection sans DTO renvoie un `Item` générique (`$item->champ`, `$item->get('a.b')`).

| Collection Directus | DTO | Propriétés |
|---|---|---|
| `configuration` | [`ConfigurationItem`](#configurationitem) | 12 |
| `edf_arenas` | [`EdfArenasItem`](#edfarenasitem) | 11 |
| `edf_campaigns` | [`EdfCampaignsItem`](#edfcampaignsitem) | 23 |
| `edf_campaigns_edf_cities` | [`EdfCampaignsEdfCitiesItem`](#edfcampaignsedfcitiesitem) | 3 |
| `edf_campaigns_edf_countries` | [`EdfCampaignsEdfCountriesItem`](#edfcampaignsedfcountriesitem) | 3 |
| `edf_cities` | [`EdfCitiesItem`](#edfcitiesitem) | 6 |
| `edf_coaches` | [`EdfCoachesItem`](#edfcoachesitem) | 14 |
| `edf_competition_types` | [`EdfCompetitionTypesItem`](#edfcompetitiontypesitem) | 8 |
| `edf_countries` | [`EdfCountriesItem`](#edfcountriesitem) | 4 |
| `edf_matches` | [`EdfMatchesItem`](#edfmatchesitem) | 44 |
| `edf_opponents` | [`EdfOpponentsItem`](#edfopponentsitem) | 5 |
| `edf_players` | [`EdfPlayersItem`](#edfplayersitem) | 37 |
| `edf_players_edf_positions` | [`EdfPlayersEdfPositionsItem`](#edfplayersedfpositionsitem) | 3 |
| `edf_positions` | [`EdfPositionsItem`](#edfpositionsitem) | 6 |
| `edf_rosters` | [`EdfRostersItem`](#edfrostersitem) | 14 |
| `edf_selection` | [`EdfSelectionItem`](#edfselectionitem) | 13 |
| `edf_staffs` | [`EdfStaffsItem`](#edfstaffsitem) | 12 |
| `edf_teams` | [`EdfTeamsItem`](#edfteamsitem) | 12 |
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
| `genius_sport_matches` | [`GeniusSportMatchesItem`](#geniussportmatchesitem) | 66 |
| `genius_sports_live_logs` | [`GeniusSportsLiveLogsItem`](#geniussportslivelogsitem) | 5 |
| `rematch_videos` | [`RematchVideosItem`](#rematchvideositem) | 17 |

## Réponses Meilisearch et lives

Chaque recherche renvoie un `SearchResult` dont les `hits` sont typés selon l'index. Les DTOs de hits sont générés depuis les modèles du SDK Python, complétés par les attributs réellement observés dans chaque index.

| DTO | Rôle | Propriétés |
|---|---|---|
| [`Affiche`](#affiche) | Objet imbriqué Affiche (modèle Python, affiche.py). | 4 |
| [`Cartographie`](#cartographie) | Objet imbriqué Cartographie (modèle Python, cartographie.py). | 11 |
| [`Categorie`](#categorie) | Objet imbriqué Categorie (modèle Python, categorie.py). | 6 |
| [`Commune`](#commune) | Objet imbriqué Commune (modèle Python, commune.py). | 7 |
| [`CompetitionID`](#competitionid) | Objet imbriqué CompetitionID (modèle Python, competition_id.py). | 15 |
| [`CompetitionIDCategorie`](#competitionidcategorie) | Objet imbriqué CompetitionIDCategorie (modèle Python, competition_id_categorie.py). | 3 |
| [`CompetitionIDTypeCompetitionGenerique`](#competitionidtypecompetitiongenerique) | Objet imbriqué CompetitionIDTypeCompetitionGenerique (modèle Python, competition_id_type_competition_generique.py). | 1 |
| [`CompetitionOrigine`](#competitionorigine) | Objet imbriqué CompetitionOrigine (modèle Python, competition_origine.py). | 6 |
| [`CompetitionOrigineCategorie`](#competitionoriginecategorie) | Objet imbriqué CompetitionOrigineCategorie (modèle Python, competition_origine_categorie.py). | 1 |
| [`CompetitionOrigineTypeCompetitionGenerique`](#competitionoriginetypecompetitiongenerique) | Objet imbriqué CompetitionOrigineTypeCompetitionGenerique (modèle Python, competition_origine_type_competition_generique.py). | 1 |
| [`CompetitionsHit`](#competitionshit) | Hit Meilisearch de l'index `ffbbserver_competitions` (modèle Python CompetitionsHit, complété par 8 attribut(s) observé(s)). | 36 |
| [`ContentHit`](#contenthit) | Hit des index de contenu (actualités, vidéos YouTube, RSS, galeries), dont le schéma change souvent côté FFBB (miroir de GenericSearchHit) : quelques champs communs typés, le reste dans $raw. | 6 |
| [`Coordonnees`](#coordonnees) | Objet imbriqué Coordonnees (modèle Python, coordonnees.py). | 2 |
| [`DocumentFlyer`](#documentflyer) | Objet imbriqué DocumentFlyer (modèle Python, document_flyer.py). | 34 |
| [`Engagement`](#engagement) | Objet imbriqué Engagement (modèle Python, rencontres_engagement.py). | 1 |
| [`EngagementsHit`](#engagementshit) | Hit Meilisearch de l'index `ffbbserver_engagements` (modèle Python EngagementsHit). | 28 |
| [`ExternalCompetitionID`](#externalcompetitionid) | Objet imbriqué ExternalCompetitionID (modèle Python, external_competition_id.py). | 4 |
| [`ExternalID`](#externalid) | Objet imbriqué ExternalID (modèle Python, external_id.py). | 8 |
| [`Folder`](#folder) | Objet imbriqué Folder (modèle Python, folder.py). | 3 |
| [`FormationSession`](#formationsession) | Objet imbriqué FormationSession (modèle Python, formation_session.py). | 9 |
| [`FormationsHit`](#formationshit) | Hit Meilisearch de l'index `ffbbserver_formations` (modèle Python FormationsHit). | 45 |
| [`Geo`](#geo) | Objet imbriqué Geo (modèle Python, geo.py). | 2 |
| [`IDEngagementEquipe`](#idengagementequipe) | Objet imbriqué IDEngagementEquipe (modèle Python, id_engagement_equipe.py). | 3 |
| [`IDOrganismeEquipe`](#idorganismeequipe) | Objet imbriqué IDOrganismeEquipe (modèle Python, id_organisme_equipe.py). | 6 |
| [`IDOrganismeEquipe1Logo`](#idorganismeequipe1logo) | Objet imbriqué IDOrganismeEquipe1Logo (modèle Python, id_organisme_equipe1_logo.py). | 2 |
| [`IDPoule`](#idpoule) | Objet imbriqué IDPoule (modèle Python, id_poule.py). | 2 |
| [`Live`](#live) | Match en direct (json/lives.json), modèle Python Live. | 27 |
| [`Logo`](#logo) | Objet imbriqué Logo (modèle Python, logo.py). | 2 |
| [`NatureSol`](#naturesol) | Objet imbriqué NatureSol (modèle Python, nature_sol.py). | 6 |
| [`Organisateur`](#organisateur) | Objet imbriqué Organisateur (modèle Python, organisateur.py). | 33 |
| [`OrganismeIDPere`](#organismeidpere) | Objet imbriqué OrganismeIDPere (modèle Python, organisme_id_pere.py). | 29 |
| [`OrganismesHit`](#organismeshit) | Hit Meilisearch de l'index `ffbbserver_organismes` (modèle Python OrganismesHit, complété par 4 attribut(s) observé(s)). | 28 |
| [`Poule`](#poule) | Objet imbriqué Poule (modèle Python, poule.py). | 3 |
| [`PratiquesHit`](#pratiqueshit) | Hit Meilisearch de l'index `ffbbnational_pratiques` (modèle Python PratiquesHit, complété par 3 attribut(s) observé(s)). | 49 |
| [`PurpleLogo`](#purplelogo) | Objet imbriqué PurpleLogo (modèle Python, purple_logo.py). | 1 |
| [`RencontresHit`](#rencontreshit) | Hit Meilisearch de l'index `ffbbserver_rencontres` (modèle Python RencontresHit, complété par 9 attribut(s) observé(s)). | 37 |
| [`Saison`](#saison) | Objet imbriqué Saison (modèle Python, saison.py). | 1 |
| [`Salle`](#salle) | Objet imbriqué Salle (modèle Python, salle.py). | 5 |
| [`SallesHit`](#salleshit) | Hit Meilisearch de l'index `ffbbserver_salles` (modèle Python SallesHit). | 17 |
| [`SearchResult`](#searchresult) | Résultat d'une recherche Meilisearch sur un index (miroir de MultiSearchResult). | 9 |
| [`TeamEngagement`](#teamengagement) | Objet imbriqué TeamEngagement (modèle Python, team_engagement.py). | 4 |
| [`TerrainsHit`](#terrainshit) | Hit Meilisearch de l'index `ffbbserver_terrains` (modèle Python TournoisHit (le SDK Python l'associe à un autre index)). | 15 |
| [`TournoiTypes3X3`](#tournoitypes3x3) | Objet imbriqué TournoiTypes3X3 (modèle Python, tournoi_types_3x3.py). | 4 |
| [`TournoisHit`](#tournoishit) | Hit Meilisearch de l'index `ffbbserver_tournois` (modèle Python TerrainsHit (le SDK Python l'associe à un autre index)). | 31 |
| [`TypeAssociation`](#typeassociation) | Objet imbriqué TypeAssociation (modèle Python, type_association.py). | 1 |
| [`TypeCompetitionGenerique`](#typecompetitiongenerique) | Objet imbriqué TypeCompetitionGenerique (modèle Python, type_competition_generique.py). | 2 |

### ConfigurationItem

Collection Directus `configuration` (schéma OpenAPI ItemsConfiguration).

| Propriété | Type |
|---|---|
| `android_version` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `force_ms_reindex` | `?bool` |
| `id` | `?int` |
| `ios_version` | `?string` |
| `key_dh` | `?string` |
| `key_directus_competitions` | `?string` |
| `key_directus_website` | `?string` |
| `key_ms` | `?string` |
| `user_created` | `?string` |
| `user_updated` | `?string` |

### EdfArenasItem

Collection Directus `edf_arenas` (schéma OpenAPI ItemsEdfArenas).

| Propriété | Type |
|---|---|
| `address` | `?string` |
| `city` | `?string` |
| `coordinates` | `mixed` |
| `country` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?int` |
| `latitude` | `?float` |
| `longitude` | `?float` |
| `name` | `?string` |
| `postal_code` | `?string` |

### EdfCampaignsItem

Collection Directus `edf_campaigns` (schéma OpenAPI ItemsEdfCampaigns).

| Propriété | Type |
|---|---|
| `bronze` | `?string` |
| `bronze_medalist` | `?EdfOpponentsItem` |
| `cities` | `list<EdfCampaignsEdfCitiesItem>\|null` |
| `competition_type` | `?EdfCompetitionTypesItem` |
| `countries` | `list<EdfCampaignsEdfCountriesItem>\|null` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `gold` | `?string` |
| `gold_medalist` | `?EdfOpponentsItem` |
| `id` | `?int` |
| `matches` | `list<EdfMatchesItem>\|null` |
| `original_id` | `?int` |
| `photo_team` | `mixed` |
| `place` | `?string` |
| `rank` | `?string` |
| `roster` | `list<EdfRostersItem>\|null` |
| `silver` | `?string` |
| `silver_medalist` | `?EdfOpponentsItem` |
| `staff` | `list<EdfStaffsItem>\|null` |
| `status` | `?string` |
| `team` | `?EdfTeamsItem` |
| `team_france` | `?bool` |
| `year` | `?int` |

### EdfCampaignsEdfCitiesItem

Collection Directus `edf_campaigns_edf_cities` (schéma OpenAPI ItemsEdfCampaignsEdfCities).

| Propriété | Type | Champ Directus |
|---|---|---|
| `edf_campaigns` | `?EdfCampaignsItem` | `edf_campaigns_id` |
| `edf_cities` | `?EdfCitiesItem` | `edf_cities_id` |
| `id` | `?int` |  |

### EdfCampaignsEdfCountriesItem

Collection Directus `edf_campaigns_edf_countries` (schéma OpenAPI ItemsEdfCampaignsEdfCountries).

| Propriété | Type | Champ Directus |
|---|---|---|
| `edf_campaigns` | `?EdfCampaignsItem` | `edf_campaigns_id` |
| `edf_countries` | `?EdfCountriesItem` | `edf_countries_id` |
| `id` | `?int` |  |

### EdfCitiesItem

Collection Directus `edf_cities` (schéma OpenAPI ItemsEdfCities).

| Propriété | Type |
|---|---|
| `campaigns` | `list<EdfCampaignsEdfCitiesItem>\|null` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?int` |
| `matches` | `list<EdfMatchesItem>\|null` |
| `name` | `?string` |

### EdfCoachesItem

Collection Directus `edf_coaches` (schéma OpenAPI ItemsEdfCoaches).

| Propriété | Type |
|---|---|
| `birth_date` | `?DateTimeImmutable` |
| `birth_place` | `?string` |
| `campaigns` | `list<EdfStaffsItem>\|null` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `death_date` | `?DateTimeImmutable` |
| `death_place` | `?string` |
| `first_name` | `?string` |
| `gender` | `?string` |
| `id` | `?int` |
| `last_name` | `?string` |
| `original_id` | `?int` |
| `qualification` | `?string` |
| `status` | `?string` |

### EdfCompetitionTypesItem

Collection Directus `edf_competition_types` (schéma OpenAPI ItemsEdfCompetitionTypes).

| Propriété | Type |
|---|---|
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?int` |
| `name` | `?string` |
| `order` | `?int` |
| `original_id` | `?int` |
| `status` | `?string` |
| `team` | `?EdfTeamsItem` |

### EdfCountriesItem

Collection Directus `edf_countries` (schéma OpenAPI ItemsEdfCountries).

| Propriété | Type |
|---|---|
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?int` |
| `name` | `?string` |

### EdfMatchesItem

Collection Directus `edf_matches` (schéma OpenAPI ItemsEdfMatches).

| Propriété | Type | Champ Directus |
|---|---|---|
| `arena` | `?EdfArenasItem` |  |
| `campaign` | `?EdfCampaignsItem` |  |
| `city` | `?EdfCitiesItem` |  |
| `competition_type` | `?EdfCompetitionTypesItem` |  |
| `country` | `?EdfCountriesItem` |  |
| `date` | `?DateTimeImmutable` |  |
| `date_created` | `?DateTimeImmutable` |  |
| `date_timestamp` | `?int` |  |
| `date_updated` | `?DateTimeImmutable` |  |
| `edf_team` | `?EdfTeamsItem` |  |
| `federation_number` | `?int` |  |
| `france_at_home` | `?bool` |  |
| `gs` | `GeniusSportMatchesItem\|int\|string\|null` | `gsId` |
| `hour` | `?string` |  |
| `id` | `?int` |  |
| `national_number` | `?int` |  |
| `not_official` | `?bool` |  |
| `opponent` | `?EdfOpponentsItem` |  |
| `original_id` | `?int` |  |
| `phase` | `?string` |  |
| `preparation` | `?bool` |  |
| `result` | `?string` |  |
| `roster` | `list<EdfSelectionItem>\|null` |  |
| `score_france` | `?int` |  |
| `score_france_ot1` | `?int` |  |
| `score_france_ot2` | `?int` |  |
| `score_france_q1` | `?int` |  |
| `score_france_q2` | `?int` |  |
| `score_france_q3` | `?int` |  |
| `score_france_q4` | `?int` |  |
| `score_opponent` | `?int` |  |
| `score_opponent_ot1` | `?int` |  |
| `score_opponent_ot2` | `?int` |  |
| `score_opponent_q1` | `?int` |  |
| `score_opponent_q2` | `?int` |  |
| `score_opponent_q3` | `?int` |  |
| `score_opponent_q4` | `?int` |  |
| `status` | `?string` |  |
| `url_article` | `?string` |  |
| `url_live` | `?string` |  |
| `url_match_sheet` | `?string` |  |
| `url_photos` | `?string` |  |
| `url_ticketing` | `?string` |  |
| `url_video` | `?string` |  |

### EdfOpponentsItem

Collection Directus `edf_opponents` (schéma OpenAPI ItemsEdfOpponents).

| Propriété | Type |
|---|---|
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?int` |
| `logo` | `mixed` |
| `name` | `?string` |

### EdfPlayersItem

Collection Directus `edf_players` (schéma OpenAPI ItemsEdfPlayers).

| Propriété | Type |
|---|---|
| `birth_place` | `?string` |
| `campaigns` | `list<EdfRostersItem>\|null` |
| `career` | `?string` |
| `date_birth` | `?DateTimeImmutable` |
| `date_created` | `?DateTimeImmutable` |
| `date_death` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `death_place` | `?string` |
| `distinctions` | `?string` |
| `first_name` | `?string` |
| `first_selection` | `?string` |
| `first_selection_id` | `?EdfMatchesItem` |
| `first_selection_id_3x3` | `?EdfMatchesItem` |
| `height` | `?float` |
| `id` | `?int` |
| `identifiant` | `?string` |
| `identifier` | `?int` |
| `jou_n_id` | `?string` |
| `last_name` | `?string` |
| `last_selection` | `?string` |
| `last_selection_id` | `?EdfMatchesItem` |
| `last_selection_id_3x3` | `?EdfMatchesItem` |
| `original_id` | `?int` |
| `palmares` | `?string` |
| `palmares_individual` | `?string` |
| `palmares_international` | `?string` |
| `player_note` | `?string` |
| `player_points` | `?int` |
| `player_points_3x3` | `?int` |
| `player_record` | `?int` |
| `player_record_3x3` | `?int` |
| `player_selections` | `?int` |
| `player_selections_3x3` | `?int` |
| `pole` | `?string` |
| `position` | `list<EdfPlayersEdfPositionsItem>\|null` |
| `selections` | `list<EdfSelectionItem>\|null` |
| `status` | `?string` |

### EdfPlayersEdfPositionsItem

Collection Directus `edf_players_edf_positions` (schéma OpenAPI ItemsEdfPlayersEdfPositions).

| Propriété | Type | Champ Directus |
|---|---|---|
| `edf_players` | `?EdfPlayersItem` | `edf_players_id` |
| `edf_positions` | `?EdfPositionsItem` | `edf_positions_id` |
| `id` | `?int` |  |

### EdfPositionsItem

Collection Directus `edf_positions` (schéma OpenAPI ItemsEdfPositions).

| Propriété | Type |
|---|---|
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?int` |
| `name` | `?string` |
| `name_f` | `?string` |
| `name_m` | `?string` |

### EdfRostersItem

Collection Directus `edf_rosters` (schéma OpenAPI ItemsEdfRosters).

| Propriété | Type |
|---|---|
| `campaign` | `?EdfCampaignsItem` |
| `club` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `height` | `?float` |
| `id` | `?int` |
| `number` | `?string` |
| `order` | `?int` |
| `original_id` | `?int` |
| `photo` | `mixed` |
| `photo_hover` | `mixed` |
| `player` | `?EdfPlayersItem` |
| `status` | `?string` |
| `unselected` | `?bool` |

### EdfSelectionItem

Collection Directus `edf_selection` (schéma OpenAPI ItemsEdfSelection).

| Propriété | Type |
|---|---|
| `club` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `height` | `?float` |
| `id` | `?int` |
| `maj_n_nd` | `?bool` |
| `maj_n_npj` | `?bool` |
| `match` | `?EdfMatchesItem` |
| `original_id` | `?int` |
| `player` | `?EdfPlayersItem` |
| `points_number` | `?int` |
| `sort` | `?int` |
| `status` | `?string` |

### EdfStaffsItem

Collection Directus `edf_staffs` (schéma OpenAPI ItemsEdfStaffs).

| Propriété | Type |
|---|---|
| `campaign` | `?EdfCampaignsItem` |
| `club` | `?string` |
| `coach` | `?EdfCoachesItem` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?int` |
| `order` | `?int` |
| `original_id` | `?string` |
| `photo` | `mixed` |
| `photo_hover` | `mixed` |
| `role` | `?string` |
| `status` | `?string` |

### EdfTeamsItem

Collection Directus `edf_teams` (schéma OpenAPI ItemsEdfTeams).

| Propriété | Type |
|---|---|
| `age_category` | `?string` |
| `basket_type` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `gender` | `?string` |
| `id` | `?int` |
| `logo` | `mixed` |
| `name` | `?string` |
| `order` | `?int` |
| `original_id` | `?int` |
| `sort` | `?int` |
| `status` | `?string` |

### CategoriesItem

Collection Directus `ffbbnational_categories` (schéma OpenAPI ItemsFfbbnationalCategories).

| Propriété | Type |
|---|---|
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `title` | `?string` |

### GaleriesItem

Collection Directus `ffbbnational_galeries` (schéma OpenAPI ItemsFfbbnationalGaleries).

| Propriété | Type |
|---|---|
| `cover` | `mixed` |
| `creator` | `?string` |
| `date` | `?DateTimeImmutable` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?int` |
| `images` | `list<GaleriesFilesItem>\|null` |
| `surtitle` | `?string` |
| `tags` | `list<GaleriesFfbbnationalTagsItem>\|null` |
| `title` | `?string` |

### GaleriesFfbbnationalTagsItem

Collection Directus `ffbbnational_galeries_ffbbnational_tags` (schéma OpenAPI ItemsFfbbnationalGaleriesFfbbnationalTags).

| Propriété | Type | Champ Directus |
|---|---|---|
| `ffbbnational_galeries` | `?GaleriesItem` | `ffbbnational_galeries_id` |
| `ffbbnational_tags` | `?TagsItem` | `ffbbnational_tags_id` |
| `id` | `?int` |  |

### GaleriesFilesItem

Collection Directus `ffbbnational_galeries_files` (schéma OpenAPI ItemsFfbbnationalGaleriesFiles).

| Propriété | Type | Champ Directus |
|---|---|---|
| `directus_files_id` | `mixed` |  |
| `ffbbnational_galeries` | `?GaleriesItem` | `ffbbnational_galeries_id` |
| `id` | `?int` |  |

### PratiquesItem

Collection Directus `ffbbnational_pratiques` (schéma OpenAPI ItemsFfbbnationalPratiques).

| Propriété | Type |
|---|---|
| `action` | `?string` |
| `adresse` | `?string` |
| `adresse_salle` | `?string` |
| `adresse_structure` | `?string` |
| `affiche` | `mixed` |
| `affiche_externe` | `?string` |
| `assurance` | `?string` |
| `cartographie` | `?CartographiesItem` |
| `code` | `?string` |
| `code_structure` | `?string` |
| `cp_salle` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_debut` | `?DateTimeImmutable` |
| `date_demande` | `?int` |
| `date_fin` | `?DateTimeImmutable` |
| `date_inscription` | `?string` |
| `date_updated` | `?DateTimeImmutable` |
| `date_validation_ffbb` | `?DateTimeImmutable` |
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

### RssItem

Collection Directus `ffbbnational_rss` (schéma OpenAPI ItemsFfbbnationalRss).

| Propriété | Type |
|---|---|
| `categories` | `list<RssFfbbnationalCategoriesItem>\|null` |
| `chapo` | `?string` |
| `cover` | `mixed` |
| `creator` | `?string` |
| `date` | `?DateTimeImmutable` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `highlight` | `?bool` |
| `id` | `?string` |
| `img` | `?string` |
| `img_credits` | `?string` |
| `img_legend` | `?string` |
| `link` | `?string` |
| `match_id` | `?string` |
| `surtitle` | `?string` |
| `tags` | `list<RssFfbbnationalTagsItem>\|null` |
| `text` | `mixed` |
| `texte` | `?string` |
| `title` | `?string` |

### RssFfbbnationalCategoriesItem

Collection Directus `ffbbnational_rss_ffbbnational_categories` (schéma OpenAPI ItemsFfbbnationalRssFfbbnationalCategories).

| Propriété | Type | Champ Directus |
|---|---|---|
| `ffbbnational_categories` | `?CategoriesItem` | `ffbbnational_categories_id` |
| `ffbbnational_rss` | `?RssItem` | `ffbbnational_rss_id` |
| `id` | `?int` |  |

### RssFfbbnationalTagsItem

Collection Directus `ffbbnational_rss_ffbbnational_tags` (schéma OpenAPI ItemsFfbbnationalRssFfbbnationalTags).

| Propriété | Type | Champ Directus |
|---|---|---|
| `ffbbnational_rss` | `?RssItem` | `ffbbnational_rss_id` |
| `ffbbnational_tags` | `?TagsItem` | `ffbbnational_tags_id` |
| `id` | `?int` |  |

### TagsItem

Collection Directus `ffbbnational_tags` (schéma OpenAPI ItemsFfbbnationalTags).

| Propriété | Type |
|---|---|
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `title` | `?string` |

### CartographiesItem

Collection Directus `ffbbserver_cartographies` (schéma OpenAPI ItemsFfbbserverCartographies).

| Propriété | Type |
|---|---|
| `adresse` | `?string` |
| `codePostal` | `?string` |
| `coordonnees` | `mixed` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `latitude` | `?float` |
| `longitude` | `?float` |
| `status` | `?string` |
| `title` | `?string` |
| `ville` | `?string` |

### CategoriesAgeItem

Collection Directus `ffbbserver_categories_age` (schéma OpenAPI ItemsFfbbserverCategoriesAge).

| Propriété | Type |
|---|---|
| `ageMaxi` | `?int` |
| `ageMini` | `?int` |
| `code` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `libelle` | `?string` |
| `sexe` | `?string` |

### CategoriesChampionnatsItem

Collection Directus `ffbbserver_categories_championnats` (schéma OpenAPI ItemsFfbbserverCategoriesChampionnats).

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `libelle` | `?string` |
| `ordre` | `?int` |

### CommunesItem

Collection Directus `ffbbserver_communes` (schéma OpenAPI ItemsFfbbserverCommunes).

| Propriété | Type |
|---|---|
| `codeInsee` | `?string` |
| `codePostal` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `departement` | `?string` |
| `id` | `?string` |
| `libelle` | `?string` |

### CompetitionsItem

Collection Directus `ffbbserver_competitions` (schéma OpenAPI ItemsFfbbserverCompetitions).

| Propriété | Type | Champ Directus |
|---|---|---|
| `categorie` | `?CategoriesChampionnatsItem` |  |
| `code` | `?string` |  |
| `compare_old_site` | `?bool` |  |
| `competitionPere` | `?self` | `idCompetitionPere` |
| `competition_origine` | `?self` |  |
| `competition_origine_niveau` | `?int` |  |
| `competition_origine_nom` | `?string` |  |
| `creationEnCours` | `?bool` |  |
| `date_created` | `?DateTimeImmutable` |  |
| `date_updated` | `?DateTimeImmutable` |  |
| `emarqueV2` | `?bool` |  |
| `etat` | `?string` |  |
| `id` | `?string` |  |
| `liveStat` | `?bool` |  |
| `logo` | `mixed` |  |
| `nom` | `?string` |  |
| `ordre` | `?int` |  |
| `organisateur` | `?OrganismesItem` |  |
| `phase_code` | `?string` |  |
| `phases` | `list<CompetitionsItem>\|null` |  |
| `poules` | `list<PoulesItem>\|null` |  |
| `pro` | `?bool` |  |
| `publicationInternet` | `?string` |  |
| `saison` | `?SaisonsItem` |  |
| `sexe` | `?string` |  |
| `slug` | `?string` |  |
| `toUpdate` | `?bool` |  |
| `typeCompetition` | `?string` |  |
| `typeCompetitionGenerique` | `?TypesCompetitionsItem` |  |

### EngagementsItem

Collection Directus `ffbbserver_engagements` (schéma OpenAPI ItemsFfbbserverEngagements).

| Propriété | Type | Champ Directus |
|---|---|---|
| `adresseCorrespondantEquipe` | `?string` |  |
| `classement` | `list<PoulesClassementsItem>\|null` |  |
| `clubPro` | `?bool` |  |
| `codeAbrege` | `?string` |  |
| `communeCorrespondantEquipe` | `?string` |  |
| `competition` | `?CompetitionsItem` | `idCompetition` |
| `complementAdresseCorrespondantEquipe` | `?string` |  |
| `creation` | `?DateTimeImmutable` |  |
| `date_created` | `?DateTimeImmutable` |  |
| `date_updated` | `?DateTimeImmutable` |  |
| `emailCorrespondantEquipe` | `?string` |  |
| `entraineur` | `EntraineursItem\|int\|string\|null` |  |
| `entraineurAdjoint` | `EntraineursItem\|int\|string\|null` |  |
| `forfaitGeneral` | `?bool` |  |
| `id` | `?string` |  |
| `logo` | `mixed` |  |
| `logo_genius` | `?string` |  |
| `modification` | `?DateTimeImmutable` |  |
| `niveau` | `?TypesDivisionsItem` |  |
| `nom` | `?string` |  |
| `nomCorrespondantEquipe` | `?string` |  |
| `nomCtc` | `?string` |  |
| `nomEquipe` | `?string` |  |
| `nomOfficiel` | `?string` |  |
| `nomUsuel` | `?string` |  |
| `numeroEquipe` | `?string` |  |
| `organisme` | `?OrganismesItem` | `idOrganisme` |
| `organismeCtc` | `?OrganismesItem` | `idOrganismeCtc` |
| `photo` | `?string` |  |
| `position` | `?int` |  |
| `positionVariation` | `?int` |  |
| `position_n1` | `?int` |  |
| `positions` | `mixed` |  |
| `poule` | `?PoulesItem` | `idPoule` |
| `pouleId` | `?string` |  |
| `rencontres_domiciles` | `list<RencontresItem>\|null` |  |
| `rencontres_exterieur` | `list<RencontresItem>\|null` |  |
| `telephoneFixeCorrespondantEquipe` | `?string` |  |
| `telephonePortableCorrespondantEquipe` | `?string` |  |
| `telephoneTravailCorrespondantEquipe` | `?string` |  |
| `toUpdate` | `?bool` |  |
| `typeEntenteCtc` | `?string` |  |
| `url_competition` | `?string` |  |

### EntraineursItem

Collection Directus `ffbbserver_entraineurs` (schéma OpenAPI ItemsFfbbserverEntraineurs).

| Propriété | Type |
|---|---|
| `adresse1` | `?string` |
| `adresse2` | `?string` |
| `commune` | `?CommunesItem` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `idLicence` | `?string` |
| `nom` | `?string` |
| `prenom` | `?string` |

### FonctionsOfficielsItem

Collection Directus `ffbbserver_fonctions_officiels` (schéma OpenAPI ItemsFfbbserverFonctionsOfficiels).

| Propriété | Type |
|---|---|
| `afficher` | `?bool` |
| `attribuer` | `?bool` |
| `certificatMedical` | `?bool` |
| `code` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `designation` | `?bool` |
| `emarque` | `?bool` |
| `id` | `?string` |
| `libelle` | `?string` |
| `niveau` | `?string` |
| `ordre` | `?int` |
| `repartitionClub` | `?bool` |

### FormationsItem

Collection Directus `ffbbserver_formations` (schéma OpenAPI ItemsFfbbserverFormations).

| Propriété | Type |
|---|---|
| `certification` | `?string` |
| `content` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `description` | `?string` |
| `domain` | `?FormationsDomainItem` |
| `duration_hours` | `?string` |
| `files` | `list<FormationsFilesItem>\|null` |
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
| `sessions` | `list<SessionsItem>\|null` |
| `sort` | `?int` |
| `status` | `?string` |
| `theme` | `?FormationsThemeItem` |
| `title` | `?string` |
| `user_created` | `?string` |
| `user_updated` | `?string` |

### FormationsDomainItem

Collection Directus `ffbbserver_formations_domain` (schéma OpenAPI ItemsFfbbserverFormationsDomain).

| Propriété | Type |
|---|---|
| `id` | `?string` |
| `name` | `?string` |
| `sort` | `?int` |

### FormationsFilesItem

Collection Directus `ffbbserver_formations_files` (schéma OpenAPI ItemsFfbbserverFormationsFiles).

| Propriété | Type | Champ Directus |
|---|---|---|
| `directus_files_id` | `mixed` |  |
| `ffbbserver_formations` | `?FormationsItem` | `ffbbserver_formations_id` |
| `id` | `?int` |  |

### FormationsThemeItem

Collection Directus `ffbbserver_formations_theme` (schéma OpenAPI ItemsFfbbserverFormationsTheme).

| Propriété | Type |
|---|---|
| `id` | `?string` |
| `name` | `?string` |
| `sort` | `?int` |

### LabellisationLabelItem

Collection Directus `ffbbserver_labellisation_label` (schéma OpenAPI ItemsFfbbserverLabellisationLabel).

| Propriété | Type |
|---|---|
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `libelle` | `?string` |

### LabellisationProgrammeItem

Collection Directus `ffbbserver_labellisation_programme` (schéma OpenAPI ItemsFfbbserverLabellisationProgramme).

| Propriété | Type |
|---|---|
| `affiche` | `?string` |
| `code` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `decouverte` | `?bool` |
| `demandeLabel` | `?bool` |
| `engagement` | `?string` |
| `id` | `?string` |
| `labellisationLabel` | `?LabellisationLabelItem` |
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

### LabellisationsOrganismesItem

Collection Directus `ffbbserver_labellisations_organismes` (schéma OpenAPI ItemsFfbbserverLabellisationsOrganismes).

| Propriété | Type | Champ Directus |
|---|---|---|
| `date_created` | `?DateTimeImmutable` |  |
| `date_updated` | `?DateTimeImmutable` |  |
| `debut` | `?DateTimeImmutable` |  |
| `fin` | `?DateTimeImmutable` |  |
| `id` | `?string` |  |
| `labellisationProgramme` | `?LabellisationProgrammeItem` | `idLabellisationProgramme` |
| `organisme` | `?OrganismesItem` | `idOrganisme` |

### MembresItem

Collection Directus `ffbbserver_membres` (schéma OpenAPI ItemsFfbbserverMembres).

| Propriété | Type | Champ Directus |
|---|---|---|
| `accordDiffusionSiteWeb` | `?bool` |  |
| `adresse1` | `?string` |  |
| `adresse2` | `?string` |  |
| `codeFonction` | `?string` |  |
| `codePostal` | `?string` |  |
| `date_created` | `?DateTimeImmutable` |  |
| `date_updated` | `?DateTimeImmutable` |  |
| `id` | `?string` |  |
| `idLicence` | `?string` |  |
| `libelleFonction` | `?string` |  |
| `mail` | `?string` |  |
| `nom` | `?string` |  |
| `organisme` | `?OrganismesItem` | `idOrganisme` |
| `prenom` | `?string` |  |
| `telephoneFixe` | `?string` |  |
| `telephonePortable` | `?string` |  |
| `ville` | `?string` |  |

### OfficielsItem

Collection Directus `ffbbserver_officiels` (schéma OpenAPI ItemsFfbbserverOfficiels).

| Propriété | Type |
|---|---|
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `nom` | `?string` |
| `numeroNational` | `?string` |
| `prenom` | `?string` |

### OfficielsRencontresItem

Collection Directus `ffbbserver_officiels_rencontres` (schéma OpenAPI ItemsFfbbserverOfficielsRencontres).

| Propriété | Type |
|---|---|
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `distanceKm` | `?float` |
| `fonction` | `?FonctionsOfficielsItem` |
| `id` | `?string` |
| `indemnite` | `?float` |
| `officiel` | `OfficielsItem\|int\|string\|null` |
| `ordre` | `?int` |
| `presence` | `?string` |
| `rencontre` | `?RencontresItem` |

### OffresPratiquesItem

Collection Directus `ffbbserver_offres_pratiques` (schéma OpenAPI ItemsFfbbserverOffresPratiques).

| Propriété | Type |
|---|---|
| `categoriePratique` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `title` | `?string` |
| `typePratique` | `?string` |

### OrganismesItem

Collection Directus `ffbbserver_organismes` (schéma OpenAPI ItemsFfbbserverOrganismes).

| Propriété | Type |
|---|---|
| `adresse` | `?string` |
| `adresseClubPro` | `?string` |
| `cartographie` | `?CartographiesItem` |
| `code` | `?string` |
| `commune` | `?CommunesItem` |
| `communeClubPro` | `?CommunesItem` |
| `competitions` | `list<CompetitionsItem>\|null` |
| `dateAffiliation` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `engagements` | `list<EngagementsItem>\|null` |
| `entreprise` | `?bool` |
| `handibasket` | `?bool` |
| `horsAssociation` | `?bool` |
| `id` | `?string` |
| `labellisation` | `list<LabellisationsOrganismesItem>\|null` |
| `logo` | `mixed` |
| `logo_base64` | `?string` |
| `mail` | `?string` |
| `membres` | `list<MembresItem>\|null` |
| `nom` | `?string` |
| `nomClubPro` | `?string` |
| `nom_simple` | `?string` |
| `offresPratiques` | `list<OrganismesFfbbserverOffresPratiquesItem>\|null` |
| `omnisport` | `?bool` |
| `organisme_id_pere` | `?self` |
| `organismes_fils` | `list<OrganismesItem>\|null` |
| `saison` | `?string` |
| `saison_en_cours` | `?bool` |
| `salle` | `?SallesItem` |
| `telephone` | `?string` |
| `type` | `?string` |
| `type_association` | `?TypesAssociationsItem` |
| `urlSiteWeb` | `?string` |
| `url_competition` | `?string` |

### OrganismesFfbbserverOffresPratiquesItem

Collection Directus `ffbbserver_organismes_ffbbserver_offres_pratiques` (schéma OpenAPI ItemsFfbbserverOrganismesFfbbserverOffresPratiques).

| Propriété | Type | Champ Directus |
|---|---|---|
| `ffbbserver_offres_pratiques` | `?OffresPratiquesItem` | `ffbbserver_offres_pratiques_id` |
| `ffbbserver_organismes` | `?OrganismesItem` | `ffbbserver_organismes_id` |
| `id` | `?int` |  |

### OrganismesFfbbserverOrganismesItem

Collection Directus `ffbbserver_organismes_ffbbserver_organismes` (schéma OpenAPI ItemsFfbbserverOrganismesFfbbserverOrganismes).

| Propriété | Type | Champ Directus |
|---|---|---|
| `ffbbserver_organismes` | `?OrganismesItem` | `ffbbserver_organismes_id` |
| `id` | `?int` |  |
| `related_ffbbserver_organismes` | `?OrganismesItem` | `related_ffbbserver_organismes_id` |

### PoulesItem

Collection Directus `ffbbserver_poules` (schéma OpenAPI ItemsFfbbserverPoules).

| Propriété | Type |
|---|---|
| `classements` | `list<PoulesClassementsItem>\|null` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `engagements` | `list<EngagementsItem>\|null` |
| `id` | `?string` |
| `id_competition` | `?CompetitionsItem` |
| `nom` | `?string` |
| `rencontres` | `list<RencontresItem>\|null` |

### PoulesClassementsItem

Collection Directus `ffbbserver_poules_classements` (schéma OpenAPI ItemsFfbbserverPoulesClassements).

| Propriété | Type | Champ Directus |
|---|---|---|
| `competition` | `?CompetitionsItem` | `idCompetition` |
| `date_created` | `?DateTimeImmutable` |  |
| `date_updated` | `?DateTimeImmutable` |  |
| `difference` | `?int` |  |
| `engagement` | `?EngagementsItem` | `idEngagement` |
| `gagnes` | `?int` |  |
| `horsClassement` | `?bool` |  |
| `id` | `?string` |  |
| `matchJoues` | `?int` |  |
| `match_joues` | `?int` |  |
| `nombreDefauts` | `?int` |  |
| `nombreForfaits` | `?int` |  |
| `nuls` | `?int` |  |
| `organisme` | `?OrganismesItem` |  |
| `organisme_nom` | `?string` |  |
| `paniersEncaisses` | `?int` |  |
| `paniersMarques` | `?int` |  |
| `penalites` | `?int` |  |
| `penalitesArbitrage` | `?int` |  |
| `penalitesDiverses` | `?int` |  |
| `penalitesEntraineur` | `?int` |  |
| `perdus` | `?int` |  |
| `pointInitiaux` | `?int` |  |
| `points` | `?int` |  |
| `pointsInitiaux` | `?int` |  |
| `position` | `?int` |  |
| `poule` | `?PoulesItem` | `idPoule` |
| `quotient` | `?float` |  |

### RencontresItem

Collection Directus `ffbbserver_rencontres` (schéma OpenAPI ItemsFfbbserverRencontres).

| Propriété | Type | Champ Directus |
|---|---|---|
| `competition` | `?CompetitionsItem` | `competitionId` |
| `creation` | `?DateTimeImmutable` |  |
| `date` | `?DateTimeImmutable` |  |
| `dateSaisieResultat` | `?DateTimeImmutable` |  |
| `date_created` | `?DateTimeImmutable` |  |
| `date_rencontre` | `?DateTimeImmutable` |  |
| `date_updated` | `?DateTimeImmutable` |  |
| `defautEquipe1` | `?bool` |  |
| `defautEquipe2` | `?bool` |  |
| `engagementEquipe1` | `?EngagementsItem` | `idEngagementEquipe1` |
| `engagementEquipe2` | `?EngagementsItem` | `idEngagementEquipe2` |
| `etat` | `?string` |  |
| `forfaitEquipe1` | `?bool` |  |
| `forfaitEquipe2` | `?bool` |  |
| `gs` | `GeniusSportMatchesItem\|int\|string\|null` | `gsId` |
| `handicap1` | `?int` |  |
| `handicap2` | `?int` |  |
| `horaire` | `?int` |  |
| `id` | `?string` |  |
| `joue` | `?bool` |  |
| `modification` | `?DateTimeImmutable` |  |
| `nomEquipe1` | `?string` |  |
| `nomEquipe2` | `?string` |  |
| `numero` | `?int` |  |
| `numeroJournee` | `?string` |  |
| `officiels` | `list<OfficielsRencontresItem>\|null` |  |
| `organismeEquipe1` | `?OrganismesItem` | `idOrganismeEquipe1` |
| `organismeEquipe2` | `?OrganismesItem` | `idOrganismeEquipe2` |
| `penaliteEquipe1` | `?bool` |  |
| `penaliteEquipe2` | `?bool` |  |
| `poule` | `?PoulesItem` | `idPoule` |
| `pratique` | `?string` |  |
| `rematch_videos` | `list<RematchVideosItem\|string\|int>\|null` |  |
| `remise` | `?bool` |  |
| `resultatEquipe1` | `?int` |  |
| `resultatEquipe2` | `?int` |  |
| `saison` | `?SaisonsItem` |  |
| `salle` | `?SallesItem` |  |
| `status` | `?string` |  |
| `toUpdate` | `?bool` |  |
| `uniqueKey` | `?string` |  |
| `url_competition` | `?string` |  |
| `validee` | `?bool` |  |

### RevetementsItem

Collection Directus `ffbbserver_revetements` (schéma OpenAPI ItemsFfbbserverRevetements).

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `libelle` | `?string` |
| `terrain` | `?string` |

### SaisonsItem

Collection Directus `ffbbserver_saisons` (schéma OpenAPI ItemsFfbbserverSaisons).

| Propriété | Type |
|---|---|
| `actif` | `?bool` |
| `code` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `debut` | `?DateTimeImmutable` |
| `enCours` | `?bool` |
| `fin` | `?DateTimeImmutable` |
| `id` | `?string` |
| `libelle` | `?string` |

### SallesItem

Collection Directus `ffbbserver_salles` (schéma OpenAPI ItemsFfbbserverSalles).

| Propriété | Type |
|---|---|
| `adresse` | `?string` |
| `adresseComplement` | `?string` |
| `capaciteSpectateur` | `?string` |
| `cartographie` | `?CartographiesItem` |
| `commune` | `?CommunesItem` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `libelle` | `?string` |
| `libelle2` | `?string` |
| `mail` | `?string` |
| `numero` | `?string` |
| `telephone` | `?string` |

### SessionsItem

Collection Directus `ffbbserver_sessions` (schéma OpenAPI ItemsFfbbserverSessions).

| Propriété | Type |
|---|---|
| `date_created` | `?DateTimeImmutable` |
| `date_end` | `?DateTimeImmutable` |
| `date_start` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `entity` | `?string` |
| `formations` | `?FormationsItem` |
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

### TerrainsItem

Collection Directus `ffbbserver_terrains` (schéma OpenAPI ItemsFfbbserverTerrains).

| Propriété | Type |
|---|---|
| `accesLibre` | `?bool` |
| `cartographie` | `?CartographiesItem` |
| `commune` | `?CommunesItem` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `largeur` | `?int` |
| `longueur` | `?int` |
| `natureSol` | `?RevetementsItem` |
| `nom` | `?string` |
| `numero` | `?int` |
| `rue` | `?string` |

### TournoisItem

Collection Directus `ffbbserver_tournois` (schéma OpenAPI ItemsFfbbserverTournois).

| Propriété | Type |
|---|---|
| `adresse` | `?string` |
| `adresseComplement` | `?string` |
| `ageMax` | `?int` |
| `ageMin` | `?int` |
| `cartographie` | `?CartographiesItem` |
| `categorieChampionnat3x3Id` | `?string` |
| `categorieChampionnat3x3Libelle` | `?string` |
| `code` | `?string` |
| `commune` | `?CommunesItem` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `debut` | `?DateTimeImmutable` |
| `description` | `?string` |
| `document_flyer` | `mixed` |
| `fin` | `?DateTimeImmutable` |
| `id` | `?string` |
| `mailOrganisateur` | `?string` |
| `nbParticipantPrevu` | `?int` |
| `nom` | `?string` |
| `nomOrganisateur` | `?string` |
| `sexe` | `?string` |
| `siteChoisi` | `?string` |
| `tarifOrganisateur` | `?string` |
| `telephoneOrganisateur` | `?string` |
| `tournoiType` | `?TypesTournoisItem` |
| `tournoiTypes3x3` | `list<TournoisFfbbserverTypesTournois3x3Item>\|null` |
| `urlOrganisateur` | `?string` |

### TournoisFfbbserverTypesTournois3x3Item

Collection Directus `ffbbserver_tournois_ffbbserver_types_tournois3x3` (schéma OpenAPI ItemsFfbbserverTournoisFfbbserverTypesTournois3x3).

| Propriété | Type | Champ Directus |
|---|---|---|
| `ffbbserver_tournois` | `?TournoisItem` | `ffbbserver_tournois_id` |
| `ffbbserver_types_tournois_3x3` | `?TypesTournois3x3Item` | `ffbbserver_types_tournois_3x3_id` |
| `id` | `?int` |  |

### TypesAssociationsItem

Collection Directus `ffbbserver_types_associations` (schéma OpenAPI ItemsFfbbserverTypesAssociations).

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `comite` | `?bool` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `ffbb` | `?bool` |
| `id` | `?string` |
| `libelle` | `?string` |
| `ligue` | `?bool` |

### TypesCompetitionsItem

Collection Directus `ffbbserver_types_competitions` (schéma OpenAPI ItemsFfbbserverTypesCompetitions).

| Propriété | Type |
|---|---|
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `logo` | `mixed` |

### TypesDivisionsItem

Collection Directus `ffbbserver_types_divisions` (schéma OpenAPI ItemsFfbbserverTypesDivisions).

| Propriété | Type |
|---|---|
| `categorieChampionnat` | `?CategoriesChampionnatsItem` |
| `ccg` | `?int` |
| `code` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `libelle` | `?string` |
| `ordre` | `?int` |
| `point` | `?int` |
| `sexe` | `?string` |

### TypesPratiquesSportivesItem

Collection Directus `ffbbserver_types_pratiques_sportives` (schéma OpenAPI ItemsFfbbserverTypesPratiquesSportives).

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `libelle` | `?string` |

### TypesTournoisItem

Collection Directus `ffbbserver_types_tournois` (schéma OpenAPI ItemsFfbbserverTypesTournois).

| Propriété | Type |
|---|---|
| `competition` | `?bool` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `isType3x3` | `?bool` |
| `libelle` | `?string` |

### TypesTournois3x3Item

Collection Directus `ffbbserver_types_tournois3x3` (schéma OpenAPI ItemsFfbbserverTypesTournois3x3).

| Propriété | Type |
|---|---|
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?int` |
| `libelle` | `?string` |
| `logo` | `mixed` |
| `type_league` | `?string` |
| `type_tournois` | `?TypesTournoisItem` |
| `user_created` | `?string` |

### GeniusSportMatchesItem

Collection Directus `genius_sport_matches` (schéma OpenAPI ItemsGeniusSportMatches).

| Propriété | Type | Champ Directus |
|---|---|---|
| `atNeutralVenue` | `?bool` |  |
| `attendance` | `?int` |  |
| `clock` | `?string` |  |
| `competitionAbgName` | `?string` |  |
| `competitionId` | `?int` |  |
| `competitionName` | `?string` |  |
| `consolidated` | `?bool` |  |
| `currentPeriod` | `?string` |  |
| `currentStatus` | `?string` |  |
| `date_created` | `?DateTimeImmutable` |  |
| `date_updated` | `?DateTimeImmutable` |  |
| `duration` | `?int` |  |
| `external` | `?RencontresItem` | `externalId` |
| `externalCompetition` | `?CompetitionsItem` | `externalCompetitionId` |
| `extraPeriodsUsed` | `?int` |  |
| `fouls_home` | `?int` |  |
| `fouls_out` | `?int` |  |
| `leagueId` | `?int` |  |
| `liveStream` | `?bool` |  |
| `matchId` | `?string` |  |
| `matchName` | `?string` |  |
| `matchNumber` | `?int` |  |
| `matchStatus` | `?string` |  |
| `matchTime` | `?DateTimeImmutable` |  |
| `matchTimeUTC` | `?DateTimeImmutable` |  |
| `matchTimeUTC_timestamp` | `?int` |  |
| `matchTime_timestamp` | `?int` |  |
| `matchType` | `?string` |  |
| `periodStatus` | `?string` |  |
| `phaseName` | `?string` |  |
| `poolNumber` | `?int` |  |
| `roundDescription` | `?string` |  |
| `roundNumber` | `?string` |  |
| `score_home` | `?int` |  |
| `score_ot1_home` | `?int` |  |
| `score_ot1_out` | `?int` |  |
| `score_ot2_home` | `?int` |  |
| `score_ot2_out` | `?int` |  |
| `score_out` | `?int` |  |
| `score_q1_home` | `?int` |  |
| `score_q1_out` | `?int` |  |
| `score_q2_home` | `?int` |  |
| `score_q2_out` | `?int` |  |
| `score_q3_home` | `?int` |  |
| `score_q3_out` | `?int` |  |
| `score_q4_home` | `?int` |  |
| `score_q4_out` | `?int` |  |
| `socket_opened` | `?bool` |  |
| `statsSource` | `?string` |  |
| `stats_full` | `mixed` |  |
| `teamEngagement_home` | `?EngagementsItem` |  |
| `teamEngagement_out` | `?EngagementsItem` |  |
| `teamId_home` | `?int` |  |
| `teamId_out` | `?int` |  |
| `teamName_home` | `?string` |  |
| `teamName_out` | `?string` |  |
| `temperature` | `?string` |  |
| `timeActual` | `?DateTimeImmutable` |  |
| `timeActual_timestamp` | `?int` |  |
| `timeEndActual` | `?DateTimeImmutable` |  |
| `timeEndActual_timestamp` | `?int` |  |
| `timezone` | `?string` |  |
| `twitterHashtag` | `?string` |  |
| `venueId` | `?int` |  |
| `venueName` | `?string` |  |
| `weather` | `?string` |  |

### GeniusSportsLiveLogsItem

Collection Directus `genius_sports_live_logs` (schéma OpenAPI ItemsGeniusSportsLiveLogs).

| Propriété | Type |
|---|---|
| `data` | `mixed` |
| `date_created` | `?DateTimeImmutable` |
| `id` | `?int` |
| `match` | `GeniusSportMatchesItem\|int\|string\|null` |
| `type` | `?string` |

### RematchVideosItem

Collection Directus `rematch_videos` (schéma OpenAPI ItemsRematchVideos).

| Propriété | Type | Champ Directus |
|---|---|---|
| `author` | `?string` |  |
| `club1Fede` | `?OrganismesItem` | `club1FedeID` |
| `club2Fede` | `?OrganismesItem` | `club2FedeID` |
| `competitionFede` | `?CompetitionsItem` | `competitionFedeID` |
| `date` | `?DateTimeImmutable` |  |
| `date_created` | `?DateTimeImmutable` |  |
| `date_updated` | `?DateTimeImmutable` |  |
| `federation` | `?string` |  |
| `matchFede` | `?RencontresItem` | `matchFedeID` |
| `matchID` | `?string` |  |
| `placeName` | `?string` |  |
| `status` | `?string` |  |
| `thumbnailURL` | `?string` |  |
| `type` | `?string` |  |
| `user_created` | `?string` |  |
| `user_updated` | `?string` |  |
| `videoID` | `?string` |  |

### Affiche

Objet imbriqué Affiche (modèle Python, affiche.py).

| Propriété | Type |
|---|---|
| `gradient_color` | `?string` |
| `height` | `?int` |
| `id` | `?string` |
| `width` | `?int` |

### Cartographie

Objet imbriqué Cartographie (modèle Python, cartographie.py).

| Propriété | Type |
|---|---|
| `adresse` | `?string` |
| `codePostal` | `?string` |
| `coordonnees` | `?Coordonnees` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `latitude` | `?float` |
| `longitude` | `?float` |
| `status` | `?string` |
| `title` | `?string` |
| `ville` | `?string` |

### Categorie

Objet imbriqué Categorie (modèle Python, categorie.py).

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `libelle` | `?string` |
| `ordre` | `?int` |

### Commune

Objet imbriqué Commune (modèle Python, commune.py).

| Propriété | Type |
|---|---|
| `codeInsee` | `?string` |
| `codePostal` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `departement` | `?string` |
| `id` | `mixed` |
| `libelle` | `?string` |

### CompetitionID

Objet imbriqué CompetitionID (modèle Python, competition_id.py).

| Propriété | Type |
|---|---|
| `categorie` | `?CompetitionIDCategorie` |
| `code` | `?string` |
| `competition_origine` | `?CompetitionOrigine` |
| `competition_origine_nom` | `?string` |
| `creationEnCours` | `?bool` |
| `id` | `?string` |
| `liveStat` | `?bool` |
| `logo` | `?Logo` |
| `nom` | `?string` |
| `nomExtended` | `?string` |
| `pro` | `?bool` |
| `publicationInternet` | `?string` |
| `sexe` | `?string` |
| `typeCompetition` | `?string` |
| `typeCompetitionGenerique` | `?CompetitionIDTypeCompetitionGenerique` |

### CompetitionIDCategorie

Objet imbriqué CompetitionIDCategorie (modèle Python, competition_id_categorie.py).

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `libelle` | `?string` |
| `ordre` | `?int` |

### CompetitionIDTypeCompetitionGenerique

Objet imbriqué CompetitionIDTypeCompetitionGenerique (modèle Python, competition_id_type_competition_generique.py).

| Propriété | Type |
|---|---|
| `logo` | `?IDOrganismeEquipe1Logo` |

### CompetitionOrigine

Objet imbriqué CompetitionOrigine (modèle Python, competition_origine.py).

| Propriété | Type |
|---|---|
| `categorie` | `?CompetitionOrigineCategorie` |
| `code` | `?string` |
| `id` | `?string` |
| `nom` | `?string` |
| `typeCompetition` | `mixed` |
| `typeCompetitionGenerique` | `?CompetitionOrigineTypeCompetitionGenerique` |

### CompetitionOrigineCategorie

Objet imbriqué CompetitionOrigineCategorie (modèle Python, competition_origine_categorie.py).

| Propriété | Type |
|---|---|
| `ordre` | `?int` |

### CompetitionOrigineTypeCompetitionGenerique

Objet imbriqué CompetitionOrigineTypeCompetitionGenerique (modèle Python, competition_origine_type_competition_generique.py).

| Propriété | Type |
|---|---|
| `logo` | `?PurpleLogo` |

### CompetitionsHit

Hit Meilisearch de l'index `ffbbserver_competitions` (modèle Python CompetitionsHit, complété par 8 attribut(s) observé(s)).

| Propriété | Type |
|---|---|
| `age` | `mixed` |
| `categorie` | `?Categorie` |
| `code` | `?string` |
| `codeComite` | `mixed` |
| `codeLigue` | `mixed` |
| `compare_old_site` | `?bool` |
| `competition_origine` | `?string` |
| `competition_origine_niveau` | `?int` |
| `competition_origine_nom` | `?string` |
| `creationEnCours` | `?bool` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `emarqueV2` | `?bool` |
| `etat` | `?string` |
| `id` | `?string` |
| `idCompetitionPere` | `?string` |
| `liveStat` | `?bool` |
| `logo` | `?Logo` |
| `niveau` | `?string` |
| `niveau_nb` | `?int` |
| `nom` | `?string` |
| `ordre` | `?int` |
| `organisateur` | `?Organisateur` |
| `participants` | `mixed` |
| `phase_code` | `?string` |
| `phases` | `list<string>\|null` |
| `poules` | `list<Poule>\|null` |
| `pro` | `?bool` |
| `publicationInternet` | `?string` |
| `saison` | `?Saison` |
| `sexe` | `?string` |
| `slug` | `?string` |
| `thumbnail` | `?string` |
| `toUpdate` | `?bool` |
| `typeCompetition` | `?string` |
| `typeCompetitionGenerique` | `?TypeCompetitionGenerique` |

### ContentHit

Hit des index de contenu (actualités, vidéos YouTube, RSS, galeries), dont le schéma change souvent côté FFBB (miroir de GenericSearchHit) : quelques champs communs typés, le reste dans $raw.

| Propriété | Type |
|---|---|
| `id` | `int\|string\|null` |
| `title` | `?string` |
| `type` | `?string` |
| `url` | `?string` |
| `thumbnail` | `?string` |
| `date` | `?DateTimeImmutable` |

### Coordonnees

Objet imbriqué Coordonnees (modèle Python, coordonnees.py).

| Propriété | Type |
|---|---|
| `coordinates` | `list<float>\|null` |
| `type` | `?string` |

### DocumentFlyer

Objet imbriqué DocumentFlyer (modèle Python, document_flyer.py).

| Propriété | Type |
|---|---|
| `charset` | `?string` |
| `credits` | `?string` |
| `description` | `?string` |
| `duration` | `?int` |
| `embed` | `?string` |
| `filename_disk` | `?string` |
| `filename_download` | `?string` |
| `filesize` | `?int` |
| `focal_point_x` | `?float` |
| `focal_point_y` | `?float` |
| `folder` | `?Folder` |
| `gradient_color` | `?string` |
| `height` | `?int` |
| `id` | `?string` |
| `location` | `?string` |
| `md5` | `?string` |
| `metadata` | `mixed` |
| `modified_by` | `?string` |
| `modified_on` | `?DateTimeImmutable` |
| `newsbridge_labels` | `list<mixed>\|null` |
| `newsbridge_media_id` | `?string` |
| `newsbridge_metadatas` | `?string` |
| `newsbridge_mission` | `?string` |
| `newsbridge_name` | `?string` |
| `newsbridge_persons` | `list<mixed>\|null` |
| `newsbridge_recorded_at` | `?DateTimeImmutable` |
| `source` | `?string` |
| `storage` | `?string` |
| `tags` | `?string` |
| `title` | `?string` |
| `type` | `?string` |
| `uploaded_by` | `?string` |
| `uploaded_on` | `?DateTimeImmutable` |
| `width` | `?int` |

### Engagement

Objet imbriqué Engagement (modèle Python, rencontres_engagement.py).

| Propriété | Type |
|---|---|
| `id` | `?string` |

### EngagementsHit

Hit Meilisearch de l'index `ffbbserver_engagements` (modèle Python EngagementsHit).

| Propriété | Type | Champ Directus |
|---|---|---|
| `_geo` | `?Geo` |  |
| `age` | `?string` |  |
| `categorie` | `?Categorie` |  |
| `clubPro` | `?bool` |  |
| `codeAbrege` | `?string` |  |
| `codeClub` | `?string` |  |
| `codeComite` | `?string` |  |
| `codeLigue` | `?string` |  |
| `competition` | `?CompetitionOrigine` | `idCompetition` |
| `competitionsUrl` | `?string` |  |
| `gradient_color` | `?string` |  |
| `id` | `?string` |  |
| `logo` | `?string` |  |
| `niveau` | `?Categorie` |  |
| `nom` | `?string` |  |
| `nomClub` | `?string` |  |
| `nomClubPro` | `?string` |  |
| `nomComite` | `?string` |  |
| `nomCtc` | `?string` |  |
| `nomEquipe` | `?string` |  |
| `nomLigue` | `?string` |  |
| `nomOfficiel` | `?string` |  |
| `nomOrganisme` | `?string` |  |
| `nomUsuel` | `?string` |  |
| `numeroEquipe` | `?string` |  |
| `poule` | `?Poule` | `idPoule` |
| `sexe` | `?string` |  |
| `thumbnail` | `?string` |  |

### ExternalCompetitionID

Objet imbriqué ExternalCompetitionID (modèle Python, external_competition_id.py).

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `nom` | `?string` |
| `sexe` | `?string` |
| `typeCompetition` | `?string` |

### ExternalID

Objet imbriqué ExternalID (modèle Python, external_id.py).

| Propriété | Type | Champ Directus |
|---|---|---|
| `competition` | `?ExternalCompetitionID` | `competitionId` |
| `nomEquipe1` | `?string` |  |
| `nomEquipe2` | `?string` |  |
| `numeroJournee` | `?int` |  |
| `organismeEquipe1` | `?IDOrganismeEquipe` | `idOrganismeEquipe1` |
| `organismeEquipe2` | `?IDOrganismeEquipe` | `idOrganismeEquipe2` |
| `poule` | `?IDPoule` | `idPoule` |
| `salle` | `?Salle` |  |

### Folder

Objet imbriqué Folder (modèle Python, folder.py).

| Propriété | Type |
|---|---|
| `id` | `?string` |
| `name` | `?string` |
| `parent` | `?string` |

### FormationSession

Objet imbriqué FormationSession (modèle Python, formation_session.py).

| Propriété | Type |
|---|---|
| `date_end` | `?DateTimeImmutable` |
| `date_start` | `?DateTimeImmutable` |
| `entity` | `?string` |
| `id` | `?string` |
| `place` | `?string` |
| `postal_code` | `?string` |
| `reference` | `?string` |
| `subscribeBtn` | `?string` |
| `title` | `?string` |

### FormationsHit

Hit Meilisearch de l'index `ffbbserver_formations` (modèle Python FormationsHit).

| Propriété | Type |
|---|---|
| `certification` | `?string` |
| `content` | `?string` |
| `date_end` | `?DateTimeImmutable` |
| `date_end_formatted` | `?int` |
| `date_start` | `?DateTimeImmutable` |
| `date_start_formatted` | `?int` |
| `description` | `?string` |
| `domain` | `?string` |
| `duration_hours` | `mixed` |
| `entity` | `?string` |
| `files` | `list<mixed>\|null` |
| `formation_domain` | `?string` |
| `formation_duration_hours` | `?string` |
| `formation_id` | `?string` |
| `formation_image` | `?string` |
| `formation_mode` | `?string` |
| `formation_theme` | `?string` |
| `formation_thumbnail` | `?string` |
| `formation_title` | `?string` |
| `goals` | `?string` |
| `id` | `?string` |
| `id_origin_hash` | `?string` |
| `image` | `?string` |
| `level` | `?string` |
| `modalities` | `?string` |
| `mode` | `?string` |
| `mode_hidden` | `?string` |
| `pedagogy` | `?string` |
| `place` | `?string` |
| `places` | `list<string>\|null` |
| `postal_code` | `?string` |
| `postal_codes` | `list<string>\|null` |
| `prerequisites` | `?string` |
| `programIdFbi` | `?string` |
| `public` | `?string` |
| `reference` | `?string` |
| `reference_hidden` | `?string` |
| `results` | `?string` |
| `sessions` | `list<FormationSession>\|null` |
| `subscribeBtn` | `?string` |
| `subscribe_button` | `?string` |
| `theme` | `?string` |
| `thumbnail` | `?string` |
| `title` | `?string` |
| `type` | `?string` |

### Geo

Objet imbriqué Geo (modèle Python, geo.py).

| Propriété | Type |
|---|---|
| `lat` | `?float` |
| `lng` | `?float` |

### IDEngagementEquipe

Objet imbriqué IDEngagementEquipe (modèle Python, id_engagement_equipe.py).

| Propriété | Type |
|---|---|
| `id` | `?string` |
| `logo` | `?Logo` |
| `nomUsuel` | `?string` |

### IDOrganismeEquipe

Objet imbriqué IDOrganismeEquipe (modèle Python, id_organisme_equipe.py).

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `id` | `?string` |
| `logo` | `?IDOrganismeEquipe1Logo` |
| `nom` | `?string` |
| `nomClubPro` | `?string` |
| `nom_simple` | `?string` |

### IDOrganismeEquipe1Logo

Objet imbriqué IDOrganismeEquipe1Logo (modèle Python, id_organisme_equipe1_logo.py).

| Propriété | Type |
|---|---|
| `gradient_color` | `?string` |
| `id` | `?string` |

### IDPoule

Objet imbriqué IDPoule (modèle Python, id_poule.py).

| Propriété | Type |
|---|---|
| `id` | `?string` |
| `nom` | `?string` |

### Live

Match en direct (json/lives.json), modèle Python Live.

| Propriété | Type | Champ Directus |
|---|---|---|
| `clock` | `mixed` |  |
| `competitionAbgName` | `?string` |  |
| `competitionName` | `?string` |  |
| `currentPeriod` | `?string` |  |
| `currentStatus` | `?string` |  |
| `external` | `?ExternalID` | `externalId` |
| `matchId` | `?int` |  |
| `matchStatus` | `?string` |  |
| `matchTime` | `?DateTimeImmutable` |  |
| `score_home` | `?int` |  |
| `score_ot1_home` | `?int` |  |
| `score_ot1_out` | `?int` |  |
| `score_ot2_home` | `?int` |  |
| `score_ot2_out` | `?int` |  |
| `score_out` | `?int` |  |
| `score_q1_home` | `?int` |  |
| `score_q1_out` | `?int` |  |
| `score_q2_home` | `?int` |  |
| `score_q2_out` | `?int` |  |
| `score_q3_home` | `?int` |  |
| `score_q3_out` | `?int` |  |
| `score_q4_home` | `?int` |  |
| `score_q4_out` | `?int` |  |
| `teamEngagement_home` | `?TeamEngagement` |  |
| `teamEngagement_out` | `?TeamEngagement` |  |
| `teamName_home` | `?string` |  |
| `teamName_out` | `?string` |  |

### Logo

Objet imbriqué Logo (modèle Python, logo.py).

| Propriété | Type |
|---|---|
| `gradient_color` | `?string` |
| `id` | `?string` |

### NatureSol

Objet imbriqué NatureSol (modèle Python, nature_sol.py).

| Propriété | Type |
|---|---|
| `code` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `libelle` | `?string` |
| `terrain` | `?bool` |

### Organisateur

Objet imbriqué Organisateur (modèle Python, organisateur.py).

| Propriété | Type |
|---|---|
| `adresse` | `?string` |
| `adresseClubPro` | `?string` |
| `cartographie` | `?string` |
| `code` | `?string` |
| `commune` | `?string` |
| `communeClubPro` | `?string` |
| `competitions` | `list<string>\|null` |
| `dateAffiliation` | `?DateTimeImmutable` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `engagements` | `list<mixed>\|null` |
| `entreprise` | `?bool` |
| `handibasket` | `?bool` |
| `horsAssociation` | `?bool` |
| `id` | `?string` |
| `labellisation` | `list<mixed>\|null` |
| `logo` | `?string` |
| `logo_base64` | `?string` |
| `mail` | `?string` |
| `membres` | `list<int>\|null` |
| `nom` | `?string` |
| `nomClubPro` | `?string` |
| `nom_simple` | `?string` |
| `offresPratiques` | `list<mixed>\|null` |
| `omnisport` | `?bool` |
| `organisme_id_pere` | `?OrganismeIDPere` |
| `organismes_fils` | `list<int>\|null` |
| `saison_en_cours` | `?bool` |
| `salle` | `?string` |
| `telephone` | `?string` |
| `type` | `?string` |
| `type_association` | `?string` |
| `urlSiteWeb` | `?string` |

### OrganismeIDPere

Objet imbriqué OrganismeIDPere (modèle Python, organisme_id_pere.py).

| Propriété | Type |
|---|---|
| `adresse` | `?string` |
| `adresseClubPro` | `?string` |
| `cartographie` | `?string` |
| `code` | `?string` |
| `commune` | `?int` |
| `communeClubPro` | `?string` |
| `dateAffiliation` | `?DateTimeImmutable` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `engagements` | `list<mixed>\|null` |
| `entreprise` | `?bool` |
| `handibasket` | `?bool` |
| `horsAssociation` | `?bool` |
| `id` | `?int` |
| `labellisation` | `list<mixed>\|null` |
| `logo` | `?string` |
| `mail` | `?string` |
| `nom` | `?string` |
| `nomClubPro` | `?string` |
| `nom_simple` | `?string` |
| `offresPratiques` | `list<mixed>\|null` |
| `omnisport` | `?bool` |
| `organisme_id_pere` | `?self` |
| `saison_en_cours` | `?bool` |
| `salle` | `?string` |
| `telephone` | `?string` |
| `type` | `?string` |
| `type_association` | `?string` |
| `urlSiteWeb` | `?string` |

### OrganismesHit

Hit Meilisearch de l'index `ffbbserver_organismes` (modèle Python OrganismesHit, complété par 4 attribut(s) observé(s)).

| Propriété | Type |
|---|---|
| `_geo` | `?Geo` |
| `adresse` | `?string` |
| `adresseClubPro` | `?string` |
| `cartographie` | `?Cartographie` |
| `code` | `?string` |
| `code_emploi` | `mixed` |
| `commune` | `?Commune` |
| `communeClubPro` | `?Commune` |
| `dateAffiliation` | `?DateTimeImmutable` |
| `engagements_codes` | `mixed` |
| `engagements_noms` | `?string` |
| `id` | `?string` |
| `labellisation` | `list<string>\|null` |
| `logo` | `?Logo` |
| `mail` | `?string` |
| `nom` | `?string` |
| `nomClubPro` | `?string` |
| `nom_simple` | `?string` |
| `offresPratiques` | `list<string>\|null` |
| `organisme_id_pere` | `?OrganismeIDPere` |
| `saison` | `?string` |
| `saison_en_cours` | `?bool` |
| `telephone` | `?string` |
| `thumbnail` | `?string` |
| `type` | `?string` |
| `type_association` | `?TypeAssociation` |
| `urlSiteWeb` | `?string` |
| `url_competition` | `?string` |

### Poule

Objet imbriqué Poule (modèle Python, poule.py).

| Propriété | Type |
|---|---|
| `engagements` | `list<Engagement>\|null` |
| `id` | `?string` |
| `nom` | `?string` |

### PratiquesHit

Hit Meilisearch de l'index `ffbbnational_pratiques` (modèle Python PratiquesHit, complété par 3 attribut(s) observé(s)).

| Propriété | Type |
|---|---|
| `_geo` | `?Geo` |
| `action` | `?string` |
| `adresse` | `?string` |
| `adresse_salle` | `?string` |
| `adresse_structure` | `?string` |
| `affiche` | `?Affiche` |
| `assurance` | `?string` |
| `cartographie` | `?Cartographie` |
| `code` | `?string` |
| `code_structure` | `?string` |
| `cp_salle` | `?string` |
| `date_created` | `?DateTimeImmutable` |
| `date_debut` | `?DateTimeImmutable` |
| `date_debut_timestamp` | `?int` |
| `date_demande` | `?int` |
| `date_fin` | `?DateTimeImmutable` |
| `date_fin_timestamp` | `?int` |
| `date_inscription` | `?int` |
| `date_updated` | `?DateTimeImmutable` |
| `date_validation_ffbb` | `?string` |
| `date_validation_ffbb_timestamp` | `mixed` |
| `description` | `?string` |
| `email` | `?string` |
| `engagement` | `?string` |
| `facebook` | `?string` |
| `horaires_seances` | `?string` |
| `id` | `?int` |
| `inscriptions` | `?string` |
| `jours` | `list<mixed>\|null` |
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
| `thumbnail` | `?string` |
| `titre` | `?string` |
| `twitter` | `?string` |
| `type` | `?string` |
| `ville_salle` | `?string` |

### PurpleLogo

Objet imbriqué PurpleLogo (modèle Python, purple_logo.py).

| Propriété | Type |
|---|---|
| `id` | `?string` |

### RencontresHit

Hit Meilisearch de l'index `ffbbserver_rencontres` (modèle Python RencontresHit, complété par 9 attribut(s) observé(s)).

| Propriété | Type | Champ Directus |
|---|---|---|
| `_geo` | `?Geo` |  |
| `competition` | `?CompetitionID` | `competitionId` |
| `creation_timestamp` | `?int` |  |
| `date` | `?DateTimeImmutable` |  |
| `dateSaisieResultat_timestamp` | `?int` |  |
| `date_rencontre` | `?DateTimeImmutable` |  |
| `date_rencontre_timestamp` | `?int` |  |
| `date_timestamp` | `?int` |  |
| `engagementEquipe1` | `?IDEngagementEquipe` | `idEngagementEquipe1` |
| `engagementEquipe2` | `?IDEngagementEquipe` | `idEngagementEquipe2` |
| `gsId` | `?string` |  |
| `handicap1` | `?int` |  |
| `handicap2` | `?int` |  |
| `horaire` | `?string` |  |
| `id` | `?string` |  |
| `joue` | `?bool` |  |
| `modification_timestamp` | `?int` |  |
| `niveau` | `?string` |  |
| `niveau_nb` | `?int` |  |
| `nomEquipe1` | `?string` |  |
| `nomEquipe2` | `?string` |  |
| `numeroJournee` | `?int` |  |
| `officiels` | `list<mixed>\|null` |  |
| `officiels_string` | `mixed` |  |
| `organisateur` | `?Organisateur` |  |
| `organismeEquipe1` | `?IDOrganismeEquipe` | `idOrganismeEquipe1` |
| `organismeEquipe2` | `?IDOrganismeEquipe` | `idOrganismeEquipe2` |
| `poule` | `?IDPoule` | `idPoule` |
| `pratique` | `?string` |  |
| `rematch_videos` | `mixed` |  |
| `resultatEquipe1` | `?int` |  |
| `resultatEquipe2` | `?int` |  |
| `saison` | `?Saison` |  |
| `salle` | `?Salle` |  |
| `thumbnail` | `?string` |  |
| `uniqueKey` | `?string` |  |
| `url_competition` | `?string` |  |

### Saison

Objet imbriqué Saison (modèle Python, saison.py).

| Propriété | Type |
|---|---|
| `code` | `?string` |

### Salle

Objet imbriqué Salle (modèle Python, salle.py).

| Propriété | Type |
|---|---|
| `adresse` | `?string` |
| `adresseComplement` | `?string` |
| `cartographie` | `?Cartographie` |
| `id` | `?string` |
| `libelle` | `?string` |

### SallesHit

Hit Meilisearch de l'index `ffbbserver_salles` (modèle Python SallesHit).

| Propriété | Type |
|---|---|
| `_geo` | `?Geo` |
| `adresse` | `?string` |
| `adresseComplement` | `?string` |
| `capaciteSpectateur` | `?string` |
| `cartographie` | `?Cartographie` |
| `commune` | `?Commune` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?string` |
| `libelle` | `?string` |
| `libelle2` | `?string` |
| `mail` | `?string` |
| `numero` | `?string` |
| `telephone` | `?string` |
| `thumbnail` | `?string` |
| `type` | `?string` |
| `type_association` | `?TypeAssociation` |

### SearchResult

Résultat d'une recherche Meilisearch sur un index (miroir de MultiSearchResult).

| Propriété | Type |
|---|---|
| `indexUid` | `?string` |
| `hits` | `list<THit>` |
| `query` | `?string` |
| `processingTimeMs` | `?int` |
| `limit` | `?int` |
| `offset` | `?int` |
| `estimatedTotalHits` | `?int` |
| `facetDistribution` | `array<string, array<string, int>>` |
| `facetStats` | `array<string, array{min: float\|int, max: float\|int}>` |

### TeamEngagement

Objet imbriqué TeamEngagement (modèle Python, team_engagement.py).

| Propriété | Type |
|---|---|
| `codeAbrege` | `?string` |
| `logo` | `?Logo` |
| `nomOfficiel` | `?string` |
| `nomUsuel` | `?string` |

### TerrainsHit

Hit Meilisearch de l'index `ffbbserver_terrains` (modèle Python TournoisHit (le SDK Python l'associe à un autre index)).

| Propriété | Type |
|---|---|
| `_geo` | `?Geo` |
| `accesLibre` | `?bool` |
| `cartographie` | `?Cartographie` |
| `commune` | `?Commune` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `id` | `?int` |
| `largeur` | `?int` |
| `longueur` | `?int` |
| `natureSol` | `?NatureSol` |
| `nom` | `?string` |
| `numero` | `?int` |
| `rue` | `?string` |
| `thumbnail` | `?string` |
| `type` | `?string` |

### TournoiTypes3X3

Objet imbriqué TournoiTypes3X3 (modèle Python, tournoi_types_3x3.py).

| Propriété | Type |
|---|---|
| `libelle` | `?string` |
| `logo` | `?string` |
| `type_league` | `?string` |
| `type_tournois` | `?int` |

### TournoisHit

Hit Meilisearch de l'index `ffbbserver_tournois` (modèle Python TerrainsHit (le SDK Python l'associe à un autre index)).

| Propriété | Type |
|---|---|
| `_geo` | `?Geo` |
| `adresse` | `?string` |
| `adresseComplement` | `?string` |
| `ageMax` | `?int` |
| `ageMin` | `?int` |
| `cartographie` | `?Cartographie` |
| `categorieChampionnat3x3Id` | `?int` |
| `categorieChampionnat3x3Libelle` | `?string` |
| `code` | `?string` |
| `commune` | `?Commune` |
| `date_created` | `?DateTimeImmutable` |
| `date_updated` | `?DateTimeImmutable` |
| `debut` | `?DateTimeImmutable` |
| `debut_timestamp` | `?int` |
| `description` | `?string` |
| `document_flyer` | `?DocumentFlyer` |
| `fin` | `?DateTimeImmutable` |
| `fin_timestamp` | `?int` |
| `id` | `?int` |
| `mailOrganisateur` | `?string` |
| `nbParticipantPrevu` | `?int` |
| `nom` | `?string` |
| `nomOrganisateur` | `?string` |
| `sexe` | `?string` |
| `siteChoisi` | `?string` |
| `tarifOrganisateur` | `?int` |
| `telephoneOrganisateur` | `?string` |
| `thumbnail` | `?string` |
| `tournoiType` | `?string` |
| `tournoiTypes3x3` | `list<TournoiTypes3X3>\|null` |
| `urlOrganisateur` | `?string` |

### TypeAssociation

Objet imbriqué TypeAssociation (modèle Python, type_association.py).

| Propriété | Type |
|---|---|
| `libelle` | `?string` |

### TypeCompetitionGenerique

Objet imbriqué TypeCompetitionGenerique (modèle Python, type_competition_generique.py).

| Propriété | Type |
|---|---|
| `id` | `?string` |
| `logo` | `?Logo` |
