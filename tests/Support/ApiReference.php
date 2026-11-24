<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Tests\Support;

use CoachBasket\Ffbb\Concerns\ListsResources;
use CoachBasket\Ffbb\Concerns\ManagesCompetitions;
use CoachBasket\Ffbb\Concerns\ManagesExternalResources;
use CoachBasket\Ffbb\Concerns\ManagesOrganismes;
use CoachBasket\Ffbb\Concerns\ManagesResources;
use CoachBasket\Ffbb\Concerns\SearchesMeilisearch;
use CoachBasket\Ffbb\Data\ItemMap;
use CoachBasket\Ffbb\Directus\QueryBuilder;
use CoachBasket\Ffbb\Exceptions;
use CoachBasket\Ffbb\FfbbDataClient;
use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;
use UnitEnum;

/**
 * Construit la référence API Markdown à partir du code (réflexion + docblocks).
 *
 * Utilisé par bin/generate-api-reference et par tests/Unit/DocumentationTest.php.
 */
final class ApiReference
{
    /**
     * Groupes de méthodes de FfbbDataClient : fichier => [titre, source, introduction, guide].
     *
     * @var array<string, array{0: string, 1: class-string|null, 2: string, 3: string}>
     */
    private const array GROUPS = [
        'client.md' => [
            'Client',
            null,
            'Création du client, query builder Directus, préchargement du cache.',
            '../guides/01-demarrage.md',
        ],
        'organismes.md' => [
            'Clubs et organismes',
            ManagesOrganismes::class,
            "Organismes FFBB (clubs, comités, ligues), équipes engagées et contacts.\nUn « organisme » se désigne par son **identifiant numérique** (ex. `10238`), pas par son code (`HDF0059038`) : voir `searchOrganismes()` pour passer de l'un à l'autre.",
            '../guides/02-clubs-et-equipes.md',
        ],
        'competitions.md' => [
            'Compétitions, poules et classements',
            ManagesCompetitions::class,
            'Compétitions avec leurs phases et poules, détail d\'une poule (rencontres + classement), saisons.',
            '../guides/03-competitions-poules-classements.md',
        ],
        'ressources.md' => [
            'Ressources unitaires',
            ManagesResources::class,
            'Lecture d\'un élément par identifiant (rencontre, engagement, salle…), lives, configuration, spec OpenAPI.',
            '../guides/04-rencontres-et-listes.md',
        ],
        'listes.md' => [
            'Listes et pagination',
            ListsResources::class,
            "Pour chaque ressource : `list{X}()` (une page), `listAll{X}()` (toutes les pages, en mémoire) et `iterAll{X}()` (générateur paresseux).\nLes filtres sont des filtres Directus en JSON, ex. `{\"idPoule\":{\"_eq\":900}}`.",
            '../guides/04-rencontres-et-listes.md',
        ],
        'recherche.md' => [
            'Recherche (Meilisearch)',
            SearchesMeilisearch::class,
            "Recherche plein texte et géographique.\nChaque résultat est le tableau Meilisearch d'une requête : `hits`, `estimatedTotalHits`, `facetDistribution`… Comme dans le SDK Python, toutes les pages sont récupérées et les hits sont filtrés côté client.",
            '../guides/05-recherche.md',
        ],
        'externes.md' => [
            'Intégrations externes',
            ManagesExternalResources::class,
            'Collections Directus des partenaires de la FFBB : Genius Sports (stats live), Rematch (vidéos), équipes de France (EDF).',
            '../guides/04-rencontres-et-listes.md',
        ],
    ];

    /**
     * Description par défaut des paramètres récurrents (quand le docblock n'en donne pas).
     *
     * @var array<string, string>
     */
    private const array PARAM_DESCRIPTIONS = [
        'id' => 'Identifiant Directus de l\'élément.',
        'organismeId' => 'Identifiant numérique de l\'organisme (ex. `10238`), pas son code `HDF…`.',
        'competitionId' => 'Identifiant de la compétition.',
        'pouleId' => 'Identifiant de la poule.',
        'pouleIds' => 'Identifiants de poules.',
        'ids' => 'Identifiants (découpés en lots de 50).',
        'fields' => 'Champs Directus à renvoyer, notation pointée pour les relations (`idPoule.nom`, `engagements.*`). Par défaut : le jeu de champs du SDK Python.',
        'deepLimit' => 'Nombre maximum d\'éléments imbriqués (rencontres, classements) renvoyés par Directus.',
        'limit' => 'Nombre maximum d\'éléments (Meilisearch : taille de la première page, les suivantes sont récupérées automatiquement).',
        'filterCriteria' => 'Filtre Directus en JSON, ex. `{"idPoule":{"_eq":900}}`.',
        'sort' => 'Champs de tri ; préfixe `-` pour un tri décroissant (Meilisearch : `champ:asc` / `champ:desc`).',
        'offset' => 'Nombre d\'éléments à sauter.',
        'search' => 'Recherche plein texte Directus.',
        'pageSize' => 'Taille de chaque page demandée à Directus.',
        'maxItems' => 'Nombre maximum d\'éléments renvoyés au total.',
        'name' => 'Texte recherché (null : aucune requête).',
        'names' => 'Textes recherchés, un résultat par texte.',
        'filter' => 'Filtres Meilisearch, ex. `[\'sexe = "F"\']` (combinés en ET).',
        'lat' => 'Latitude du point de référence.',
        'lng' => 'Longitude du point de référence.',
        'radiusKm' => 'Rayon de recherche en kilomètres.',
        'q' => 'Texte recherché en plus du filtre (chaîne vide : tous).',
        'geoSort' => 'Ordre de tri par distance.',
        'cityName' => 'Nom exact de la commune.',
        'sexes' => 'Sexes à garder : `F`, `M`…',
        'niveauCodes' => 'Codes de niveau à garder, ex. `DEP`, `REG`, `NAT`.',
        'collection' => 'Collection Directus, ex. `ffbbserver_rencontres` (le préfixe `items/` est optionnel).',
        'mockClient' => 'MockClient Saloon à brancher sur les deux connectors.',
        'meilisearchBearerToken' => 'Jeton Meilisearch (null : résolution automatique).',
        'apiBearerToken' => 'Jeton Directus (null : résolution automatique).',
        'cache' => 'Cache PSR-16 (Laravel : `Cache::store()`). Par défaut : mémoire du process.',
        'cacheTtl' => 'Durée de vie du cache HTTP Directus en secondes (null : désactivé).',
        'apiBaseUrl' => 'URL Directus (défaut : `https://api.ffbb.com/`).',
        'field' => 'Champ, notation pointée pour les relations (`idCompetition.categorie.code`).',
        'operator' => 'Opérateur Directus : `_eq`, `_neq`, `_in`, `_nin`, `_lt`, `_gte`, `_contains`, `_icontains`, `_starts_with`, `_between`, `_null`…',
        'value' => 'Valeur comparée (tableau pour `_in`, `_nin`, `_between`).',
        'function' => 'Fonction d\'agrégat : `count`, `countDistinct`, `sum`, `avg`, `min`, `max`…',
        'relation' => 'Relation imbriquée, notation pointée (`idPoule.classements`).',
        'query' => 'Paramètres Directus appliqués à la relation : `_limit`, `_sort`, `_filter`…',
        'alias' => 'Nom du champ dans la réponse.',
        'meta' => 'Métadonnées : `total_count`, `filter_count` ou `*`.',
        'page' => 'Numéro de page (commence à 1).',
        'meilisearchBaseUrl' => 'URL Meilisearch (défaut : `https://meilisearch-prod.ffbb.app/`).',
    ];

    /**
     * @return array<string, string> fichier => contenu
     */
    public static function pages(string $root): array
    {
        $python = self::pythonNames($root);
        $pages = [];
        $index = [];

        foreach (self::GROUPS as $file => [$title, $source, $intro, $guide]) {
            $methods = self::methodsOf($source);
            $pages[$file] = self::methodsPage($title, $intro, $guide, $methods, $python);
            $index[] = [$file, $title, $methods];
        }

        $pages['query-builder.md'] = self::queryBuilderPage();
        $pages['dtos.md'] = self::dtosPage();
        $pages['exceptions.md'] = self::exceptionsPage();
        $pages['README.md'] = self::indexPage($index);

        ksort($pages);

        return $pages;
    }

    // ------------------------------------------------------------------
    // Pages
    // ------------------------------------------------------------------

    /**
     * @param  list<ReflectionMethod>  $methods
     * @param  array<string, string>  $python
     */
    private static function methodsPage(string $title, string $intro, string $guide, array $methods, array $python): string
    {
        $md = self::header($title);
        $md .= $intro."\n\nGuide avec exemples : [".basename($guide, '.md')."]({$guide})\n\n";
        $md .= "| Méthode | Retour | Description |\n|---|---|---|\n";

        foreach ($methods as $method) {
            $doc = self::doc($method);
            $md .= sprintf("| [`%s()`](#%s) | `%s` | %s |\n", $method->getName(), strtolower($method->getName()), self::escapeCell(self::returnType($method, $doc)), self::escapeCell(self::firstSentence($doc['summary'])));
        }

        foreach ($methods as $method) {
            $md .= "\n".self::methodSection($method, $python[$method->getName()] ?? null);
        }

        return $md;
    }

    private static function queryBuilderPage(): string
    {
        $class = new ReflectionClass(QueryBuilder::class);
        $md = self::header('Query builder Directus');
        $md .= self::docOf((string) $class->getDocComment())['summary']."\n\n";
        $md .= "Obtenu via `\$ffbb->directus('nom_de_collection')`. Les méthodes de construction renvoient le builder (chaînables) ; `get()`, `first()`, `find()`, `count()`, `cursor()`, `raw()`, `getData()` et `findData()` exécutent la requête.\n\n";
        $md .= "Guide avec exemples : [06-query-builder-directus](../guides/06-query-builder-directus.md)\n\n";

        $methods = array_values(array_filter(
            $class->getMethods(ReflectionMethod::IS_PUBLIC),
            static fn (ReflectionMethod $m): bool => ! $m->isConstructor() && $m->getDeclaringClass()->getName() === QueryBuilder::class,
        ));

        $md .= "| Méthode | Retour | Description |\n|---|---|---|\n";

        foreach ($methods as $method) {
            $doc = self::doc($method);
            $md .= sprintf("| [`%s()`](#%s) | `%s` | %s |\n", $method->getName(), strtolower($method->getName()), self::escapeCell(self::returnType($method, $doc)), self::escapeCell(self::firstSentence($doc['summary'])));
        }

        foreach ($methods as $method) {
            $md .= "\n".self::methodSection($method, null);
        }

        return $md;
    }

    private static function dtosPage(): string
    {
        $md = self::header('DTOs');
        $md .= "Toutes les méthodes renvoient des objets typés. Toutes les propriétés sont nullables (les données FFBB sont souvent partielles), les dates sont des `DateTimeImmutable`, et `\$raw` / `toArray()` conservent la réponse complète.\n\n";
        $md .= "Guide avec exemples : [07-dtos](../guides/07-dtos.md)\n\n";
        $md .= "- [Réponses Directus](#réponses-directus) : un DTO par collection, généré depuis la spec OpenAPI\n";
        $md .= "- [Réponses Meilisearch et lives](#réponses-meilisearch-et-lives) : hits par index, objets imbriqués, matchs en direct\n\n";

        $md .= "## Réponses Directus\n\n";
        $md .= "Générées par `bin/generate-dtos` depuis `resources/discovery/openapi.json`. Une relation vaut le DTO lié quand Directus la développe (`fields=relation.*`), sinon son identifiant. Une collection sans DTO renvoie un `Item` générique (`\$item->champ`, `\$item->get('a.b')`).\n\n";
        $md .= "| Collection Directus | DTO | Propriétés |\n|---|---|---|\n";

        foreach (ItemMap::CLASSES as $collection => $class) {
            $short = self::short($class);
            $md .= "| `{$collection}` | [`{$short}`](#".strtolower($short).') | '.self::propertyCount($class)." |\n";
        }

        $models = self::modelClasses();

        $md .= "\n## Réponses Meilisearch et lives\n\n";
        $md .= "Chaque recherche renvoie un `SearchResult` dont les `hits` sont typés selon l'index. Les DTOs de hits sont générés depuis les modèles du SDK Python, complétés par les attributs réellement observés dans chaque index.\n\n";
        $md .= "| DTO | Rôle | Propriétés |\n|---|---|---|\n";

        foreach ($models as $class) {
            $reflection = new ReflectionClass($class);
            $md .= sprintf("| [`%s`](#%s) | %s | %d |\n", $reflection->getShortName(), strtolower($reflection->getShortName()), self::escapeCell(self::firstSentence(self::docOf((string) $reflection->getDocComment())['summary'])), self::propertyCount($class));
        }

        foreach ([...array_values(ItemMap::CLASSES), ...$models] as $class) {
            $md .= self::propertiesSection($class);
        }

        return $md;
    }

    /**
     * @return list<class-string>
     */
    private static function modelClasses(): array
    {
        $classes = [];

        foreach (glob(dirname(__DIR__, 2).'/src/Data/Models/*.php') ?: [] as $file) {
            $classes[] = 'CoachBasket\\Ffbb\\Data\\Models\\'.basename($file, '.php');
        }

        sort($classes);

        return $classes;
    }

    /**
     * @param  class-string  $class
     */
    private static function propertyCount(string $class): int
    {
        $params = (new ReflectionClass($class))->getConstructor()?->getParameters() ?? [];

        return count(array_filter($params, static fn (ReflectionParameter $p): bool => $p->getName() !== 'raw'));
    }

    /**
     * @param  class-string  $class
     */
    private static function propertiesSection(string $class): string
    {
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        $doc = self::docOf((string) $constructor?->getDocComment());
        $md = "\n### {$reflection->getShortName()}\n\n";
        $summary = self::firstSentence(self::docOf((string) $reflection->getDocComment())['summary']);

        if ($summary !== '') {
            $md .= $summary."\n\n";
        }

        $md .= "| Propriété | Type |\n|---|---|\n";

        foreach ($constructor?->getParameters() ?? [] as $param) {
            if ($param->getName() === 'raw') {
                continue;
            }

            $type = $doc['params'][$param->getName()]['type'] ?? self::propertyDocType($param) ?? self::typeOf($param);
            $md .= sprintf("| `%s` | `%s` |\n", $param->getName(), self::escapeCell($type));
        }

        return $md;
    }

    /**
     * Type précisé par un « @var » placé devant la propriété promue (listes typées).
     */
    private static function propertyDocType(ReflectionParameter $param): ?string
    {
        $class = $param->getDeclaringClass();
        $property = $class?->hasProperty($param->getName()) ? $class->getProperty($param->getName()) : null;

        if ($property !== null && preg_match('/@var\s+(\S+)/', (string) $property->getDocComment(), $m)) {
            return self::shortType($m[1]);
        }

        return null;
    }

    private static function exceptionsPage(): string
    {
        $md = self::header('Exceptions');
        $md .= "Toutes les exceptions implémentent `FfbbException`. Les erreurs HTTP étendent `Saloon\\Exceptions\\Request\\RequestException` (accès à la réponse via `getResponse()`).\n\n";
        $md .= "Guide : [08-erreurs-cache-et-repli](../guides/08-erreurs-cache-et-repli.md)\n\n";
        $md .= "| Exception | Parent | Quand |\n|---|---|---|\n";

        $classes = [
            Exceptions\FfbbException::class,
            Exceptions\FfbbHttpException::class,
            Exceptions\FfbbNotFoundException::class,
            Exceptions\FfbbAuthenticationException::class,
            Exceptions\FfbbRateLimitException::class,
            Exceptions\FfbbServerException::class,
            Exceptions\FfbbTransportException::class,
            Exceptions\FfbbResponseValidationException::class,
            Exceptions\ValidationException::class,
        ];

        foreach ($classes as $class) {
            $reflection = new ReflectionClass($class);
            $parent = $reflection->getParentClass();
            $md .= sprintf(
                "| `%s` | %s | %s |\n",
                $reflection->getShortName(),
                $parent ? '`'.$parent->getShortName().'`' : 'interface',
                self::escapeCell(self::firstSentence(self::docOf((string) $reflection->getDocComment())['summary'])),
            );
        }

        return $md;
    }

    /**
     * @param  list<array{0: string, 1: string, 2: list<ReflectionMethod>}>  $groups
     */
    private static function indexPage(array $groups): string
    {
        $md = self::header('Référence API');
        $md .= "Référence complète générée depuis le code. Pour des exemples commentés, voir les [guides](../guides/README.md).\n\n";

        $total = array_sum(array_map(static fn (array $g): int => count($g[2]), $groups));
        $md .= "`FfbbDataClient` expose **{$total} méthodes publiques**, regroupées par type de données :\n\n";

        foreach ($groups as [$file, $title, $methods]) {
            $md .= "- [{$title}]({$file}) — ".count($methods)." méthodes\n";
        }

        $md .= "\nEt aussi :\n\n- [Query builder Directus](query-builder.md)\n- [DTOs](dtos.md) — ".count(ItemMap::CLASSES).' DTOs Directus, '.count(self::modelClasses())." DTOs de réponse Meilisearch / lives\n- [Exceptions](exceptions.md)\n\n";
        $md .= "## Toutes les méthodes\n\n| Méthode | Groupe | Description |\n|---|---|---|\n";

        $rows = [];

        foreach ($groups as [$file, $title, $methods]) {
            foreach ($methods as $method) {
                $rows[$method->getName()] = sprintf(
                    "| [`%s()`](%s#%s) | %s | %s |\n",
                    $method->getName(),
                    $file,
                    strtolower($method->getName()),
                    $title,
                    self::escapeCell(self::firstSentence(self::doc($method)['summary'])),
                );
            }
        }

        ksort($rows);

        return $md.implode('', $rows);
    }

    // ------------------------------------------------------------------
    // Méthodes
    // ------------------------------------------------------------------

    /**
     * @param  class-string|null  $source  trait, ou null pour les méthodes propres à FfbbDataClient
     * @return list<ReflectionMethod>
     */
    private static function methodsOf(?string $source): array
    {
        $client = new ReflectionClass(FfbbDataClient::class);

        if ($source === null) {
            $traitMethods = [];

            foreach ($client->getTraits() as $trait) {
                foreach ($trait->getMethods() as $m) {
                    $traitMethods[$m->getName()] = true;
                }
            }

            $methods = array_filter(
                $client->getMethods(ReflectionMethod::IS_PUBLIC),
                static fn (ReflectionMethod $m): bool => ! $m->isConstructor() && ! isset($traitMethods[$m->getName()]),
            );
        } else {
            $methods = array_filter(
                (new ReflectionClass($source))->getMethods(ReflectionMethod::IS_PUBLIC),
                static fn (ReflectionMethod $m): bool => true,
            );
        }

        return array_values($methods);
    }

    private static function methodSection(ReflectionMethod $method, ?string $python): string
    {
        $doc = self::doc($method);
        $md = "### `{$method->getName()}()`\n\n";

        if ($doc['summary'] !== '') {
            $md .= self::renderSummary($doc['summary'])."\n\n";
        }

        $md .= "```php\n".self::signature($method)."\n```\n\n";

        $params = $method->getParameters();

        if ($params !== []) {
            $md .= "| Paramètre | Type | Défaut | Description |\n|---|---|---|---|\n";

            foreach ($params as $param) {
                $md .= sprintf(
                    "| `\$%s` | `%s` | %s | %s |\n",
                    $param->getName(),
                    self::escapeCell($doc['params'][$param->getName()]['type'] ?? self::typeOf($param)),
                    $param->isDefaultValueAvailable() ? '`'.self::escapeCell(self::exportDefault($param)).'`' : '—',
                    self::escapeCell(($doc['params'][$param->getName()]['description'] ?? '') ?: (self::PARAM_DESCRIPTIONS[$param->getName()] ?? '')),
                );
            }

            $md .= "\n";
        }

        $md .= '**Retour :** `'.self::returnType($method, $doc)."`\n";

        if ($python !== null) {
            $md .= "\nÉquivalent Python : `{$python}`\n";
        }

        return $md;
    }

    private static function signature(ReflectionMethod $method): string
    {
        $params = array_map(static function (ReflectionParameter $p): string {
            $out = self::typeOf($p).' $'.$p->getName();

            return $p->isDefaultValueAvailable() ? $out.' = '.self::exportDefault($p) : $out;
        }, $method->getParameters());

        $return = $method->hasReturnType() ? ': '.self::reflectionType($method->getReturnType(), $method->getDeclaringClass()->getName()) : '';
        $static = $method->isStatic() ? 'static ' : '';

        return "public {$static}function {$method->getName()}(".implode(', ', $params).')'.$return;
    }

    private static function typeOf(ReflectionParameter $param): string
    {
        return $param->hasType()
            ? self::reflectionType($param->getType(), $param->getDeclaringClass()?->getName() ?? '')
            : 'mixed';
    }

    /**
     * Rendu stable d'un type de réflexion, quelle que soit la version de PHP :
     * noms courts, classe déclarante → self, membres d'union triés (null en dernier).
     */
    private static function reflectionType(?ReflectionType $type, string $declaringClass): string
    {
        if ($type === null) {
            return 'mixed';
        }

        $members = $type instanceof ReflectionUnionType
            ? array_map(static fn (ReflectionType $t): string => (string) $t, $type->getTypes())
            : [ltrim((string) $type, '?')];

        $nullable = $type->allowsNull() && ! in_array('mixed', $members, true) && ! in_array('null', $members, true);

        $members = array_map(
            static fn (string $m): string => ltrim($m, '\\') === ltrim($declaringClass, '\\') || $m === 'static' ? 'self' : self::shortType($m),
            $members,
        );

        $members = array_values(array_filter($members, static fn (string $m): bool => $m !== 'null'));
        sort($members);

        if ($type instanceof ReflectionUnionType) {
            if ($nullable || $type->allowsNull()) {
                $members[] = 'null';
            }

            return implode('|', array_unique($members));
        }

        return ($nullable ? '?' : '').$members[0];
    }

    /**
     * @param  array{summary: string, params: array<string, array{type: string, description: string}>, return: ?string}  $doc
     */
    private static function returnType(ReflectionMethod $method, array $doc): string
    {
        if ($doc['return'] !== null) {
            return self::shortType($doc['return']);
        }

        return self::reflectionType($method->getReturnType(), $method->getDeclaringClass()->getName());
    }

    private static function shortType(string $type): string
    {
        return (string) preg_replace('/\\\\?(?:[A-Za-z_][A-Za-z0-9_]*\\\\)+([A-Za-z_][A-Za-z0-9_]*)/', '$1', $type);
    }

    private static function short(string $class): string
    {
        return substr($class, (int) strrpos($class, '\\') + 1);
    }

    private static function exportDefault(ReflectionParameter $param): string
    {
        $value = $param->getDefaultValue();

        return match (true) {
            $value === null => 'null',
            is_bool($value) => $value ? 'true' : 'false',
            $value instanceof UnitEnum => self::short($value::class).'::'.$value->name,
            is_array($value) => $value === [] ? '[]' : json_encode($value, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            is_string($value) => "'".$value."'",
            default => var_export($value, true),
        };
    }

    // ------------------------------------------------------------------
    // Docblocks
    // ------------------------------------------------------------------

    /**
     * @return array{summary: string, params: array<string, array{type: string, description: string}>, return: ?string}
     */
    private static function doc(ReflectionMethod $method): array
    {
        return self::docOf((string) $method->getDocComment());
    }

    /**
     * @return array{summary: string, params: array<string, array{type: string, description: string}>, return: ?string}
     */
    private static function docOf(string $comment): array
    {
        $lines = preg_split('/\R/', $comment) ?: [];
        $summary = [];
        $tags = [];

        foreach ($lines as $line) {
            $line = preg_replace('/^\s*\/?\*+\/?\s?/', '', rtrim($line)) ?? '';

            if (str_starts_with(ltrim($line), '@')) {
                $tags[] = ltrim($line);
            } elseif ($tags === []) {
                $summary[] = $line;
            } elseif ($line !== '' && $tags !== []) {
                $tags[count($tags) - 1] .= ' '.trim($line);
            }
        }

        $params = [];
        $return = null;

        foreach ($tags as $tag) {
            if (preg_match('/^@param\s+(.*)$/', $tag, $m)) {
                [$type, $rest] = self::readType($m[1]);

                if (preg_match('/^\$(\w+)\s*(.*)$/', $rest, $p)) {
                    $params[$p[1]] = ['type' => self::shortType($type), 'description' => trim($p[2])];
                }
            } elseif (preg_match('/^@return\s+(.*)$/', $tag, $m)) {
                [$type, $rest] = self::readType($m[1]);
                $return = $type.($rest !== '' ? '' : '');
            }
        }

        return ['summary' => trim(implode("\n", $summary)), 'params' => $params, 'return' => $return];
    }

    /**
     * Lit un type phpdoc en tenant compte des <...> et (...) imbriqués.
     *
     * @return array{0: string, 1: string} [type, reste]
     */
    private static function readType(string $text): array
    {
        $depth = 0;
        $length = strlen($text);

        for ($i = 0; $i < $length; $i++) {
            $char = $text[$i];

            if ($char === '<' || $char === '(' || $char === '{') {
                $depth++;
            } elseif ($char === '>' || $char === ')' || $char === '}') {
                $depth--;
            } elseif (ctype_space($char) && $depth === 0) {
                return [substr($text, 0, $i), ltrim(substr($text, $i))];
            }
        }

        return [$text, ''];
    }

    /**
     * Les lignes indentées de 4 espaces deviennent des blocs de code PHP.
     */
    private static function renderSummary(string $summary): string
    {
        $out = [];
        $inCode = false;

        foreach (explode("\n", $summary) as $line) {
            $isCode = str_starts_with($line, '    ');

            if ($isCode && ! $inCode) {
                $out[] = '```php';
                $inCode = true;
            } elseif (! $isCode && $inCode && trim($line) !== '') {
                $out[] = '```';
                $inCode = false;
            }

            $out[] = $isCode ? substr($line, 4) : $line;
        }

        if ($inCode) {
            while (end($out) === '') {
                array_pop($out);
            }

            $out[] = '```';
        }

        return trim(implode("\n", $out));
    }

    private static function firstSentence(string $summary): string
    {
        $text = trim(explode("\n\n", $summary)[0]);
        $text = (string) preg_replace('/\s+/', ' ', $text);

        if (preg_match('/^(.+?\.)(\s|$)/u', $text, $m)) {
            $text = $m[1];
        }

        return rtrim($text, ' :;');
    }

    private static function escapeCell(string $text): string
    {
        return str_replace('|', '\|', $text);
    }

    private static function header(string $title): string
    {
        return "<!-- FICHIER GÉNÉRÉ par bin/generate-api-reference — ne pas modifier à la main. -->\n\n# {$title}\n\n";
    }

    /**
     * Méthode PHP → nom Python, d'après resources/upstream/methods.json.
     *
     * @return array<string, string>
     */
    private static function pythonNames(string $root): array
    {
        $file = $root.'/resources/upstream/methods.json';

        if (! is_file($file)) {
            return [];
        }

        $names = [];

        foreach ((array) json_decode((string) file_get_contents($file), true) as $python) {
            $php = lcfirst(str_replace('_', '', ucwords((string) preg_replace('/^aiter_all_/', 'iter_all_', (string) $python), '_')));
            $names[$php] = (string) $python;
        }

        return $names;
    }
}
