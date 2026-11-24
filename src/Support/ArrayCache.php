<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Support;

use DateInterval;
use DateTimeImmutable;
use Psr\SimpleCache\CacheInterface;

/**
 * Cache PSR-16 en mémoire (durée de vie du process), utilisé par défaut.
 *
 * En Laravel, le service provider injecte le cache de l'application à la place.
 */
final class ArrayCache implements CacheInterface
{
    /** @var array<string, array{value: mixed, expiresAt: ?int}> */
    private array $items = [];

    public function get(string $key, mixed $default = null): mixed
    {
        if (! $this->has($key)) {
            return $default;
        }

        return $this->items[$key]['value'];
    }

    public function set(string $key, mixed $value, null|int|DateInterval $ttl = null): bool
    {
        $this->items[$key] = ['value' => $value, 'expiresAt' => $this->expiresAt($ttl)];

        return true;
    }

    public function delete(string $key): bool
    {
        unset($this->items[$key]);

        return true;
    }

    public function clear(): bool
    {
        $this->items = [];

        return true;
    }

    /**
     * @param  iterable<string>  $keys
     * @return array<string, mixed>
     */
    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        $result = [];

        foreach ($keys as $key) {
            $result[$key] = $this->get($key, $default);
        }

        return $result;
    }

    /**
     * @param  iterable<string, mixed>  $values
     */
    public function setMultiple(iterable $values, null|int|DateInterval $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    /**
     * @param  iterable<string>  $keys
     */
    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;
    }

    public function has(string $key): bool
    {
        if (! isset($this->items[$key])) {
            return false;
        }

        $expiresAt = $this->items[$key]['expiresAt'];

        if ($expiresAt !== null && $expiresAt <= time()) {
            unset($this->items[$key]);

            return false;
        }

        return true;
    }

    private function expiresAt(null|int|DateInterval $ttl): ?int
    {
        if ($ttl === null) {
            return null;
        }

        if ($ttl instanceof DateInterval) {
            return (new DateTimeImmutable)->add($ttl)->getTimestamp();
        }

        return time() + $ttl;
    }
}
