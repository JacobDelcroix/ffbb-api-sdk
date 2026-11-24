<?php

declare(strict_types=1);

use CoachBasket\Ffbb\Directus\QueryBuilder;
use CoachBasket\Ffbb\FfbbDataClient;
use CoachBasket\Ffbb\Tests\Support\ApiReference;

it('a une référence API à jour (lancer php bin/generate-api-reference)', function () {
    $root = dirname(__DIR__, 2);
    $stale = [];

    foreach (ApiReference::pages($root) as $file => $content) {
        $path = $root.'/docs/reference/'.$file;

        if (! is_file($path) || file_get_contents($path) !== $content) {
            $stale[] = $file;
        }
    }

    expect($stale)->toBe([]);
});

it('documente chaque méthode publique', function () {
    $undocumented = [];

    foreach ([FfbbDataClient::class, QueryBuilder::class] as $class) {
        foreach ((new ReflectionClass($class))->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->isConstructor() || $method->getDeclaringClass()->getName() !== $class && ! $method->getDeclaringClass()->isTrait()) {
                continue;
            }

            $summary = preg_replace('/^\s*\/\*\*|\*\/\s*$|^\s*\*\s?/m', '', (string) $method->getDocComment());

            if (trim((string) preg_replace('/@.*$/s', '', (string) $summary)) === '') {
                $undocumented[] = $method->getName();
            }
        }
    }

    expect($undocumented)->toBe([]);
});
