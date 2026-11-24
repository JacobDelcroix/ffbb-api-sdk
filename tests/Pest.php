<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Auth\TokenManager;
use CoachBasket\Ffbb\Connectors\ApiFfbbConnector;
use CoachBasket\Ffbb\Connectors\MeilisearchConnector;
use CoachBasket\Ffbb\FfbbDataClient;
use CoachBasket\Ffbb\Search\MeilisearchSearcher;
use Saloon\Config;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

// Aucune requête réelle vers la FFBB pendant les tests, et pas d'attente entre deux essais.
Config::preventStrayRequests();
Config::sleepUsing(static fn (): null => null);

/**
 * Client sans cache, avec des jetons explicites et un MockClient branché partout.
 */
function ffbb(MockClient $mock): FfbbDataClient
{
    $tokens = TokenManager::withTokens('api-token-1234567890', 'meili-token-1234567890');

    return (new FfbbDataClient(
        new ApiFfbbConnector($tokens),
        new MeilisearchSearcher(new MeilisearchConnector($tokens)),
    ))->withMockClient($mock);
}

/**
 * Réponse Directus enveloppée dans {"data": ...}.
 */
function directus(mixed $data, int $status = 200): MockResponse
{
    return MockResponse::make(['data' => $data], $status);
}

/**
 * Page de blocage du WAF BunnyCDN.
 */
function bunnyBlock(): MockResponse
{
    return MockResponse::make('<html><body>Blocked by BunnyCDN</body></html>', 403, ['Content-Type' => 'text/html']);
}

/**
 * Réponse multi-search Meilisearch.
 *
 * @param  list<array<string, mixed>>  $results
 */
function meili(array $results): MockResponse
{
    return MockResponse::make(['results' => $results]);
}
