<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Discovery\Discoverer;
use CoachBasket\Ffbb\Requests\Meilisearch\SearchIndex;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it('sonde aussi les index déjà présents dans l instantané', function () {
    $probed = [];
    $mock = new MockClient([SearchIndex::class => function (PendingRequest $request) use (&$probed) {
        $probed[] = $request->getUrl();

        return MockResponse::make(['hits' => [['id' => '1', 'question' => 'Q']], 'estimatedTotalHits' => 1]);
    }]);

    $indexes = (new Discoverer(ffbb($mock)))->indexes(['ffbbsite_faq']);

    expect($indexes['ffbbsite_faq'])->toBe([
        'available' => true,
        'attributes' => ['id', 'question'],
        'estimatedTotalHits' => 1,
        'types' => ['id' => 'string', 'question' => 'string'],
    ])
        ->and(array_filter($probed, static fn (string $url): bool => str_contains($url, '/indexes/ffbbsite_faq/search')))->toHaveCount(1);
});

it('marque indisponible un index qui répond en erreur', function () {
    $mock = new MockClient([SearchIndex::class => MockResponse::make(['message' => 'Index not found'], 404)]);

    expect((new Discoverer(ffbb($mock)))->indexes()['edf_teams']['available'])->toBeFalse();
});

it('relève le type JSON de chaque attribut', function () {
    $mock = new MockClient([SearchIndex::class => MockResponse::make(['hits' => [
        ['joue' => null, 'score' => 10, 'note' => 1, 'tags' => ['a'], 'salle' => ['id' => '1']],
        ['joue' => true, 'score' => 12, 'note' => 1.5, 'tags' => [], 'salle' => null],
    ], 'estimatedTotalHits' => 2])]);

    $types = (new Discoverer(ffbb($mock)))->indexes()['ffbbserver_rencontres']['types'];

    expect($types)->toBe(['joue' => 'bool', 'note' => 'float', 'salle' => 'object', 'score' => 'int', 'tags' => 'array']);
});
