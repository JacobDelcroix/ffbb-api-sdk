<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Support;

use CoachBasket\Ffbb\Exceptions\FfbbTransportException;
use Saloon\Exceptions\Request\FatalRequestException;

/**
 * Convertit les erreurs réseau de Saloon en FfbbTransportException.
 */
final class Transport
{
    /**
     * @template T
     *
     * @param  callable(): T  $callback
     * @return T
     */
    public static function guard(callable $callback): mixed
    {
        try {
            return $callback();
        } catch (FatalRequestException $e) {
            throw new FfbbTransportException('Unable to reach FFBB service', 0, $e);
        }
    }
}
