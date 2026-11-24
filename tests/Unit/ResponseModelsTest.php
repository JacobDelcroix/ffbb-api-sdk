<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Data\Models\Commune;
use CoachBasket\Ffbb\Data\Models\ContentHit;
use CoachBasket\Ffbb\Data\Models\Live;
use CoachBasket\Ffbb\Data\Models\OrganismesHit;
use CoachBasket\Ffbb\Data\Models\RencontresHit;
use CoachBasket\Ffbb\Data\Models\SearchResult;
use CoachBasket\Ffbb\Data\Models\TerrainsHit;
use CoachBasket\Ffbb\Support\Cast;

it('type un résultat de recherche avec ses hits et ses facettes', function () {
    $result = SearchResult::fromArray([
        'indexUid' => 'ffbbserver_organismes',
        'hits' => [['id' => '10238', 'nom' => 'OSTREVENT', 'commune' => ['libelle' => 'Monchecourt']]],
        'estimatedTotalHits' => 1,
        'processingTimeMs' => 3,
        'facetDistribution' => ['type' => ['Club' => 1]],
    ], OrganismesHit::class);

    expect($result->first())->toBeInstanceOf(OrganismesHit::class)
        ->and($result->first()->commune)->toBeInstanceOf(Commune::class)
        ->and($result->first()->commune->libelle)->toBe('Monchecourt')
        ->and($result->estimatedTotalHits)->toBe(1)
        ->and($result->facet('type'))->toBe(['Club' => 1])
        ->and($result->count())->toBe(1)
        ->and($result->isEmpty())->toBeFalse();
});

it('complète les hits avec les attributs absents du modèle Python', function () {
    $hit = RencontresHit::fromArray(['joue' => 1, 'resultatEquipe1' => '72', 'resultatEquipe2' => '65', 'date_rencontre' => '2026-11-22T15:00:00']);

    expect($hit->joue)->toBeTrue()
        ->and($hit->resultatEquipe1)->toBe(72)
        ->and($hit->resultatEquipe2)->toBe(65)
        ->and($hit->date_rencontre?->format('Y-m-d H:i'))->toBe('2026-11-22 15:00');
});

it('génère le hit terrains à partir des attributs réellement observés', function () {
    $params = array_map(
        static fn (ReflectionParameter $p): string => $p->getName(),
        (new ReflectionClass(TerrainsHit::class))->getConstructor()->getParameters(),
    );

    expect($params)->toContain('accesLibre', 'largeur', 'longueur', 'natureSol', 'rue')
        ->and($params)->not->toContain('nomOrganisateur');
});

it('hydrate un match en direct', function () {
    $live = Live::fromArray(['matchId' => '42', 'score_home' => '55', 'score_out' => 48, 'teamName_home' => 'OSTREVENT', 'clock' => '05:12']);

    expect($live->matchId)->toBe(42)
        ->and($live->score_home)->toBe(55)
        ->and($live->teamName_home)->toBe('OSTREVENT')
        ->and($live->clock)->toBe('05:12');
});

it('garde les champs communs et le brut des contenus', function () {
    $hit = ContentHit::fromArray(['id' => 7, 'title' => 'Finale', 'url' => 'https://www.ffbb.com/x', 'date_published' => '2026-11-20', 'auteur' => 'FFBB']);

    expect($hit->title)->toBe('Finale')
        ->and($hit->date?->format('Y-m-d'))->toBe('2026-11-20')
        ->and($hit->get('auteur'))->toBe('FFBB');
});

it('convertit dates ISO et timestamps', function () {
    expect(Cast::dateTime('2026-11-24')?->format('Y-m-d'))->toBe('2026-11-24')
        ->and(Cast::dateTime(1764000000)?->getTimestamp())->toBe(1764000000)
        ->and(Cast::dateTime(1764000000000)?->getTimestamp())->toBe(1764000000)
        ->and(Cast::dateTime('pas une date'))->toBeNull()
        ->and(Cast::dateTime(''))->toBeNull();
});
