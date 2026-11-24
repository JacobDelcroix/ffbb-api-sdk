<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\FfbbDataClient;
use CoachBasket\Ffbb\Fields\FieldLists;
use CoachBasket\Ffbb\Search\Index;

/*
 * Garde-fous de synchronisation avec le SDK Python.
 *
 * resources/upstream/*.json est régénéré par `composer sync-upstream` (tools/extract_upstream.py).
 * Si le Python ajoute une méthode, un endpoint ou change une valeur, ces tests échouent
 * dans la PR de synchro : c'est le signal qu'il faut porter le changement.
 */

function upstream(string $file): array
{
    return json_decode((string) file_get_contents(__DIR__.'/../../resources/upstream/'.$file), true, flags: JSON_THROW_ON_ERROR);
}

/**
 * Nom PHP attendu pour une méthode Python (snake_case → camelCase, aiter_all_x → iterAllX).
 */
function phpMethodName(string $python): string
{
    $python = preg_replace('/^aiter_all_/', 'iter_all_', $python);

    return lcfirst(str_replace('_', '', ucwords($python, '_')));
}

it('expose chaque méthode publique du SDK Python', function () {
    $missing = array_values(array_filter(
        upstream('methods.json'),
        static fn (string $method): bool => ! method_exists(FfbbDataClient::class, phpMethodName($method)),
    ));

    expect($missing)->toBe([]);
});

it('reprend les endpoints et index Meilisearch du Python', function () {
    $drift = [];

    foreach (upstream('config.json') as $name => $value) {
        if (! preg_match('/^(ENDPOINT_|MEILISEARCH_INDEX_|MEILISEARCH_ENDPOINT_|DEFAULT_FALLBACK_|API_FFBB_BASE_URL$|MEILISEARCH_BASE_URL$)/', $name)
            || $name === 'MEILISEARCH_INDEX_UIDS') {
            continue;
        }

        $constant = Config::class.'::'.$name;

        if (! defined($constant) || constant($constant) !== $value) {
            $drift[$name] = $value;
        }
    }

    expect($drift)->toBe([]);
});

it('reprend les User-Agents du Python', function () {
    $config = upstream('config.json');

    expect(Config::ANDROID_USER_AGENT)->toBe($config['DEFAULT_ANDROID_USER_AGENT'])
        ->and(Config::ANDROID_LEGACY_USER_AGENT)->toBe($config['DEFAULT_ANDROID_LEGACY_USER_AGENT'])
        ->and(Config::IOS_USER_AGENT)->toBe($config['DEFAULT_IOS_USER_AGENT'])
        ->and(Config::SAFARI_USER_AGENT)->toBe($config['DEFAULT_SAFARI_USER_AGENT']);
});

it('reprend les facettes Meilisearch du Python', function () {
    $drift = [];

    foreach (upstream('config.json') as $name => $value) {
        if (! str_starts_with($name, 'MEILISEARCH_FACETS_')) {
            continue;
        }

        $index = Index::from(upstream('config.json')['MEILISEARCH_INDEX_'.substr($name, strlen('MEILISEARCH_FACETS_'))]);

        if ($index->facets() !== $value) {
            $drift[$name] = $value;
        }
    }

    expect($drift)->toBe([]);
});

it('a des listes de champs à jour', function () {
    $drift = [];

    foreach (upstream('fields.json') as $key => $fields) {
        [$entity, $method] = explode('.', $key, 2);
        $constant = FieldLists::class.'::'.strtoupper($entity.'_'.preg_replace('/^get_(.+)_fields$/', '$1', $method));

        if (! defined($constant) || constant($constant) !== $fields) {
            $drift[] = $key;
        }
    }

    expect($drift)->toBe([]);
});
