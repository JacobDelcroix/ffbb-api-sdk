<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Data\RencontresItem;
use CoachBasket\Ffbb\Discovery\Discoverer;
use CoachBasket\Ffbb\Discovery\SchemaDiff;

function spec(array $schemas): array
{
    return ['components' => ['schemas' => $schemas]];
}

it('détecte les collections et propriétés ajoutées, supprimées ou retypées', function () {
    $before = spec([
        'ItemsFfbbserverRencontres' => ['properties' => ['id' => ['type' => 'string'], 'joue' => ['type' => 'boolean'], 'ancien' => ['type' => 'string']]],
        'ItemsFfbbserverAncienne' => ['properties' => []],
    ]);
    $after = spec([
        'ItemsFfbbserverRencontres' => ['properties' => ['id' => ['type' => 'string'], 'joue' => ['type' => 'integer'], 'nouveau' => ['type' => 'string', 'format' => 'date']]],
        'ItemsFfbbserverNouvelle' => ['properties' => []],
    ]);

    $diff = SchemaDiff::compare($before, $after);

    expect($diff->addedCollections)->toBe(['ItemsFfbbserverNouvelle'])
        ->and($diff->removedCollections)->toBe(['ItemsFfbbserverAncienne'])
        ->and($diff->properties['ItemsFfbbserverRencontres'])->toBe([
            'added' => ['nouveau'],
            'removed' => ['ancien'],
            'changed' => ['joue' => ['boolean', 'integer']],
        ])
        ->and($diff->hasBreakingChanges())->toBeTrue()
        ->and($diff->toMarkdown())->toContain('`nouveau`', '`joue` : `boolean` → `integer`', 'WARNING');
});

it('détecte les attributs Meilisearch et les index disparus', function () {
    $diff = SchemaDiff::compare([], [], [
        'ffbbserver_organismes' => ['available' => true, 'attributes' => ['id', 'nom']],
        'edf_teams' => ['available' => true, 'attributes' => []],
    ], [
        'ffbbserver_organismes' => ['available' => true, 'attributes' => ['id', 'nom', 'logo']],
        'edf_teams' => ['available' => false, 'attributes' => []],
    ]);

    expect($diff->indexAttributes['ffbbserver_organismes']['added'])->toBe(['logo'])
        ->and($diff->removedIndexes)->toBe(['edf_teams']);
});

it('ne signale rien si seules les métadonnées volatiles changent', function () {
    $before = Discoverer::normalize(['info' => ['version' => 'a', 'title' => 'x'], 'components' => ['schemas' => ['ItemsA' => ['properties' => ['b' => ['type' => 'string'], 'a' => ['type' => 'string']]]]]]);
    $after = Discoverer::normalize(['components' => ['schemas' => ['ItemsA' => ['properties' => ['a' => ['type' => 'string'], 'b' => ['type' => 'string']]]]], 'info' => ['title' => 'x', 'version' => 'b']]);

    expect($before)->toBe($after)
        ->and(SchemaDiff::compare($before, $after)->hasChanges())->toBeFalse();
});

it('n a pas de dérive entre la spec enregistrée et les DTOs générés', function () {
    $spec = json_decode((string) file_get_contents(__DIR__.'/../../resources/discovery/openapi.json'), true);
    $props = array_keys($spec['components']['schemas']['ItemsFfbbserverRencontres']['properties']);
    $constructor = (new ReflectionClass(RencontresItem::class))->getConstructor();
    $params = array_map(static fn (ReflectionParameter $p): string => $p->getName(), $constructor->getParameters());

    expect(array_values(array_diff($props, $params)))->toBe([]);
});
