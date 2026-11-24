<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Support;

use CoachBasket\Ffbb\Exceptions\ValidationException;

/**
 * Validation des entrées (miroir de utils/input_validation.py).
 */
final class Validator
{
    public static function token(?string $token, string $field = 'token'): string
    {
        $token = trim((string) $token);

        if ($token === '') {
            throw new ValidationException("{$field} cannot be empty");
        }

        if (strlen($token) < 10) {
            throw new ValidationException("{$field} is too short (min 10 characters)");
        }

        if (strlen($token) > 1000) {
            throw new ValidationException("{$field} is too long (max 1000 characters)");
        }

        if (preg_match('/[<>"\';&]/', $token) === 1) {
            throw new ValidationException("{$field} contains invalid characters");
        }

        return $token;
    }

    /**
     * @param  list<string>|null  $values
     * @return list<string>|null
     */
    public static function stringList(?array $values, string $field = 'values'): ?array
    {
        if ($values === null || $values === []) {
            return null;
        }

        $clean = [];

        foreach (array_values($values) as $i => $value) {
            if (! is_string($value)) {
                throw new ValidationException("{$field}[{$i}] must be a string");
            }

            $value = trim($value);

            if ($value === '') {
                throw new ValidationException("{$field}[{$i}] cannot be empty");
            }

            if (strlen($value) > 100) {
                throw new ValidationException("{$field}[{$i}] is too long (max 100 characters)");
            }

            $clean[] = $value;
        }

        return $clean;
    }

    public static function offset(?int $offset, string $field = 'offset'): ?int
    {
        if ($offset === null) {
            return null;
        }

        if ($offset < 0) {
            throw new ValidationException("{$field} must be non-negative");
        }

        if ($offset > 2 ** 31 - 1) {
            throw new ValidationException("{$field} is too large");
        }

        return $offset;
    }

    public static function filterCriteria(?string $filter, string $field = 'filter_criteria'): ?string
    {
        if ($filter === null) {
            return null;
        }

        $filter = trim($filter);

        if ($filter === '') {
            return null;
        }

        if (strlen($filter) > 1000) {
            throw new ValidationException("{$field} is too long (max 1000 characters)");
        }

        if (! str_starts_with($filter, '{') || ! str_ends_with($filter, '}')) {
            throw new ValidationException("{$field} must be a valid JSON object (start with { and end with })");
        }

        return $filter;
    }

    public static function searchQuery(?string $query, string $field = 'query'): ?string
    {
        if ($query === null) {
            return null;
        }

        $query = trim($query);

        if ($query === '') {
            return null;
        }

        if (mb_strlen($query) > 200) {
            throw new ValidationException("{$field} is too long (max 200 characters)");
        }

        if (preg_match('/[<>]/', $query) === 1) {
            throw new ValidationException("{$field} contains invalid characters");
        }

        return $query;
    }
}
