<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Discovery;

/**
 * Différences entre deux instantanés de l'API FFBB :
 * spec OpenAPI Directus (collections, propriétés, types) et attributs des index Meilisearch.
 */
final class SchemaDiff
{
    /**
     * @param  list<string>  $addedCollections
     * @param  list<string>  $removedCollections
     * @param  array<string, array{added: list<string>, removed: list<string>, changed: array<string, array{0: string, 1: string}>}>  $properties
     * @param  array<string, array{added: list<string>, removed: list<string>}>  $indexAttributes
     * @param  list<string>  $addedIndexes
     * @param  list<string>  $removedIndexes
     */
    public function __construct(
        public readonly array $addedCollections = [],
        public readonly array $removedCollections = [],
        public readonly array $properties = [],
        public readonly array $indexAttributes = [],
        public readonly array $addedIndexes = [],
        public readonly array $removedIndexes = [],
    ) {}

    /**
     * @param  array<string, mixed>  $before  spec OpenAPI précédente
     * @param  array<string, mixed>  $after  spec OpenAPI actuelle
     * @param  array<string, array{available: bool, attributes: list<string>}>  $indexesBefore
     * @param  array<string, array{available: bool, attributes: list<string>}>  $indexesAfter
     */
    public static function compare(array $before, array $after, array $indexesBefore = [], array $indexesAfter = []): self
    {
        $schemasBefore = self::itemSchemas($before);
        $schemasAfter = self::itemSchemas($after);

        $properties = [];

        foreach (array_intersect_key($schemasAfter, $schemasBefore) as $name => $schema) {
            $old = $schemasBefore[$name];
            $changed = [];

            foreach (array_intersect_key($schema, $old) as $prop => $type) {
                if ($old[$prop] !== $type) {
                    $changed[$prop] = [$old[$prop], $type];
                }
            }

            $entry = [
                'added' => array_keys(array_diff_key($schema, $old)),
                'removed' => array_keys(array_diff_key($old, $schema)),
                'changed' => $changed,
            ];

            if ($entry['added'] !== [] || $entry['removed'] !== [] || $entry['changed'] !== []) {
                $properties[$name] = $entry;
            }
        }

        $available = static fn (array $indexes): array => array_keys(array_filter($indexes, static fn (array $i): bool => $i['available'] ?? false));
        $indexAttributes = [];

        foreach (array_intersect($available($indexesAfter), $available($indexesBefore)) as $uid) {
            $old = $indexesBefore[$uid]['attributes'] ?? [];
            $new = $indexesAfter[$uid]['attributes'] ?? [];
            $entry = ['added' => array_values(array_diff($new, $old)), 'removed' => array_values(array_diff($old, $new))];

            if ($entry['added'] !== [] || $entry['removed'] !== []) {
                $indexAttributes[$uid] = $entry;
            }
        }

        return new self(
            addedCollections: array_values(array_diff(array_keys($schemasAfter), array_keys($schemasBefore))),
            removedCollections: array_values(array_diff(array_keys($schemasBefore), array_keys($schemasAfter))),
            properties: $properties,
            indexAttributes: $indexAttributes,
            addedIndexes: array_values(array_diff($available($indexesAfter), $available($indexesBefore))),
            removedIndexes: array_values(array_diff($available($indexesBefore), $available($indexesAfter))),
        );
    }

    public function hasChanges(): bool
    {
        return $this->addedCollections !== [] || $this->removedCollections !== []
            || $this->properties !== [] || $this->indexAttributes !== []
            || $this->addedIndexes !== [] || $this->removedIndexes !== [];
    }

    /**
     * Changements susceptibles de casser le SDK (suppressions, changements de type).
     */
    public function hasBreakingChanges(): bool
    {
        if ($this->removedCollections !== [] || $this->removedIndexes !== []) {
            return true;
        }

        foreach ($this->properties as $entry) {
            if ($entry['removed'] !== [] || $entry['changed'] !== []) {
                return true;
            }
        }

        foreach ($this->indexAttributes as $entry) {
            if ($entry['removed'] !== []) {
                return true;
            }
        }

        return false;
    }

    public function toMarkdown(): string
    {
        $md = "# Changements détectés sur l'API FFBB\n\n";

        if (! $this->hasChanges()) {
            return $md."Aucun changement.\n";
        }

        if ($this->hasBreakingChanges()) {
            $md .= "> [!WARNING]\n> Changements potentiellement cassants (suppression ou changement de type) : vérifier les méthodes et DTOs concernés avant de merger.\n\n";
        }

        $list = static fn (array $items): string => $items === [] ? "aucune\n" : "\n".implode('', array_map(static fn (string $i): string => "  - `{$i}`\n", $items));

        $md .= "## Collections Directus\n\n- Ajoutées : ".$list($this->addedCollections).'- Supprimées : '.$list($this->removedCollections)."\n";

        if ($this->properties !== []) {
            $md .= "## Propriétés modifiées\n\n";

            foreach ($this->properties as $schema => $entry) {
                $md .= "### `{$schema}`\n\n";

                foreach ($entry['added'] as $prop) {
                    $md .= "- ➕ `{$prop}`\n";
                }

                foreach ($entry['removed'] as $prop) {
                    $md .= "- ➖ `{$prop}`\n";
                }

                foreach ($entry['changed'] as $prop => [$old, $new]) {
                    $md .= "- ✏️ `{$prop}` : `{$old}` → `{$new}`\n";
                }

                $md .= "\n";
            }
        }

        $md .= "## Index Meilisearch\n\n- Nouveaux : ".$list($this->addedIndexes).'- Indisponibles : '.$list($this->removedIndexes)."\n";

        foreach ($this->indexAttributes as $uid => $entry) {
            $md .= "### `{$uid}`\n\n";

            foreach ($entry['added'] as $attr) {
                $md .= "- ➕ `{$attr}`\n";
            }

            foreach ($entry['removed'] as $attr) {
                $md .= "- ➖ `{$attr}`\n";
            }

            $md .= "\n";
        }

        return $md;
    }

    /**
     * Schémas Items* → [propriété => type lisible].
     *
     * @param  array<string, mixed>  $spec
     * @return array<string, array<string, string>>
     */
    private static function itemSchemas(array $spec): array
    {
        $out = [];

        foreach ((array) ($spec['components']['schemas'] ?? []) as $name => $schema) {
            if (! str_starts_with((string) $name, 'Items') || ! is_array($schema)) {
                continue;
            }

            $props = [];

            foreach ((array) ($schema['properties'] ?? []) as $prop => $definition) {
                $props[(string) $prop] = self::describe(is_array($definition) ? $definition : []);
            }

            ksort($props);
            $out[(string) $name] = $props;
        }

        ksort($out);

        return $out;
    }

    /**
     * @param  array<string, mixed>  $definition
     */
    private static function describe(array $definition): string
    {
        if (isset($definition['$ref'])) {
            return 'ref:'.basename((string) $definition['$ref']);
        }

        if (isset($definition['oneOf']) && is_array($definition['oneOf'])) {
            return implode('|', array_map(static fn (mixed $o): string => self::describe(is_array($o) ? $o : []), $definition['oneOf']));
        }

        $type = (string) ($definition['type'] ?? 'mixed');

        if ($type === 'array' && is_array($definition['items'] ?? null)) {
            return 'array<'.self::describe($definition['items']).'>';
        }

        return isset($definition['format']) ? "{$type}({$definition['format']})" : $type;
    }
}
