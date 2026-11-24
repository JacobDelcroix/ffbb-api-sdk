<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Data;

/**
 * Élément d'une collection Directus sans DTO généré (ex. ffbbsite_*), ou ligne d'agrégat.
 *
 * Les champs se lisent comme des propriétés : `$item->nom`, `$item->count`.
 */
final readonly class Item
{
    /**
     * @param  array<string, mixed>  $raw
     */
    public function __construct(public array $raw = []) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self($data);
    }

    /**
     * @param  iterable<array<string, mixed>>  $items
     * @return list<self>
     */
    public static function collect(iterable $items): array
    {
        $out = [];

        foreach ($items as $item) {
            if (is_array($item)) {
                $out[] = new self($item);
            }
        }

        return $out;
    }

    public function __get(string $name): mixed
    {
        return $this->raw[$name] ?? null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->raw[$name]);
    }

    /**
     * Valeur d'un champ, notation pointée acceptée (`idPoule.nom`).
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $value = $this->raw;

        foreach (explode('.', $key) as $segment) {
            if (! is_array($value) || ! array_key_exists($segment, $value)) {
                return $default;
            }

            $value = $value[$segment];
        }

        return $value;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->raw;
    }
}
