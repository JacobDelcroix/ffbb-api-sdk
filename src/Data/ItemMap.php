<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

/**
 * Collection Directus → DTO.
 *
 * FICHIER GÉNÉRÉ par bin/generate-dtos — ne pas modifier à la main.
 */
final class ItemMap
{
    /** @var array<string, class-string> */
    public const array CLASSES = [
        'configuration' => ConfigurationItem::class,
        'edf_arenas' => EdfArenasItem::class,
        'edf_campaigns' => EdfCampaignsItem::class,
        'edf_campaigns_edf_cities' => EdfCampaignsEdfCitiesItem::class,
        'edf_campaigns_edf_countries' => EdfCampaignsEdfCountriesItem::class,
        'edf_cities' => EdfCitiesItem::class,
        'edf_coaches' => EdfCoachesItem::class,
        'edf_competition_types' => EdfCompetitionTypesItem::class,
        'edf_countries' => EdfCountriesItem::class,
        'edf_matches' => EdfMatchesItem::class,
        'edf_opponents' => EdfOpponentsItem::class,
        'edf_players' => EdfPlayersItem::class,
        'edf_players_edf_positions' => EdfPlayersEdfPositionsItem::class,
        'edf_positions' => EdfPositionsItem::class,
        'edf_rosters' => EdfRostersItem::class,
        'edf_selection' => EdfSelectionItem::class,
        'edf_staffs' => EdfStaffsItem::class,
        'edf_teams' => EdfTeamsItem::class,
        'ffbbnational_categories' => CategoriesItem::class,
        'ffbbnational_galeries' => GaleriesItem::class,
        'ffbbnational_galeries_ffbbnational_tags' => GaleriesFfbbnationalTagsItem::class,
        'ffbbnational_galeries_files' => GaleriesFilesItem::class,
        'ffbbnational_pratiques' => PratiquesItem::class,
        'ffbbnational_rss' => RssItem::class,
        'ffbbnational_rss_ffbbnational_categories' => RssFfbbnationalCategoriesItem::class,
        'ffbbnational_rss_ffbbnational_tags' => RssFfbbnationalTagsItem::class,
        'ffbbnational_tags' => TagsItem::class,
        'ffbbserver_cartographies' => CartographiesItem::class,
        'ffbbserver_categories_age' => CategoriesAgeItem::class,
        'ffbbserver_categories_championnats' => CategoriesChampionnatsItem::class,
        'ffbbserver_communes' => CommunesItem::class,
        'ffbbserver_competitions' => CompetitionsItem::class,
        'ffbbserver_engagements' => EngagementsItem::class,
        'ffbbserver_entraineurs' => EntraineursItem::class,
        'ffbbserver_fonctions_officiels' => FonctionsOfficielsItem::class,
        'ffbbserver_formations' => FormationsItem::class,
        'ffbbserver_formations_domain' => FormationsDomainItem::class,
        'ffbbserver_formations_files' => FormationsFilesItem::class,
        'ffbbserver_formations_theme' => FormationsThemeItem::class,
        'ffbbserver_labellisation_label' => LabellisationLabelItem::class,
        'ffbbserver_labellisation_programme' => LabellisationProgrammeItem::class,
        'ffbbserver_labellisations_organismes' => LabellisationsOrganismesItem::class,
        'ffbbserver_membres' => MembresItem::class,
        'ffbbserver_officiels' => OfficielsItem::class,
        'ffbbserver_officiels_rencontres' => OfficielsRencontresItem::class,
        'ffbbserver_offres_pratiques' => OffresPratiquesItem::class,
        'ffbbserver_organismes' => OrganismesItem::class,
        'ffbbserver_organismes_ffbbserver_offres_pratiques' => OrganismesFfbbserverOffresPratiquesItem::class,
        'ffbbserver_organismes_ffbbserver_organismes' => OrganismesFfbbserverOrganismesItem::class,
        'ffbbserver_poules' => PoulesItem::class,
        'ffbbserver_poules_classements' => PoulesClassementsItem::class,
        'ffbbserver_rencontres' => RencontresItem::class,
        'ffbbserver_revetements' => RevetementsItem::class,
        'ffbbserver_saisons' => SaisonsItem::class,
        'ffbbserver_salles' => SallesItem::class,
        'ffbbserver_sessions' => SessionsItem::class,
        'ffbbserver_terrains' => TerrainsItem::class,
        'ffbbserver_tournois' => TournoisItem::class,
        'ffbbserver_tournois_ffbbserver_types_tournois3x3' => TournoisFfbbserverTypesTournois3x3Item::class,
        'ffbbserver_types_associations' => TypesAssociationsItem::class,
        'ffbbserver_types_competitions' => TypesCompetitionsItem::class,
        'ffbbserver_types_divisions' => TypesDivisionsItem::class,
        'ffbbserver_types_pratiques_sportives' => TypesPratiquesSportivesItem::class,
        'ffbbserver_types_tournois' => TypesTournoisItem::class,
        'ffbbserver_types_tournois3x3' => TypesTournois3x3Item::class,
        'genius_sport_matches' => GeniusSportMatchesItem::class,
        'genius_sports_live_logs' => GeniusSportsLiveLogsItem::class,
        'rematch_videos' => RematchVideosItem::class,
    ];

    /**
     * DTO d'une collection, ou null si la collection n'a pas de DTO généré.
     *
     * @return class-string|null
     */
    public static function for(string $collection): ?string
    {
        $collection = str_starts_with($collection, 'items/') ? substr($collection, 6) : $collection;

        return self::CLASSES[$collection] ?? null;
    }
}
