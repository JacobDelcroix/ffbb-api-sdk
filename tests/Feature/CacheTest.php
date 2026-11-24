<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Auth\TokenManager;
use CoachBasket\Ffbb\Connectors\ApiFfbbConnector;
use CoachBasket\Ffbb\Connectors\MeilisearchConnector;
use CoachBasket\Ffbb\FfbbDataClient;
use CoachBasket\Ffbb\Requests\Directus\GetItem;
use CoachBasket\Ffbb\Requests\Directus\GetLives;
use CoachBasket\Ffbb\Requests\Meilisearch\MultiSearch;
use CoachBasket\Ffbb\Search\MeilisearchSearcher;
use CoachBasket\Ffbb\Support\ArrayCache;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

function cachedFfbb(MockClient $mock): FfbbDataClient
{
    $cache = new ArrayCache;
    $tokens = TokenManager::withTokens('api-token-1234567890', 'meili-token-1234567890');

    return (new FfbbDataClient(
        new ApiFfbbConnector($tokens, cache: $cache, cacheTtl: 1800),
        new MeilisearchSearcher(new MeilisearchConnector($tokens), $cache),
    ))->withMockClient($mock);
}

it('met en cache les lectures Directus', function () {
    $mock = new MockClient([GetItem::class => directus(['id' => '1'])]);
    $client = cachedFfbb($mock);

    $client->getRencontre('1');
    $client->getRencontre('1');

    expect($mock->getRecordedResponses())->toHaveCount(1);
});

it('ne met jamais les lives en cache', function () {
    $mock = new MockClient([GetLives::class => MockResponse::make([['id' => 'live']])]);
    $client = cachedFfbb($mock);

    $client->getLives();
    $client->getLives();

    expect($mock->getRecordedResponses())->toHaveCount(2);
});

it('met en cache les recherches Meilisearch', function () {
    $mock = new MockClient([MultiSearch::class => meili([['hits' => [['nom' => 'OSTREVENT']], 'estimatedTotalHits' => 1]])]);
    $client = cachedFfbb($mock);

    $client->searchOrganismes('Ostrevent');
    $result = $client->searchOrganismes('Ostrevent');

    expect($result['hits'])->toHaveCount(1)
        ->and($mock->getRecordedResponses())->toHaveCount(1);
});
