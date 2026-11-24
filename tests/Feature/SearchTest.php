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

/**
 * Faux Meilisearch : 2500 hits au total, 1000 maximum par page, 20 sans limit (défaut Meilisearch).
 *
 * @param  list<array{int, int|null}>  $bodies
 */
function paginatedMeili(array &$bodies): MockClient
{
    return new MockClient([MultiSearch::class => function (PendingRequest $request) use (&$bodies) {
        $results = [];

        foreach ($request->body()->all()['queries'] as $query) {
            $bodies[] = [$query['offset'], $query['limit'] ?? null];
            $count = max(0, min($query['limit'] ?? 20, 1000, 2500 - $query['offset']));
            $results[] = [
                'hits' => array_map(static fn (int $i): array => ['id' => (string) ($query['offset'] + $i)], $count > 0 ? range(0, $count - 1) : []),
                'estimatedTotalHits' => 2500,
            ];
        }

        return meili($results);
    }]);
}

it('respecte limit comme plafond du nombre de hits', function () {
    $bodies = [];
    $result = ffbb(paginatedMeili($bodies))->searchRencontres('', limit: 10);

    expect($result->hits)->toHaveCount(10)
        ->and($bodies)->toBe([[0, 10]]);
});

it('complète jusqu à limit quand limit dépasse une page', function () {
    $bodies = [];
    $result = ffbb(paginatedMeili($bodies))->searchRencontres('', limit: 1500);

    expect($result->hits)->toHaveCount(1500)
        ->and($bodies)->toBe([[0, 1500], [1000, 500]]);
});

it('récupère toutes les pages jusqu à estimatedTotalHits avec limit null', function () {
    $bodies = [];
    $result = ffbb(paginatedMeili($bodies))->searchRencontres('', limit: null);

    expect($result->hits)->toHaveCount(2500)
        ->and($bodies)->toBe([[0, null], [20, 1000], [1020, 1000], [2020, 480]]);
});

it('plafonne aussi la recherche universelle par index', function () {
    $bodies = [];
    $results = ffbb(paginatedMeili($bodies))->multiSearch('', limit: 3);

    expect($results)->toHaveCount(13)
        ->and($results[0]->hits)->toHaveCount(3)
        ->and($bodies)->toHaveCount(13);
});

it('construit les filtres géographiques comme le Python', function () {
    $mock = new MockClient([MultiSearch::class => meili([['hits' => [], 'estimatedTotalHits' => 0]])]);

    ffbb($mock)->searchOrganismesByGeo(50.3, 3.2, radiusKm: 15, geoSort: GeoSortOrder::NearestFirst);
    $query = $mock->getLastPendingRequest()->body()->all()['queries'][0];

    expect($query['filter'])->toBe(['_geoRadius(50.3, 3.2, 15000)'])
        ->and($query['sort'])->toBe(['_geoPoint(50.3, 3.2):asc'])
        ->and($query['limit'])->toBe(20);
});

it('filtre les équipes par sexe et niveau sur des attributs filtrables', function () {
    $mock = new MockClient([MultiSearch::class => meili([['hits' => [], 'estimatedTotalHits' => 0]])]);

    ffbb($mock)->searchEngagementsFiltered(50.0, 3.0, sexes: ['F', 'mi'], niveauCodes: ['PRF', 'SED2F']);
    $query = $mock->getLastPendingRequest()->body()->all()['queries'][0];

    expect($query['filter'])->toBe([
        '_geoRadius(50.0, 3.0, 10000)',
        'idCompetition.sexe = "Féminin" OR idCompetition.sexe = "Mixte"',
        'niveau.code = "PRF" OR niveau.code = "SED2F"',
    ]);
});

it('traduit M en Masculin et transmet les libellés complets tels quels', function () {
    $mock = new MockClient([MultiSearch::class => meili([['hits' => [], 'estimatedTotalHits' => 0]])]);

    ffbb($mock)->searchEngagementsFiltered(50.0, 3.0, sexes: ['M', 'Féminin']);
    $query = $mock->getLastPendingRequest()->body()->all()['queries'][0];

    expect($query['filter'])->toBe([
        '_geoRadius(50.0, 3.0, 10000)',
        'idCompetition.sexe = "Masculin" OR idCompetition.sexe = "Féminin"',
    ]);
});

it('n ajoute aucun filtre de sexe ni de niveau sans critère', function () {
    $mock = new MockClient([MultiSearch::class => meili([['hits' => [], 'estimatedTotalHits' => 0]])]);

    ffbb($mock)->searchEngagementsFiltered(50.0, 3.0, sexes: [], niveauCodes: null);

    expect($mock->getLastPendingRequest()->body()->all()['queries'][0]['filter'])->toBe(['_geoRadius(50.0, 3.0, 10000)']);
});

it('cherche les clubs d une commune sur commune.libelle', function () {
    $mock = new MockClient([MultiSearch::class => meili([[
        'indexUid' => 'ffbbserver_organismes',
        'hits' => [['id' => '10238', 'nom' => 'LILLE BASKET', 'commune' => ['libelle' => 'LILLE', 'codePostal' => '59000']]],
        'estimatedTotalHits' => 1,
    ]])]);

    $result = ffbb($mock)->searchOrganismesByCity('Lille');
    $query = $mock->getLastPendingRequest()->body()->all()['queries'][0];

    expect($query['filter'])->toBe(['commune.libelle = "Lille"'])
        ->and($query['indexUid'])->toBe('ffbbserver_organismes')
        ->and($query['limit'])->toBe(200)
        ->and($result->hits)->toHaveCount(1);
});

it('échappe les guillemets dans les valeurs de filtre', function () {
    $mock = new MockClient([MultiSearch::class => meili([['hits' => [], 'estimatedTotalHits' => 0]])]);

    ffbb($mock)->searchOrganismesByCity('Saint "X" \\ Y');

    expect($mock->getLastPendingRequest()->body()->all()['queries'][0]['filter'])->toBe(['commune.libelle = "Saint \\"X\\" \\\\ Y"']);
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
