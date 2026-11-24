<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Data\RencontresItem;
use CoachBasket\Ffbb\Exceptions\ValidationException;
use CoachBasket\Ffbb\Requests\Directus\ListItems;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\PendingRequest;

/**
 * Simule une collection Directus de $total éléments paginée par limit/offset.
 */
function paginatedCollection(int $total, array &$calls): Closure
{
    return function (PendingRequest $request) use ($total, &$calls) {
        $limit = (int) $request->query()->get('limit');
        $offset = (int) $request->query()->get('offset', 0);
        $calls[] = [$limit, $offset];
        $count = max(0, min($limit, $total - $offset));

        return directus(array_map(static fn (int $i): array => ['id' => (string) ($offset + $i)], $count > 0 ? range(0, $count - 1) : []));
    };
}

it('pagine listAll jusqu à la page incomplète', function () {
    $calls = [];
    $mock = new MockClient([ListItems::class => paginatedCollection(250, $calls)]);

    $items = ffbb($mock)->listAllRencontres(pageSize: 100);

    expect($items)->toHaveCount(250)
        ->and($items[249]['id'])->toBe('249')
        ->and($calls)->toBe([[100, 0], [100, 100], [100, 200]]);
});

it('respecte maxItems', function () {
    $calls = [];
    $mock = new MockClient([ListItems::class => paginatedCollection(1000, $calls)]);

    expect(ffbb($mock)->listAllSalles(pageSize: 50, maxItems: 120))->toHaveCount(120);
});

it('itère paresseusement avec iterAll', function () {
    $calls = [];
    $mock = new MockClient([ListItems::class => paginatedCollection(30, $calls)]);

    $ids = [];

    foreach (ffbb($mock)->iterAllEngagements(pageSize: 10, maxItems: 25) as $engagement) {
        $ids[] = $engagement['id'];
    }

    expect($ids)->toHaveCount(25)
        ->and($calls)->toBe([[10, 0], [10, 10], [5, 20]]);
});

it('découpe listEngagementsByIds par lots de 50', function () {
    $filters = [];
    $mock = new MockClient([ListItems::class => function (PendingRequest $request) use (&$filters) {
        $filters[] = json_decode($request->query()->get('filter'), true);

        return directus([]);
    }]);

    ffbb($mock)->listEngagementsByIds(range(1, 120));

    expect($filters)->toHaveCount(3)
        ->and($filters[0]['id']['_in'])->toHaveCount(50)
        ->and($filters[2]['id']['_in'])->toHaveCount(20);
});

it('filtre les rencontres d une poule', function () {
    $mock = new MockClient([ListItems::class => directus([['id' => 'r1']])]);

    ffbb($mock)->listRencontresByPoule(900);
    $query = $mock->getLastPendingRequest()->query()->all();

    expect($query['filter'])->toBe('{"idPoule":{"_eq":900}}')
        ->and($query['limit'])->toBe('500');
});

it('valide le filtre avant tout appel', function () {
    $mock = new MockClient([]);

    expect(fn () => ffbb($mock)->listRencontres(filterCriteria: 'pas du json'))->toThrow(ValidationException::class);
});

it('expose tous les paramètres Directus via le query builder', function () {
    $mock = new MockClient([ListItems::class => directus([['id' => 'r1', 'nomEquipe1' => 'OSTREVENT']])]);

    $rencontres = ffbb($mock)->directus('ffbbserver_rencontres')
        ->fields(['id', 'nomEquipe1'])
        ->where('idPoule', '_eq', 900)
        ->sort('-date_rencontre')
        ->limit(50)
        ->get();

    $request = $mock->getLastPendingRequest();

    expect($rencontres[0]['nomEquipe1'])->toBe('OSTREVENT')
        ->and($request->getUrl())->toBe('https://api.ffbb.com/items/ffbbserver_rencontres')
        ->and($request->query()->get('sort'))->toBe('-date_rencontre')
        ->and($request->query()->get('filter'))->toBe('{"idPoule":{"_eq":900}}');
});

it('compte avec aggregate[count]', function () {
    $mock = new MockClient([ListItems::class => directus([['count' => '42']])]);

    expect(ffbb($mock)->directus('ffbbserver_engagements')->where('idPoule', '_eq', 900)->count())->toBe(42)
        ->and($mock->getLastPendingRequest()->query()->get('aggregate[count]'))->toBe('*');
});

it('renvoie des DTOs depuis le query builder', function () {
    $mock = new MockClient([ListItems::class => directus([['id' => 'r1', 'joue' => 1]])]);

    $rencontres = ffbb($mock)->directus('ffbbserver_rencontres')->getData();

    expect($rencontres[0])->toBeInstanceOf(RencontresItem::class)
        ->and($rencontres[0]->joue)->toBeTrue();
});
