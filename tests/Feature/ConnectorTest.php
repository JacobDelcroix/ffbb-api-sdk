<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Exceptions\FfbbAuthenticationException;
use CoachBasket\Ffbb\Exceptions\FfbbServerException;
use CoachBasket\Ffbb\Requests\Directus\GetItem;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

it("envoie les en-têtes de l'app mobile et le jeton Bearer", function () {
    $mock = new MockClient([GetItem::class => directus(['id' => '1'])]);

    ffbb($mock)->getRencontre('1');

    $headers = $mock->getLastPendingRequest()->headers()->all();

    expect($headers['User-Agent'])->toBe(Config::ANDROID_USER_AGENT)
        ->and($headers['Authorization'])->toBe('Bearer api-token-1234567890')
        ->and($headers['Origin'])->toBe('https://competitions.ffbb.com')
        ->and($mock->getLastPendingRequest()->getUrl())->toBe('https://api.ffbb.com/items/ffbbserver_rencontres/1');
});

it('renvoie null sur un 404', function () {
    $mock = new MockClient([GetItem::class => MockResponse::make(['errors' => []], 404)]);

    expect(ffbb($mock)->getRencontre('404'))->toBeNull();
});

it('réessaie sur une erreur 5xx', function () {
    $mock = new MockClient([
        MockResponse::make('', 503),
        directus(['id' => '1', 'nomEquipe1' => 'OSTREVENT']),
    ]);

    expect(ffbb($mock)->getRencontre('1')->nomEquipe1)->toBe('OSTREVENT');
    expect($mock->getRecordedResponses())->toHaveCount(2);
});

it('lève une FfbbServerException après 3 essais', function () {
    $mock = new MockClient([MockResponse::make('', 500), MockResponse::make('', 500), MockResponse::make('', 500)]);

    expect(fn () => ffbb($mock)->getRencontre('1'))->toThrow(FfbbServerException::class);
});

it('change de User-Agent sur un blocage BunnyCDN puis réussit', function () {
    $agents = [];
    $mock = new MockClient([
        GetItem::class => function (PendingRequest $request) use (&$agents) {
            $agents[] = $request->headers()->get('User-Agent');

            return count($agents) === 1 ? bunnyBlock() : directus(['id' => '1']);
        },
    ]);

    expect(ffbb($mock)->getRencontre('1')->id)->toBe('1')
        ->and($agents)->toBe([Config::ANDROID_USER_AGENT, Config::ANDROID_LEGACY_USER_AGENT]);
});

it('ne réessaie pas un 403 Directus (JSON)', function () {
    $mock = new MockClient([GetItem::class => MockResponse::make(['errors' => [['extensions' => ['code' => 'FORBIDDEN']]]], 403)]);

    expect(fn () => ffbb($mock)->getRencontre('1'))->toThrow(FfbbAuthenticationException::class, 'denied by Directus');
    expect($mock->getRecordedResponses())->toHaveCount(1);
});

it('type la configuration et les lives', function () {
    $mock = new MockClient([
        \CoachBasket\Ffbb\Requests\Directus\GetConfiguration::class => directus(['id' => 1, 'key_dh' => 'dh', 'key_ms' => 'ms', 'android_version' => '2.4.1']),
        \CoachBasket\Ffbb\Requests\Directus\GetLives::class => MockResponse::make([['matchId' => 1, 'teamName_home' => 'OSTREVENT']]),
    ]);
    $client = ffbb($mock);

    expect($client->getConfiguration())->toBeInstanceOf(\CoachBasket\Ffbb\Data\ConfigurationItem::class)
        ->and($client->getConfiguration()->android_version)->toBe('2.4.1')
        ->and($client->getLives()[0])->toBeInstanceOf(\CoachBasket\Ffbb\Data\Models\Live::class)
        ->and($client->getLives()[0]->teamName_home)->toBe('OSTREVENT');
});
