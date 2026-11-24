<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Exceptions\FfbbAuthenticationException;
use CoachBasket\Ffbb\Requests\Directus\GetItem;
use CoachBasket\Ffbb\Requests\Directus\ListItems;
use CoachBasket\Ffbb\Requests\Meilisearch\SearchIndex;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it('passe par le listing filtré quand Directus refuse l accès direct (saison archivée)', function () {
    $mock = new MockClient([
        GetItem::class => MockResponse::make(['errors' => [['message' => 'Forbidden']]], 403),
        ListItems::class => directus([['id' => '500', 'nom' => 'U15 F D2']]),
    ]);

    $competition = ffbb($mock)->getCompetition(500);
    $query = $mock->getLastPendingRequest()->query()->all();

    expect($competition['nom'])->toBe('U15 F D2')
        ->and($query['filter[id][_eq]'])->toBe('500')
        ->and($query['limit'])->toBe('1');
});

it('laisse remonter un blocage BunnyCDN sur une compétition', function () {
    $mock = new MockClient([GetItem::class => bunnyBlock()]);

    expect(fn () => ffbb($mock)->getCompetition(500))->toThrow(FfbbAuthenticationException::class, 'BunnyCDN');
});

it('envoie la limite deep des rencontres', function () {
    $mock = new MockClient([GetItem::class => directus(['id' => '500', 'poules' => [['id' => '900', 'nom' => 'A']]])]);

    $client = ffbb($mock);
    $client->getCompetition(500);

    expect($mock->getLastPendingRequest()->query()->get('deep[phases][poules][rencontres][_limit]'))->toBe('1000')
        ->and($client->registry->get('900')['competitionId'])->toBe('500');
});

it('renvoie la saison de repli quand Directus est indisponible', function () {
    $mock = new MockClient([ListItems::class => MockResponse::make('', 503)]);

    expect(ffbb($mock)->getSaisons())->toBe([Config::FALLBACK_SAISON]);
});

it('recalcule le classement depuis les rencontres Meilisearch', function () {
    $mock = new MockClient([
        GetItem::class => bunnyBlock(),
        SearchIndex::class => function (PendingRequest $request) {
            if (str_contains($request->getUrl(), 'ffbbserver_competitions')) {
                return MockResponse::make(['hits' => [['id' => '500', 'poules' => [['id' => '900', 'nom' => 'Poule A']]]]]);
            }

            return MockResponse::make(['hits' => [
                ['id' => 'r1', 'idPoule' => ['id' => '900'], 'joue' => true, 'nomEquipe1' => 'OSTREVENT', 'nomEquipe2' => 'DOUAI', 'resultatEquipe1' => '60', 'resultatEquipe2' => '40'],
                ['id' => 'r2', 'idPoule' => ['id' => '900'], 'joue' => 1, 'nomEquipe1' => 'DOUAI', 'nomEquipe2' => 'LENS', 'resultatEquipe1' => '55', 'resultatEquipe2' => '50'],
                ['id' => 'r3', 'idPoule' => ['id' => '901'], 'joue' => 1, 'nomEquipe1' => 'X', 'nomEquipe2' => 'Y', 'resultatEquipe1' => '1', 'resultatEquipe2' => '0'],
            ]]);
        },
    ]);

    $client = ffbb($mock);
    $client->registry->register('900', '500', 'Poule A');

    $poule = $client->getPoule(900);
    $classement = $poule['classements'];

    expect($poule['nom'])->toBe('Poule A')
        ->and($poule['rencontres'])->toHaveCount(2)
        // DOUAI : 1 victoire + 1 défaite = 3 pts ; OSTREVENT : 1 victoire = 2 pts ; LENS : 1 défaite = 1 pt.
        ->and($classement[0]['organisme']['nom'])->toBe('DOUAI')
        ->and($classement[0]['points'])->toBe(3)
        ->and($classement[1]['organisme']['nom'])->toBe('OSTREVENT')
        ->and($classement[1]['points'])->toBe(2)
        ->and($classement[1]['difference'])->toBe(20)
        ->and($classement[1]['quotient'])->toBe(1.5)
        ->and($classement[2]['organisme']['nom'])->toBe('LENS')
        ->and($classement)->toHaveCount(3);
});
