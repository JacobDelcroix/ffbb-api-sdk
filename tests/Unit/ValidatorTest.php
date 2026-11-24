<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Exceptions\ValidationException;
use CoachBasket\Ffbb\Support\Validator;

it('valide les filtres JSON', function () {
    expect(Validator::filterCriteria('  {"a":1} '))->toBe('{"a":1}')
        ->and(Validator::filterCriteria(''))->toBeNull()
        ->and(fn () => Validator::filterCriteria('a=1'))->toThrow(ValidationException::class);
});

it('refuse les recherches trop longues ou avec des chevrons', function () {
    expect(fn () => Validator::searchQuery(str_repeat('a', 201)))->toThrow(ValidationException::class)
        ->and(fn () => Validator::searchQuery('<script>'))->toThrow(ValidationException::class)
        ->and(Validator::searchQuery(' Ostrevent '))->toBe('Ostrevent');
});

it('valide les jetons', function () {
    expect(fn () => Validator::token('court'))->toThrow(ValidationException::class, 'too short')
        ->and(Validator::token(' abcdefghijkl '))->toBe('abcdefghijkl');
});

it('refuse un offset négatif', function () {
    expect(fn () => Validator::offset(-1))->toThrow(ValidationException::class);
});
