<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->

# Référence API

Référence complète générée depuis le code. Pour des exemples commentés, voir les [guides](../guides/README.md).

`FfbbDataClient` expose **110 méthodes publiques**, regroupées par type de données :

- [Client](client.md) — 6 méthodes
- [Clubs et organismes](organismes.md) — 6 méthodes
- [Compétitions, poules et classements](competitions.md) — 4 méthodes
- [Ressources unitaires](ressources.md) — 15 méthodes
- [Listes et pagination](listes.md) — 36 méthodes
- [Recherche (Meilisearch)](recherche.md) — 32 méthodes
- [Intégrations externes](externes.md) — 11 méthodes

Et aussi :

- [Query builder Directus](query-builder.md)
- [DTOs](dtos.md) — 68 DTOs Directus, 46 DTOs de réponse Meilisearch / lives
- [Exceptions](exceptions.md)

## Toutes les méthodes

| Méthode | Groupe | Description |
|---|---|---|
| [`close()`](client.md#close) | Client | Rien à fermer côté PHP (pas de session persistante) ; présent pour la parité d'API. |
| [`create()`](client.md#create) | Client | Crée un client prêt à l'emploi. |
| [`directus()`](client.md#directus) | Client | Query builder Directus complet sur n'importe quelle collection. |
| [`getClassement()`](competitions.md#getclassement) | Compétitions, poules et classements | Uniquement le classement d'une poule, trié comme le renvoie la FFBB. |
| [`getClubContacts()`](organismes.md#getclubcontacts) | Clubs et organismes | Contacts d'un club : contact du club et membres (dirigeants). |
| [`getCommune()`](ressources.md#getcommune) | Ressources unitaires | Détail d'une commune (null si introuvable). |
| [`getCompetition()`](competitions.md#getcompetition) | Compétitions, poules et classements | Détail d'une compétition avec phases, poules et rencontres imbriquées. |
| [`getConfiguration()`](ressources.md#getconfiguration) | Ressources unitaires | Configuration publique de l'app : jetons key_dh / key_ms, versions iOS / Android (null en cas d'erreur). |
| [`getEdfMatch()`](externes.md#getedfmatch) | Intégrations externes | Un match d'une équipe de France. |
| [`getEdfPlayer()`](externes.md#getedfplayer) | Intégrations externes | Un joueur ou une joueuse des équipes de France. |
| [`getEngagement()`](ressources.md#getengagement) | Ressources unitaires | Détail d'un engagement : une équipe d'un club dans une compétition / poule (null si introuvable). |
| [`getEngagementContacts()`](organismes.md#getengagementcontacts) | Clubs et organismes | Contacts d'une équipe engagée : correspondant, entraîneur et adjoint. |
| [`getEntraineur()`](ressources.md#getentraineur) | Ressources unitaires | Détail d'un entraîneur (par numéro de licence) (null si introuvable). |
| [`getEquipes()`](organismes.md#getequipes) | Clubs et organismes | Uniquement les équipes engagées d'un club, avec leur compétition et leur poule. |
| [`getFormation()`](ressources.md#getformation) | Ressources unitaires | Détail d'une formation (null si introuvable). |
| [`getGeniusSportMatch()`](externes.md#getgeniussportmatch) | Intégrations externes | Un match Genius Sports (statistiques live). |
| [`getLives()`](ressources.md#getlives) | Ressources unitaires | Matchs suivis en direct (jamais mis en cache). |
| [`getOfficiel()`](ressources.md#getofficiel) | Ressources unitaires | Détail d'un officiel (arbitre, OTM) (null si introuvable). |
| [`getOpenapiSpec()`](ressources.md#getopenapispec) | Ressources unitaires | Spécification OpenAPI exposée par Directus, en tableau (null en cas d'erreur). |
| [`getOrganisme()`](organismes.md#getorganisme) | Clubs et organismes | Détail d'un organisme : club, comité ou ligue (77 champs par défaut). |
| [`getOrganismeForSearch()`](organismes.md#getorganismeforsearch) | Clubs et organismes | Version allégée de getOrganisme() pour les contextes de recherche (31 champs). |
| [`getPoule()`](competitions.md#getpoule) | Compétitions, poules et classements | Détail d'une poule avec rencontres et classements. |
| [`getPratique()`](ressources.md#getpratique) | Ressources unitaires | Détail d'une offre de pratique (null si introuvable). |
| [`getRematchVideo()`](externes.md#getrematchvideo) | Intégrations externes | Une vidéo Rematch. |
| [`getRencontre()`](ressources.md#getrencontre) | Ressources unitaires | Détail d'une rencontre (match) : équipes, date, score, salle, officiels (null si introuvable). |
| [`getSaisons()`](competitions.md#getsaisons) | Compétitions, poules et classements | Saisons (par défaut : les saisons actives). |
| [`getSalle()`](ressources.md#getsalle) | Ressources unitaires | Détail d'une salle : nom, adresse, commune, coordonnées (null si introuvable). |
| [`getSession()`](ressources.md#getsession) | Ressources unitaires | Une session de formation (null si introuvable). |
| [`getTerrain()`](ressources.md#getterrain) | Ressources unitaires | Détail d'un terrain (3x3 / extérieur) (null si introuvable). |
| [`getTournoi()`](ressources.md#gettournoi) | Ressources unitaires | Détail d'un tournoi (null si introuvable). |
| [`iterAllCommunes()`](listes.md#iterallcommunes) | Listes et pagination | Parcourt les communes page par page, sans tout charger en mémoire. |
| [`iterAllEngagements()`](listes.md#iterallengagements) | Listes et pagination | Parcourt les équipes engagées (une équipe d'un club dans une compétition) page par page, sans tout charger en mémoire. |
| [`iterAllEntraineurs()`](listes.md#iterallentraineurs) | Listes et pagination | Parcourt les entraîneurs page par page, sans tout charger en mémoire. |
| [`iterAllFormations()`](listes.md#iterallformations) | Listes et pagination | Parcourt les formations (entraîneurs, arbitres, dirigeants) page par page, sans tout charger en mémoire. |
| [`iterAllOfficiels()`](listes.md#iterallofficiels) | Listes et pagination | Parcourt les officiels (arbitres, OTM) page par page, sans tout charger en mémoire. |
| [`iterAllPratiques()`](listes.md#iterallpratiques) | Listes et pagination | Parcourt les offres de pratique (basket santé, 3x3, micro-basket…) page par page, sans tout charger en mémoire. |
| [`iterAllRencontres()`](listes.md#iterallrencontres) | Listes et pagination | Parcourt les rencontres (matchs) page par page, sans tout charger en mémoire. |
| [`iterAllSalles()`](listes.md#iterallsalles) | Listes et pagination | Parcourt les salles (gymnases) page par page, sans tout charger en mémoire. |
| [`iterAllTerrains()`](listes.md#iterallterrains) | Listes et pagination | Parcourt les terrains 3x3 / extérieurs page par page, sans tout charger en mémoire. |
| [`iterAllTournois()`](listes.md#iteralltournois) | Listes et pagination | Parcourt les tournois (dont 3x3) page par page, sans tout charger en mémoire. |
| [`listAllCommunes()`](listes.md#listallcommunes) | Listes et pagination | Toutes les communes correspondant au filtre, toutes pages confondues (20 pages max). |
| [`listAllEngagements()`](listes.md#listallengagements) | Listes et pagination | Toutes les équipes engagées (une équipe d'un club dans une compétition) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`listAllEntraineurs()`](listes.md#listallentraineurs) | Listes et pagination | Toutes les entraîneurs correspondant au filtre, toutes pages confondues (20 pages max). |
| [`listAllFormations()`](listes.md#listallformations) | Listes et pagination | Toutes les formations (entraîneurs, arbitres, dirigeants) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`listAllOfficiels()`](listes.md#listallofficiels) | Listes et pagination | Toutes les officiels (arbitres, OTM) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`listAllPratiques()`](listes.md#listallpratiques) | Listes et pagination | Toutes les offres de pratique (basket santé, 3x3, micro-basket…) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`listAllRencontres()`](listes.md#listallrencontres) | Listes et pagination | Toutes les rencontres (matchs) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`listAllSalles()`](listes.md#listallsalles) | Listes et pagination | Toutes les salles (gymnases) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`listAllTerrains()`](listes.md#listallterrains) | Listes et pagination | Toutes les terrains 3x3 / extérieurs correspondant au filtre, toutes pages confondues (20 pages max). |
| [`listAllTournois()`](listes.md#listalltournois) | Listes et pagination | Toutes les tournois (dont 3x3) correspondant au filtre, toutes pages confondues (20 pages max). |
| [`listCommunes()`](listes.md#listcommunes) | Listes et pagination | Une page de communes. |
| [`listCompetitions()`](organismes.md#listcompetitions) | Clubs et organismes | Liste de compétitions (par défaut : id et nom). |
| [`listEdfMatches()`](externes.md#listedfmatches) | Intégrations externes | Matchs des équipes de France. |
| [`listEdfPlayers()`](externes.md#listedfplayers) | Intégrations externes | Joueurs et joueuses des équipes de France. |
| [`listEdfRosters()`](externes.md#listedfrosters) | Intégrations externes | Effectifs des équipes de France. |
| [`listEdfTeams()`](externes.md#listedfteams) | Intégrations externes | Équipes de France. |
| [`listEngagements()`](listes.md#listengagements) | Listes et pagination | Une page de équipes engagées (une équipe d'un club dans une compétition). |
| [`listEngagementsByIds()`](listes.md#listengagementsbyids) | Listes et pagination | Engagements par identifiants (lots de 50 par requête). |
| [`listEngagementsByPoule()`](listes.md#listengagementsbypoule) | Listes et pagination | Équipes engagées dans une poule. |
| [`listEngagementsByPoules()`](listes.md#listengagementsbypoules) | Listes et pagination | Équipes engagées dans plusieurs poules (lots de 50 poules par requête). |
| [`listEntraineurs()`](listes.md#listentraineurs) | Listes et pagination | Une page de entraîneurs. |
| [`listEntraineursByIds()`](listes.md#listentraineursbyids) | Listes et pagination | Entraîneurs par numéro de licence. |
| [`listFormations()`](listes.md#listformations) | Listes et pagination | Une page de formations (entraîneurs, arbitres, dirigeants). |
| [`listGeniusSportMatches()`](externes.md#listgeniussportmatches) | Intégrations externes | Matchs Genius Sports (statistiques live). |
| [`listGeniusSportsLiveLogs()`](externes.md#listgeniussportslivelogs) | Intégrations externes | Journal des événements live Genius Sports. |
| [`listOfficiels()`](listes.md#listofficiels) | Listes et pagination | Une page de officiels (arbitres, OTM). |
| [`listPratiques()`](listes.md#listpratiques) | Listes et pagination | Une page de offres de pratique (basket santé, 3x3, micro-basket…). |
| [`listRematchVideos()`](externes.md#listrematchvideos) | Intégrations externes | Vidéos Rematch. |
| [`listRencontres()`](listes.md#listrencontres) | Listes et pagination | Une page de rencontres (matchs). |
| [`listRencontresByPoule()`](listes.md#listrencontresbypoule) | Listes et pagination | Toutes les rencontres d'une poule (500 max). |
| [`listRencontresByPoules()`](listes.md#listrencontresbypoules) | Listes et pagination | Rencontres de plusieurs poules (lots de 50 poules par requête). |
| [`listSalles()`](listes.md#listsalles) | Listes et pagination | Une page de salles (gymnases). |
| [`listSessions()`](ressources.md#listsessions) | Ressources unitaires | Sessions de formation. |
| [`listTerrains()`](listes.md#listterrains) | Listes et pagination | Une page de terrains 3x3 / extérieurs. |
| [`listTournois()`](listes.md#listtournois) | Listes et pagination | Une page de tournois (dont 3x3). |
| [`multiSearch()`](recherche.md#multisearch) | Recherche (Meilisearch) | Recherche universelle sur les 13 index (un résultat par index, dans l'ordre de l'enum Index). |
| [`searchCompetitions()`](recherche.md#searchcompetitions) | Recherche (Meilisearch) | Recherche plein texte dans les compétitions (null si aucun nom). |
| [`searchEngagements()`](recherche.md#searchengagements) | Recherche (Meilisearch) | Recherche plein texte dans les équipes engagées (null si aucun nom). |
| [`searchEngagementsByGeo()`](recherche.md#searchengagementsbygeo) | Recherche (Meilisearch) | Équipes engagées dans un rayon autour d'un point GPS. |
| [`searchEngagementsFiltered()`](recherche.md#searchengagementsfiltered) | Recherche (Meilisearch) | Équipes engagées autour d'un point, filtrées par sexe et niveau. |
| [`searchFormations()`](recherche.md#searchformations) | Recherche (Meilisearch) | Recherche plein texte dans les formations (null si aucun nom). |
| [`searchGaleries()`](recherche.md#searchgaleries) | Recherche (Meilisearch) | Recherche plein texte dans les galeries photos FFBB (null si aucun nom). |
| [`searchMultipleCompetitions()`](recherche.md#searchmultiplecompetitions) | Recherche (Meilisearch) | Plusieurs recherches dans les compétitions, en un seul appel multi-search (un résultat par nom). |
| [`searchMultipleEngagements()`](recherche.md#searchmultipleengagements) | Recherche (Meilisearch) | Plusieurs recherches dans les équipes engagées, en un seul appel multi-search (un résultat par nom). |
| [`searchMultipleFormations()`](recherche.md#searchmultipleformations) | Recherche (Meilisearch) | Plusieurs recherches dans les formations, en un seul appel multi-search (un résultat par nom). |
| [`searchMultipleGaleries()`](recherche.md#searchmultiplegaleries) | Recherche (Meilisearch) | Plusieurs recherches dans les galeries photos FFBB, en un seul appel multi-search (un résultat par nom). |
| [`searchMultipleNews()`](recherche.md#searchmultiplenews) | Recherche (Meilisearch) | Plusieurs recherches dans les actualités ffbb.com, en un seul appel multi-search (un résultat par nom). |
| [`searchMultipleOrganismes()`](recherche.md#searchmultipleorganismes) | Recherche (Meilisearch) | Plusieurs recherches dans les organismes (clubs, comités, ligues), en un seul appel multi-search (un résultat par nom). |
| [`searchMultiplePratiques()`](recherche.md#searchmultiplepratiques) | Recherche (Meilisearch) | Plusieurs recherches dans les offres de pratique, en un seul appel multi-search (un résultat par nom). |
| [`searchMultipleRencontres()`](recherche.md#searchmultiplerencontres) | Recherche (Meilisearch) | Plusieurs recherches dans les rencontres, en un seul appel multi-search (un résultat par nom). |
| [`searchMultipleRss()`](recherche.md#searchmultiplerss) | Recherche (Meilisearch) | Plusieurs recherches dans les flux RSS FFBB, en un seul appel multi-search (un résultat par nom). |
| [`searchMultipleSalles()`](recherche.md#searchmultiplesalles) | Recherche (Meilisearch) | Plusieurs recherches dans les salles, en un seul appel multi-search (un résultat par nom). |
| [`searchMultipleTerrains()`](recherche.md#searchmultipleterrains) | Recherche (Meilisearch) | Plusieurs recherches dans les terrains, en un seul appel multi-search (un résultat par nom). |
| [`searchMultipleTournois()`](recherche.md#searchmultipletournois) | Recherche (Meilisearch) | Plusieurs recherches dans les tournois, en un seul appel multi-search (un résultat par nom). |
| [`searchMultipleYoutubeVideos()`](recherche.md#searchmultipleyoutubevideos) | Recherche (Meilisearch) | Plusieurs recherches dans les vidéos YouTube FFBB, en un seul appel multi-search (un résultat par nom). |
| [`searchNews()`](recherche.md#searchnews) | Recherche (Meilisearch) | Recherche plein texte dans les actualités ffbb.com (null si aucun nom). |
| [`searchOrganismes()`](recherche.md#searchorganismes) | Recherche (Meilisearch) | Recherche plein texte dans les organismes (clubs, comités, ligues) (null si aucun nom). |
| [`searchOrganismesByCity()`](recherche.md#searchorganismesbycity) | Recherche (Meilisearch) | Clubs d'une commune (correspondance exacte sur le nom de la commune). |
| [`searchOrganismesByGeo()`](recherche.md#searchorganismesbygeo) | Recherche (Meilisearch) | Clubs dans un rayon autour d'un point GPS, triés par distance. |
| [`searchPratiques()`](recherche.md#searchpratiques) | Recherche (Meilisearch) | Recherche plein texte dans les offres de pratique (null si aucun nom). |
| [`searchRencontres()`](recherche.md#searchrencontres) | Recherche (Meilisearch) | Recherche plein texte dans les rencontres (null si aucun nom). |
| [`searchRss()`](recherche.md#searchrss) | Recherche (Meilisearch) | Recherche plein texte dans les flux RSS FFBB (null si aucun nom). |
| [`searchSalles()`](recherche.md#searchsalles) | Recherche (Meilisearch) | Recherche plein texte dans les salles (null si aucun nom). |
| [`searchSallesByGeo()`](recherche.md#searchsallesbygeo) | Recherche (Meilisearch) | Salles dans un rayon autour d'un point GPS. |
| [`searchTerrains()`](recherche.md#searchterrains) | Recherche (Meilisearch) | Recherche plein texte dans les terrains (null si aucun nom). |
| [`searchTournois()`](recherche.md#searchtournois) | Recherche (Meilisearch) | Recherche plein texte dans les tournois (null si aucun nom). |
| [`searchYoutubeVideos()`](recherche.md#searchyoutubevideos) | Recherche (Meilisearch) | Recherche plein texte dans les vidéos YouTube FFBB (null si aucun nom). |
| [`warmCompetitionCache()`](client.md#warmcompetitioncache) | Client | Pré-charge une compétition et toutes ses poules dans le cache. |
| [`warmOrganismeCache()`](client.md#warmorganismecache) | Client | Pré-charge un organisme et ses équipes dans le cache. |
| [`withMockClient()`](client.md#withmockclient) | Client | Branche un MockClient Saloon sur les deux connectors (tests). |
