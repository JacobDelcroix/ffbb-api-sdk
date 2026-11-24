<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Requests\Directus;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GET items/configuration — endpoint public qui expose les jetons de l'app mobile.
 *
 * Jamais mis en cache HTTP (comme en Python) : les jetons sont gérés par TokenManager.
 */
class GetConfiguration extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/items/configuration';
    }
}
