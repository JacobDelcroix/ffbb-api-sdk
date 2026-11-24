<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Requests\Directus;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GET json/lives.json — matchs en direct (jamais mis en cache).
 */
class GetLives extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/json/lives.json';
    }
}
