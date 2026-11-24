<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Requests\Directus\DirectusQuery;

it('construit les paramètres Directus comme le SDK Python', function () {
    $query = DirectusQuery::build(
        fields: ['id', 'nom'],
        limit: 25,
        filter: '{"idPoule":{"_eq":1}}',
        sort: ['-date_rencontre', 'numero'],
        offset: 50,
        search: 'ostrevent',
    );

    expect($query)->toBe([
        'limit' => '25',
        'fields' => 'id,nom',
        'filter' => '{"idPoule":{"_eq":1}}',
        'sort' => '-date_rencontre,numero',
        'offset' => '50',
        'search' => 'ostrevent',
    ]);
});

it("n'envoie pas un offset de 0", function () {
    expect(DirectusQuery::build(limit: 10, offset: 0))->not->toHaveKey('offset');
});

it('ajoute les paramètres supplémentaires tels quels', function () {
    expect(DirectusQuery::build(extra: ['deep[rencontres][_limit]' => '1000']))
        ->toHaveKey('deep[rencontres][_limit]', '1000');
});
