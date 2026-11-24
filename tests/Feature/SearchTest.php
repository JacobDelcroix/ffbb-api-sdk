<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Data\Models\OrganismesHit;
use CoachBasket\Ffbb\Data\Models\SearchResult;
use CoachBasket\Ffbb\Requests\Meilisearch\MultiSearch;
use CoachBasket\Ffbb\Search\GeoSortOrder;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\PendingRequest;

it('cherche un club et filtre les hits côté client', function () {
    $mock = new MockClient([MultiSearch::class => meili([[
        'indexUid' => 'ffbbserver_organismes',
        'hits' => [
            ['id' => '10238', 'nom' => 'OSTREVENT BASKET BALL EAA MONCHECOURT', 'code' => 'HDF0059038'],
            ['id' => '10251', 'nom' => 'WAZIERS A B', 'code' => 'HDF0059051'],
        ],
        'estimatedTotalHits' => 2,
    ]])]);

    $result = ffbb($mock)->searchOrganismes('Ostrevent');
    $body = $mock->getLastPendingRequest()->body()->all();

    expect($result)->toBeInstanceOf(SearchResult::class)
        ->and($result->hits)->toHaveCount(1)
        ->and($result->first())->toBeInstanceOf(OrganismesHit::class)
        ->and($result->first()->id)->toBe('10238')
        ->and($result->first()->code)->toBe('HDF0059038')
        ->and($body['queries'][0]['indexUid'])->toBe('ffbbserver_organismes')
        ->and($body['queries'][0]['q'])->toBe('Ostrevent')
        ->and($mock->getLastPendingRequest()->getUrl())->toBe('https://meilisearch-prod.ffbb.app/multi-search')
        ->and($mock->getLastPendingRequest()->headers()->get('Authorization'))->toBe('Bearer meili-token-1234567890');
});

it('récupère les pages suivantes jusqu à estimatedTotalHits', function () {
    $bodies = [];
    $mock = new MockClient([MultiSearch::class => function (PendingRequest $request) use (&$bodies) {
        $results = [];

        foreach ($request->body()->all()['queries'] as $query) {
            $bodies[] = [$query['offset'], $query['limit']];
            $count = min($query['limit'], 2500 - $query['offset']);
            $results[] = [
                'hits' => array_map(static fn (int $i): array => ['id' => (string) ($query['offset'] + $i)], range(0, $count - 1)),
                'estimatedTotalHits' => 2500,
            ];
        }

        return meili($results);
    }]);

    $result = ffbb($mock)->searchRencontres('', limit: 500);

    expect($result->hits)->toHaveCount(2500)
        ->and($bodies)->toBe([[0, 500], [500, 1000], [1500, 1000]]);
});

it('construit les filtres géographiques comme le Python', function () {
    $mock = new MockClient([MultiSearch::class => meili([['hits' => [], 'estimatedTotalHits' => 0]])]);

    ffbb($mock)->searchOrganismesByGeo(50.3, 3.2, radiusKm: 15, geoSort: GeoSortOrder::NearestFirst);
    $query = $mock->getLastPendingRequest()->body()->all()['queries'][0];

    expect($query['filter'])->toBe(['_geoRadius(50.3, 3.2, 15000)'])
        ->and($query['sort'])->toBe(['_geoPoint(50.3, 3.2):asc'])
        ->and($query['limit'])->toBe(20);
});

it('filtre les équipes par sexe et niveau', function () {
    $mock = new MockClient([MultiSearch::class => meili([['hits' => [], 'estimatedTotalHits' => 0]])]);

    ffbb($mock)->searchEngagementsFiltered(50.0, 3.0, sexes: ['F'], niveauCodes: ['DEP', 'REG']);
    $query = $mock->getLastPendingRequest()->body()->all()['queries'][0];

    expect($query['filter'])->toBe([
        '_geoRadius(50.0, 3.0, 10000)',
        'sexe = "F"',
        'niveau.code = "DEP" OR niveau.code = "REG"',
    ]);
});

it('interroge les 13 index pour la recherche universelle', function () {
    $mock = new MockClient([MultiSearch::class => meili(array_fill(0, 13, ['hits' => [], 'estimatedTotalHits' => 0]))]);

    $results = ffbb($mock)->multiSearch('Ostrevent');

    expect($results)->toHaveCount(13)
        ->and($results[0])->toBeInstanceOf(SearchResult::class)
        ->and($mock->getLastPendingRequest()->body()->all()['queries'])->toHaveCount(13);
});

it('renvoie null sans nom de recherche', function () {
    expect(ffbb(new MockClient([]))->searchOrganismes(null))->toBeNull();
});
