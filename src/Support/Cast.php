<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Support;

use DateTimeImmutable;
use Throwable;

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
     * Date ISO 8601 (« 2026-11-24 », « 2026-11-24T18:30:00 », « …Z ») ou timestamp Unix.
     */
    public static function dateTime(mixed $value): ?DateTimeImmutable
    {
        if (is_int($value) || (is_string($value) && ctype_digit($value) && strlen($value) >= 9)) {
            $seconds = (int) $value;

            // Timestamps en millisecondes
            return (new DateTimeImmutable)->setTimestamp($seconds > 99_999_999_999 ? intdiv($seconds, 1000) : $seconds);
        }

        if (! is_string($value) || trim($value) === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($value);
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * Objet imbriqué hydraté dans son DTO (null si absent ou non objet).
     *
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @return T|null
     */
    public static function object(mixed $value, string $class): ?object
    {
        return is_array($value) && $value !== [] && ! array_is_list($value) ? $class::fromArray($value) : null;
    }

    /**
     * Liste dont chaque élément est converti : 'string', 'int', 'float', 'bool', 'raw' ou une classe DTO.
     *
     * @return list<mixed>|null
     */
    public static function listOf(mixed $value, string $type): ?array
    {
        if (! is_array($value)) {
            return null;
        }

        $out = [];

        foreach ($value as $item) {
            $converted = match ($type) {
                'string' => self::string($item),
                'int' => self::int($item),
                'float' => self::float($item),
                'bool' => self::bool($item),
                'raw' => $item,
                default => self::object($item, $type) ?? (is_array($item) ? null : $item),
            };

            if ($converted !== null) {
                $out[] = $converted;
            }
        }

        return $out;
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
     * Relation Directus toujours renvoyée en DTO : l'objet développé, ou un DTO
     * qui ne contient que l'identifiant quand Directus n'a pas développé la relation.
     *
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @return T|null
     */
    public static function related(mixed $value, string $class): ?object
    {
        if (is_array($value) && $value !== [] && ! array_is_list($value)) {
            return $class::fromArray($value);
        }

        return is_string($value) || is_int($value) ? $class::fromArray(['id' => $value]) : null;
    }

    /**
     * Liste de relations toujours renvoyées en DTO (voir related()).
     *
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @return list<T>|null
     */
    public static function relatedList(mixed $value, string $class): ?array
    {
        if (! is_array($value)) {
            return null;
        }

        $items = [];

        foreach ($value as $item) {
            $related = self::related($item, $class);

            if ($related !== null) {
                $items[] = $related;
            }
        }

        return $items;
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
