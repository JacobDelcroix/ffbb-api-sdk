<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Requests\Directus;

use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Enums\Method;
use CoachBasket\Ffbb\Config;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\HasTimeout;

/**
 * GET items/{collection}/{id} — miroir de GettersMixin._get_directus_item.
 *
 * Les clés de query sont passées telles quelles (ex. "deep[rencontres][_limit]").
 */
class GetItem extends Request
{
    use HasCaching;
    use HasTimeout;

    protected float $connectTimeout = Config::CONNECT_TIMEOUT;

    protected float $requestTimeout = Config::READ_TIMEOUT;

    protected Method $method = Method::GET;

    /**
     * @param  list<string>|null  $fields
     * @param  array<string, string>  $extraQuery
     * @param  float|null  $timeout  timeout total en secondes (le Python utilise 3 s sur les gros objets)
     */
    public function __construct(
        public readonly string $endpoint,
        public readonly string|int $id,
        public readonly ?array $fields = null,
        public readonly array $extraQuery = [],
        ?float $timeout = null,
    ) {
        if ($timeout !== null) {
            $this->requestTimeout = $timeout;
        }
    }

    public function resolveEndpoint(): string
    {
        return '/'.trim($this->endpoint, '/').'/'.rawurlencode((string) $this->id);
    }

    protected function defaultQuery(): array
    {
        return DirectusQuery::build(fields: $this->fields, extra: $this->extraQuery);
    }
}
