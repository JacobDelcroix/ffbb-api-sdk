<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Auth\TokenManager;
use CoachBasket\Ffbb\Auth\TokenSource;
use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Requests\Directus\GetConfiguration;
use CoachBasket\Ffbb\Support\ArrayCache;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it('récupère les jetons via items/configuration et les met en cache', function () {
    $cache = new ArrayCache;
    $mock = new MockClient([
        GetConfiguration::class => MockResponse::make(['data' => ['id' => 1, 'key_dh' => 'dh-token', 'key_ms' => 'ms-token']]),
    ]);

    $tokens = (new TokenManager($cache, mockClient: $mock, hosts: ['https://api.ffbb.com/']))->getTokens();

    expect($tokens->apiToken)->toBe('dh-token')
        ->and($tokens->meilisearchToken)->toBe('ms-token')
        ->and($tokens->source)->toBe(TokenSource::Configuration)
        ->and($cache->get(TokenManager::CACHE_KEY)['api_token'])->toBe('dh-token');
});

it("change de User-Agent quand BunnyCDN bloque, comme l'app", function () {
    $userAgents = [];
    $mock = new MockClient([
        GetConfiguration::class => function (PendingRequest $request) use (&$userAgents) {
            $userAgents[] = $request->headers()->get('User-Agent');

            return count($userAgents) === 1
                ? MockResponse::make('<html>BunnyCDN</html>', 403, ['Content-Type' => 'text/html'])
                : MockResponse::make(['data' => ['key_dh' => 'dh', 'key_ms' => 'ms']]);
        },
    ]);

    $tokens = (new TokenManager(mockClient: $mock, hosts: ['https://api.ffbb.com/']))->getTokens();

    expect($tokens->apiToken)->toBe('dh')
        ->and($userAgents[0])->toBe(Config::ANDROID_USER_AGENT)
        ->and($userAgents[1])->toBe(Config::ANDROID_LEGACY_USER_AGENT);
});

it('retombe sur les jetons publics si tous les hôtes échouent', function () {
    $mock = new MockClient([GetConfiguration::class => MockResponse::make('', 500)]);

    $tokens = (new TokenManager(mockClient: $mock))->getTokens();

    expect($tokens->source)->toBe(TokenSource::Fallback)
        ->and($tokens->apiToken)->toBe(Config::DEFAULT_FALLBACK_API_TOKEN);
});

it('privilégie les variables d environnement', function () {
    putenv(Config::ENV_API_TOKEN.'=env-api-token');
    putenv(Config::ENV_MEILISEARCH_TOKEN.'=env-meili-token');

    try {
        $tokens = (new TokenManager)->getTokens();

        expect($tokens->source)->toBe(TokenSource::Environment)
            ->and($tokens->apiToken)->toBe('env-api-token');
    } finally {
        putenv(Config::ENV_API_TOKEN);
        putenv(Config::ENV_MEILISEARCH_TOKEN);
    }
});
