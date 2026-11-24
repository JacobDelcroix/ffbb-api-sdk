<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Fields\FieldLists;
use CoachBasket\Ffbb\Requests\Directus\GetItem;
use CoachBasket\Ffbb\Requests\Meilisearch\SearchIndex;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it('demande les 77 champs par défaut pour un organisme', function () {
    $mock = new MockClient([GetItem::class => directus(['id' => '10238', 'nom' => 'OSTREVENT BASKET BALL EAA MONCHECOURT'])]);

    $club = ffbb($mock)->getOrganisme(10238);
    $fields = explode(',', $mock->getLastPendingRequest()->query()->get('fields'));

    expect($club['nom'])->toBe('OSTREVENT BASKET BALL EAA MONCHECOURT')
        ->and($fields)->toHaveCount(77)
        ->and($fields)->toBe(FieldLists::ORGANISME_DEFAULT);
});

it('renvoie uniquement les équipes engagées', function () {
    $mock = new MockClient([GetItem::class => directus([
        'id' => '10238',
        'engagements' => [
            ['id' => '1', 'idCompetition' => ['id' => '500', 'nom' => 'U15 Féminine D2'], 'idPoule' => ['id' => '900', 'nom' => 'Poule A']],
        ],
    ])]);

    $client = ffbb($mock);
    $equipes = $client->getEquipes(10238);

    expect($equipes)->toHaveCount(1)
        ->and($equipes[0]['idCompetition']['nom'])->toBe('U15 Féminine D2')
        ->and($client->registry->get('900'))->toBe(['competitionId' => '500', 'pouleNom' => 'Poule A']);
});

it('reconstruit l organisme depuis Meilisearch quand Directus est bloqué', function () {
    $mock = new MockClient([
        GetItem::class => bunnyBlock(),
        SearchIndex::class => function (PendingRequest $request) {
            return str_contains($request->getUrl(), 'ffbbserver_organismes')
                ? MockResponse::make(['hits' => [['id' => '10238', 'code' => 'HDF0059038', 'nom' => 'OSTREVENT']]])
                : MockResponse::make(['hits' => [
                    ['id' => 'e1', 'codeClub' => 'HDF0059038', 'idPoule' => ['id' => '900', 'nom' => 'A'], 'idCompetition' => ['id' => '500']],
                    ['id' => 'e2', 'codeClub' => 'AUTRE'],
                ]]);
        },
    ]);

    $club = ffbb($mock)->getOrganisme(10238);

    expect($club['code'])->toBe('HDF0059038')
        ->and($club['engagements'])->toHaveCount(1)
        ->and($club['engagements'][0]['id'])->toBe('e1');
});

it('extrait les contacts du club et des dirigeants', function () {
    $mock = new MockClient([GetItem::class => directus([
        'id' => '10238',
        'nom' => 'OSTREVENT',
        'mail' => 'club@example.org',
        'membres' => [['nom' => 'DURAND', 'prenom' => 'ALICE', 'mail' => 'alice@example.org', 'codeFonction' => 'SEC']],
    ])]);

    $contacts = ffbb($mock)->getClubContacts(10238);

    expect($contacts->clubContact->email)->toBe('club@example.org')
        ->and($contacts->membres[0]->prenom)->toBe('Alice')
        ->and($contacts->membres[0]->role)->toBe('SEC');
});
