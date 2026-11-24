<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Data\EdfPlayersItem;
use CoachBasket\Ffbb\Data\EngagementsItem;
use CoachBasket\Ffbb\Data\ItemMap;
use CoachBasket\Ffbb\Data\Models\RencontresHit;
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
        ->and($rencontre->poule)->toBeInstanceOf(PoulesItem::class)
        ->and($rencontre->poule->nom)->toBe('Poule A')
        ->and($rencontre->organismeEquipe1)->toBeInstanceOf(OrganismesItem::class)
        ->and($rencontre->organismeEquipe1->id)->toBe('10238')
        ->and($rencontre->organismeEquipe1->nom)->toBeNull()
        ->and($rencontre->raw['champInconnu'])->toBe('gardé');
});

it('associe chaque collection à son DTO', function () {
    expect(ItemMap::for('ffbbserver_organismes'))->toBe(OrganismesItem::class)
        ->and(ItemMap::for('items/ffbbserver_rencontres'))->toBe(RencontresItem::class)
        ->and(ItemMap::for('inconnue'))->toBeNull();
});

it('nomme les relations sans leur préfixe de clé étrangère', function () {
    $engagement = EngagementsItem::fromArray([
        'idPoule' => ['id' => '900', 'nom' => 'Poule A'],
        'idCompetition' => '500',
    ]);

    expect($engagement->poule->nom)->toBe('Poule A')
        ->and($engagement->competition->id)->toBe('500')
        ->and(EngagementsItem::DIRECTUS_FIELDS)->toHaveKey('poule', 'idPoule')
        ->and(RencontresHit::DIRECTUS_FIELDS)->toHaveKey('competition', 'competitionId');
});

it('garde le nom Directus quand le nom naturel est déjà pris', function () {
    $params = array_map(
        static fn (ReflectionParameter $p): string => $p->getName(),
        (new ReflectionClass(EdfPlayersItem::class))->getConstructor()->getParameters(),
    );

    expect($params)->toContain('first_selection', 'first_selection_id');
});
