<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Jetons Bearer
    |--------------------------------------------------------------------------
    |
    | Laissés à null, ils sont résolus automatiquement via l'endpoint public
    | items/configuration (puis mis en cache), comme l'app mobile FFBB.
    |
    */

    'api_token' => env('API_FFBB_APP_BEARER_TOKEN'),

    'meilisearch_token' => env('MEILISEARCH_BEARER_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    */

    'api_base_url' => env('API_FFBB_BASE_URL', 'https://api.ffbb.com/'),

    'meilisearch_base_url' => env('MEILISEARCH_URL', 'https://meilisearch-prod.ffbb.app/'),

    /*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    |
    | store : store Laravel utilisé (null = store par défaut).
    | ttl   : durée de vie des réponses Directus en secondes (null = pas de cache).
    |
    */

    'cache' => [
        'store' => env('FFBB_CACHE_STORE'),
        'ttl' => (int) env('FFBB_CACHE_TTL', 1800),
    ],

];
