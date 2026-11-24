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

    expect($indexes['ffbbsite_faq'])->toBe(['available' => true, 'attributes' => ['id', 'question'], 'estimatedTotalHits' => 1])
        ->and(array_filter($probed, static fn (string $url): bool => str_contains($url, '/indexes/ffbbsite_faq/search')))->toHaveCount(1);
});

it('marque indisponible un index qui répond en erreur', function () {
    $mock = new MockClient([SearchIndex::class => MockResponse::make(['message' => 'Index not found'], 404)]);

    expect((new Discoverer(ffbb($mock)))->indexes()['edf_teams']['available'])->toBeFalse();
});
