<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Laravel\Facades;

use CoachBasket\Ffbb\FfbbDataClient;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin FfbbDataClient
 *
 * @see FfbbDataClient
 */
final class Ffbb extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FfbbDataClient::class;
    }
}
