<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Exceptions\FfbbResponseValidationException;
use CoachBasket\Ffbb\Support\Json;

it('répare les JSON FFBB malformés', function () {
    expect(Json::decode('[{"id":1}],'))->toBe([['id' => 1]])
        ->and(Json::decode('[{"id":1}][{"id":2}]'))->toBe([['id' => 1], ['id' => 2]])
        ->and(Json::decode('""{"a":1}'))->toBe(['a' => 1]);
});

it('lève une exception si le JSON est irrécupérable', function () {
    expect(fn () => Json::decode('<html>'))->toThrow(FfbbResponseValidationException::class);
});

it("déballe l'enveloppe data de Directus", function () {
    expect(Json::unwrapData(['data' => ['id' => 1]]))->toBe(['id' => 1])
        ->and(Json::unwrapData([1, 2]))->toBe([1, 2]);
});
