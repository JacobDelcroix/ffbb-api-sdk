<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Search\HitMatcher;
use CoachBasket\Ffbb\Search\Index;
use CoachBasket\Ffbb\Search\MultiSearchQuery;

it('garde un club si la requête apparaît dans son nom ou sa commune', function () {
    expect(HitMatcher::matches(Index::Organismes, ['nom' => 'OSTREVENT BASKET BALL EAA MONCHECOURT'], 'ostrevent'))->toBeTrue()
        ->and(HitMatcher::matches(Index::Organismes, ['nom' => 'X', 'commune' => ['libelle' => 'Monchecourt']], 'monche'))->toBeTrue()
        ->and(HitMatcher::matches(Index::Organismes, ['nom' => 'WAZIERS A B'], 'ostrevent'))->toBeFalse();
});

it('cherche dans les officiels au nouveau format', function () {
    $hit = ['officiels' => [['officiel' => ['nom' => 'Dupont', 'prenom' => 'Marie']]]];

    expect(HitMatcher::matches(Index::Rencontres, $hit, 'dupont marie'))->toBeTrue();
});

it('filtre un résultat et corrige estimatedTotalHits', function () {
    $result = HitMatcher::filterResult(MultiSearchQuery::for(Index::Organismes, 'Ostrevent'), [
        'hits' => [['nom' => 'OSTREVENT BASKET'], ['nom' => 'WAZIERS A B']],
        'estimatedTotalHits' => 2,
    ]);

    expect($result['hits'])->toHaveCount(1)
        ->and($result['estimatedTotalHits'])->toBe(1);
});

it('envoie les facettes par défaut de l index', function () {
    expect(MultiSearchQuery::for(Index::Organismes, 'x')->toArray())->toMatchArray([
        'indexUid' => 'ffbbserver_organismes',
        'q' => 'x',
        'facets' => ['type_association.libelle', 'type', 'labellisation', 'offresPratiques'],
        'limit' => 10,
        'offset' => 0,
    ]);
});

it('applique les règles terrains et tournois aux bons index (inversées dans le SDK Python)', function () {
    expect(HitMatcher::matches(Index::Terrains, ['nom' => 'City stade', 'rue' => 'Rue Jean Jaurès'], 'jaurès'))->toBeTrue()
        ->and(HitMatcher::matches(Index::Tournois, ['nom' => 'Open 3x3', 'nomOrganisateur' => 'Ostrevent Basket'], 'ostrevent'))->toBeTrue()
        ->and(HitMatcher::matches(Index::Terrains, ['nom' => 'City stade', 'commune' => ['libelle' => 'Monchecourt']], 'monchecourt'))->toBeTrue();
});
