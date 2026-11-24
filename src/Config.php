<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb;

/**
 * Configuration centralisée, miroir de `ffbb_data_client/config.py`.
 *
 * Toute valeur ici est synchronisée depuis le SDK Python (voir bin/sync-upstream).
 * Les valeurs surchargeables le sont via variables d'environnement, comme en Python.
 */
final class Config
{
    // ------------------------------------------------------------------
    // URLs
    // ------------------------------------------------------------------

    public const string API_FFBB_BASE_URL = 'https://api.ffbb.com/';

    public const string MEILISEARCH_BASE_URL = 'https://meilisearch-prod.ffbb.app/';

    /** Hôtes Directus essayés dans l'ordre pour récupérer /items/configuration. */
    public const array CONFIGURATION_HOSTS = [
        'https://api.ffbb.com/',
        'https://api.ffbb.app/',
        'https://bo.ffbb.com/',
        'https://bo.ffbb.app/',
    ];

    // ------------------------------------------------------------------
    // User-Agents (app mobile officielle)
    // ------------------------------------------------------------------

    public const string ANDROID_USER_AGENT = 'FFBB/2.4.1 (Linux; U; Android 14; com.ffbb.ffbb; Build/2412)';

    public const string ANDROID_LEGACY_USER_AGENT = 'FFBB/1.6.7.42 Dalvik/2.1.0 (Linux; U; Android 5.1.1; Android SDK built for x86 Build/LMY48X)';

    public const string IOS_USER_AGENT = 'FFBB/2.4.1 (iPhone; iOS 18.0; Scale/3.00)';

    public const string SAFARI_USER_AGENT = 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148';

    // ------------------------------------------------------------------
    // Variables d'environnement
    // ------------------------------------------------------------------

    public const string ENV_API_TOKEN = 'API_FFBB_APP_BEARER_TOKEN';

    public const string ENV_MEILISEARCH_TOKEN = 'MEILISEARCH_BEARER_TOKEN';

    public const string ENV_API_BASE_URL = 'API_FFBB_BASE_URL';

    public const string ENV_MEILISEARCH_URL = 'MEILISEARCH_URL';

    public const string ENV_USER_AGENT = 'FFBB_USER_AGENT';

    /**
     * Jetons publics de repli, repris tels quels du SDK Python (config.py),
     * utilisés si /items/configuration est inaccessible.
     */
    public const string DEFAULT_FALLBACK_API_TOKEN = 'bvBdsqADOnQmvFNzDRQnzYYw2g2J1ad6';

    public const string DEFAULT_FALLBACK_MEILISEARCH_TOKEN = '98f07e4d3869853c218a0f65edce2ae56cc670728d9bcb8b035a5107ce1b55dc';

    // ------------------------------------------------------------------
    // Endpoints Directus (relatifs à l'URL de base)
    // ------------------------------------------------------------------

    public const string ENDPOINT_CONFIGURATION = 'items/configuration';

    public const string ENDPOINT_LIVES = 'json/lives.json';

    public const string ENDPOINT_COMPETITIONS = 'items/ffbbserver_competitions';

    public const string ENDPOINT_POULES = 'items/ffbbserver_poules';

    public const string ENDPOINT_SAISONS = 'items/ffbbserver_saisons';

    public const string ENDPOINT_ORGANISMES = 'items/ffbbserver_organismes';

    public const string ENDPOINT_RENCONTRES = 'items/ffbbserver_rencontres';

    public const string ENDPOINT_ENGAGEMENTS = 'items/ffbbserver_engagements';

    public const string ENDPOINT_FORMATIONS = 'items/ffbbserver_formations';

    public const string ENDPOINT_ENTRAINEURS = 'items/ffbbserver_entraineurs';

    public const string ENDPOINT_COMMUNES = 'items/ffbbserver_communes';

    public const string ENDPOINT_OFFICIELS = 'items/ffbbserver_officiels';

    public const string ENDPOINT_SALLES = 'items/ffbbserver_salles';

    public const string ENDPOINT_TERRAINS = 'items/ffbbserver_terrains';

    public const string ENDPOINT_TOURNOIS = 'items/ffbbserver_tournois';

    public const string ENDPOINT_PRATIQUES = 'items/ffbbnational_pratiques';

    public const string ENDPOINT_SESSIONS = 'items/ffbbserver_sessions';

    public const string ENDPOINT_GENIUS_SPORT_MATCHES = 'items/genius_sport_matches';

    public const string ENDPOINT_GENIUS_SPORTS_LIVE_LOGS = 'items/genius_sports_live_logs';

    public const string ENDPOINT_REMATCH_VIDEOS = 'items/rematch_videos';

    public const string ENDPOINT_EDF_MATCHES = 'items/edf_matches';

    public const string ENDPOINT_EDF_PLAYERS = 'items/edf_players';

    public const string ENDPOINT_EDF_ROSTERS = 'items/edf_rosters';

    public const string ENDPOINT_EDF_TEAMS = 'items/edf_teams';

    public const string ENDPOINT_EDF_ARENAS = 'items/edf_arenas';

    public const string ENDPOINT_EDF_CAMPAIGNS = 'items/edf_campaigns';

    public const string ENDPOINT_EDF_CITIES = 'items/edf_cities';

    public const string ENDPOINT_EDF_COACHES = 'items/edf_coaches';

    public const string ENDPOINT_EDF_COMPETITION_TYPES = 'items/edf_competition_types';

    public const string ENDPOINT_EDF_COUNTRIES = 'items/edf_countries';

    public const string ENDPOINT_EDF_OPPONENTS = 'items/edf_opponents';

    public const string ENDPOINT_EDF_POSITIONS = 'items/edf_positions';

    public const string ENDPOINT_EDF_SELECTION = 'items/edf_selection';

    public const string ENDPOINT_EDF_STAFFS = 'items/edf_staffs';

    public const string ENDPOINT_ASSETS = 'assets/';

    public const string ENDPOINT_OPENAPI = 'server/specs/oas';

    // ------------------------------------------------------------------
    // Meilisearch
    // ------------------------------------------------------------------

    public const string MEILISEARCH_ENDPOINT_MULTI_SEARCH = 'multi-search';

    public const string MEILISEARCH_INDEX_ORGANISMES = 'ffbbserver_organismes';

    public const string MEILISEARCH_INDEX_RENCONTRES = 'ffbbserver_rencontres';

    public const string MEILISEARCH_INDEX_TERRAINS = 'ffbbserver_terrains';

    public const string MEILISEARCH_INDEX_SALLES = 'ffbbserver_salles';

    public const string MEILISEARCH_INDEX_TOURNOIS = 'ffbbserver_tournois';

    public const string MEILISEARCH_INDEX_COMPETITIONS = 'ffbbserver_competitions';

    public const string MEILISEARCH_INDEX_ENGAGEMENTS = 'ffbbserver_engagements';

    public const string MEILISEARCH_INDEX_FORMATIONS = 'ffbbserver_formations';

    public const string MEILISEARCH_INDEX_PRATIQUES = 'ffbbnational_pratiques';

    public const string MEILISEARCH_INDEX_NEWS = 'ffbbsite_news';

    public const string MEILISEARCH_INDEX_YOUTUBE_VIDEOS = 'youtube_videos';

    public const string MEILISEARCH_INDEX_RSS = 'ffbbnational_rss';

    public const string MEILISEARCH_INDEX_GALERIES = 'ffbbnational_galeries';

    // ------------------------------------------------------------------
    // Comportement (mêmes valeurs que le Python)
    // ------------------------------------------------------------------

    /** RetryConfig.max_attempts */
    public const int MAX_ATTEMPTS = 3;

    /** RetryConfig.base_delay (secondes) */
    public const int RETRY_BASE_DELAY_MS = 1000;

    /** Codes HTTP qui déclenchent un nouvel essai. */
    public const array RETRY_ON_STATUS_CODES = [429, 500, 502, 503, 504];

    /** TimeoutConfig */
    public const float CONNECT_TIMEOUT = 10.0;

    public const float READ_TIMEOUT = 30.0;

    /** TTL du cache applicatif Meilisearch (_APP_CACHE_TTL). */
    public const int MEILISEARCH_CACHE_TTL = 300;

    /** Taille de lot pour les méthodes *_by_ids / *_by_poules. */
    public const int BATCH_CHUNK_SIZE = 50;

    /** Plafond Meilisearch par page lors de la pagination récursive. */
    public const int MEILISEARCH_PAGE_SIZE_CAP = 1000;

    /** Nombre de sous-requêtes par appel multi-search lors de la pagination. */
    public const int MEILISEARCH_BATCH_SIZE = 10;

    /** Filtre par défaut de get_saisons(). */
    public const string DEFAULT_SAISONS_FILTER = '{"actif":{"_eq":true}}';

    /** Saison de repli renvoyée par get_saisons() quand Directus est bloqué. */
    public const array FALLBACK_SAISON = [
        'id' => '1037',
        'nom' => '2026-2027',
        'code' => '26-27',
        'actif' => true,
        'enCours' => true,
        'libelle' => 'Saison 2026-2027',
    ];

    /**
     * User-Agent par défaut (surchargeable via FFBB_USER_AGENT).
     */
    public static function userAgent(): string
    {
        $fromEnv = getenv(self::ENV_USER_AGENT);

        return is_string($fromEnv) && $fromEnv !== '' ? $fromEnv : self::ANDROID_USER_AGENT;
    }

    /**
     * Liste ordonnée et dédupliquée des User-Agents à essayer en cas de blocage WAF.
     *
     * @return list<string>
     */
    public static function fallbackUserAgents(): array
    {
        return array_values(array_unique([
            self::userAgent(),
            self::ANDROID_USER_AGENT,
            self::ANDROID_LEGACY_USER_AGENT,
            self::IOS_USER_AGENT,
            self::SAFARI_USER_AGENT,
        ]));
    }

    public static function apiBaseUrl(): string
    {
        $fromEnv = getenv(self::ENV_API_BASE_URL);
        $url = is_string($fromEnv) && $fromEnv !== '' ? $fromEnv : self::API_FFBB_BASE_URL;

        return rtrim($url, '/').'/';
    }

    public static function meilisearchBaseUrl(): string
    {
        $fromEnv = getenv(self::ENV_MEILISEARCH_URL);
        $url = is_string($fromEnv) && $fromEnv !== '' ? $fromEnv : self::MEILISEARCH_BASE_URL;

        return rtrim($url, '/').'/';
    }

    /**
     * En-têtes « navigateur / app mobile » envoyés par défaut (anti-profilage WAF).
     *
     * @return array<string, string>
     */
    public static function defaultHeaders(?string $userAgent = null): array
    {
        return [
            'User-Agent' => $userAgent ?? self::userAgent(),
            'Accept' => 'application/json, text/plain, */*',
            'Accept-Language' => 'fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7',
            'Referer' => 'https://competitions.ffbb.com/',
            'Origin' => 'https://competitions.ffbb.com',
            'Sec-Fetch-Dest' => 'empty',
            'Sec-Fetch-Mode' => 'cors',
            'Sec-Fetch-Site' => 'same-site',
        ];
    }
}
