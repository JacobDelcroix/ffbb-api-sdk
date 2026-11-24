<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Requests\Directus;

use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GET server/specs/oas — spécification OpenAPI exposée par Directus.
 */
class GetOpenApiSpec extends Request
{
    use HasCaching;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/server/specs/oas';
    }
}
