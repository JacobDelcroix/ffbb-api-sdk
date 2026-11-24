<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Data\ItemMap;
use CoachBasket\Ffbb\Data\OrganismesItem;
use CoachBasket\Ffbb\Data\PoulesItem;
use CoachBasket\Ffbb\Data\RencontresItem;

it('hydrate une rencontre avec conversions tolérantes', function () {
    $rencontre = RencontresItem::fromArray([
        'id' => 'r1',
        'joue' => '1',
        'handicap1' => '0',
        'idPoule' => ['id' => '900', 'nom' => 'Poule A'],
        'idOrganismeEquipe1' => '10238',
        'champInconnu' => 'gardé',
    ]);

    expect($rencontre->joue)->toBeTrue()
        ->and($rencontre->handicap1)->toBe(0)
        ->and($rencontre->idPoule)->toBeInstanceOf(PoulesItem::class)
        ->and($rencontre->idPoule->nom)->toBe('Poule A')
        ->and($rencontre->idOrganismeEquipe1)->toBe('10238')
        ->and($rencontre->raw['champInconnu'])->toBe('gardé');
});

it('associe chaque collection à son DTO', function () {
    expect(ItemMap::for('ffbbserver_organismes'))->toBe(OrganismesItem::class)
        ->and(ItemMap::for('items/ffbbserver_rencontres'))->toBe(RencontresItem::class)
        ->and(ItemMap::for('inconnue'))->toBeNull();
});
