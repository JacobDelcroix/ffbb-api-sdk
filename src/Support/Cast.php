<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Support;

/**
 * Conversions tolérantes utilisées par les DTOs générés :
 * la FFBB renvoie souvent des nombres en chaîne et des booléens en 0/1.
 */
final class Cast
{
    public static function string(mixed $value): ?string
    {
        return match (true) {
            is_string($value) => $value,
            is_int($value), is_float($value) => (string) $value,
            is_bool($value) => $value ? '1' : '0',
            default => null,
        };
    }

    public static function int(mixed $value): ?int
    {
        return match (true) {
            is_int($value) => $value,
            is_float($value) => (int) $value,
            is_bool($value) => (int) $value,
            is_string($value) && is_numeric(trim($value)) => (int) trim($value),
            default => null,
        };
    }

    public static function float(mixed $value): ?float
    {
        return match (true) {
            is_float($value), is_int($value) => (float) $value,
            is_string($value) && is_numeric(trim($value)) => (float) trim($value),
            default => null,
        };
    }

    public static function bool(mixed $value): ?bool
    {
        return match (true) {
            is_bool($value) => $value,
            is_int($value) => $value !== 0,
            is_string($value) => match (strtolower(trim($value))) {
                '1', 'true', 'oui', 'yes' => true,
                '0', 'false', 'non', 'no', '' => false,
                default => null,
            },
            default => null,
        };
    }

    /**
     * @return array<mixed>|null
     */
    public static function array(mixed $value): ?array
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && ($value[0] ?? '') !== '' && in_array($value[0], ['{', '['], true)) {
            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : null;
        }

        return null;
    }

    /**
     * Relation Directus : identifiant (non développé) ou objet (développé via fields=relation.*).
     *
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @return T|string|int|null
     */
    public static function relation(mixed $value, string $class): object|string|int|null
    {
        if (is_array($value) && $value !== [] && ! array_is_list($value)) {
            return $class::fromArray($value);
        }

        return is_string($value) || is_int($value) ? $value : null;
    }

    /**
     * Liste de relations (o2m / m2m).
     *
     * @template T of object
     *
     * @param  class-string<T>|null  $class
     * @return list<T|string|int|array<mixed>>|null
     */
    public static function relations(mixed $value, ?string $class): ?array
    {
        if (! is_array($value)) {
            return null;
        }

        $items = [];

        foreach ($value as $item) {
            $items[] = $class !== null && is_array($item) && $item !== [] && ! array_is_list($item)
                ? $class::fromArray($item)
                : $item;
        }

        return $items;
    }
}
