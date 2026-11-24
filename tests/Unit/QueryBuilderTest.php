<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Auth\TokenManager;
use CoachBasket\Ffbb\Connectors\ApiFfbbConnector;
use CoachBasket\Ffbb\Directus\QueryBuilder;

beforeEach(function () {
    $this->builder = new QueryBuilder(new ApiFfbbConnector(TokenManager::withTokens('api-token-1234567890', 'meili-token-1234567890')), 'ffbbserver_rencontres');
});

it('combine les conditions where en _and avec des champs pointés', function () {
    $query = $this->builder
        ->where('idPoule', '_eq', 123)
        ->where('idCompetition.categorie.code', '_in', ['U13', 'U15'])
        ->toQuery();

    expect(json_decode($query['filter'], true))->toBe([
        '_and' => [
            ['idPoule' => ['_eq' => 123]],
            ['idCompetition' => ['categorie' => ['code' => ['_in' => ['U13', 'U15']]]]],
        ],
    ]);
});

it('sérialise fields, sort, deep, aggregate, groupBy et meta', function () {
    $query = $this->builder
        ->fields(['id', 'nomEquipe1'])
        ->fields('idPoule.nom')
        ->sort('-date_rencontre')
        ->deep('idPoule.classements', ['_limit' => 20])
        ->aggregate('count', '*')
        ->groupBy('idPoule')
        ->withMeta('filter_count')
        ->limit(-1)
        ->toQuery();

    expect($query)->toMatchArray([
        'fields' => 'id,nomEquipe1,idPoule.nom',
        'sort' => '-date_rencontre',
        'deep' => '{"idPoule":{"classements":{"_limit":20}}}',
        'aggregate[count]' => '*',
        'groupBy' => 'idPoule',
        'meta' => 'filter_count',
        'limit' => '-1',
    ]);
});

it('accepte un filtre JSON brut', function () {
    expect($this->builder->filter('{"joue":{"_eq":1}}')->toQuery()['filter'])->toBe('{"joue":{"_eq":1}}');
});
