<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Requests\Directus;

use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Enums\Method;
use CoachBasket\Ffbb\Config;
use Saloon\Http\Request;
use Saloon\Traits\Plugins\HasTimeout;

/**
 * GET items/{collection} — miroir de GettersMixin._list_directus_items.
 */
class ListItems extends Request
{
    use HasCaching;
    use HasTimeout;

    protected float $connectTimeout = Config::CONNECT_TIMEOUT;

    protected float $requestTimeout = Config::READ_TIMEOUT;

    protected Method $method = Method::GET;

    /**
     * @param  list<string>|null  $fields
     * @param  string|list<string>|null  $sort
     * @param  array<string, string>  $extraQuery
     * @param  float|null  $timeout  timeout total en secondes (le Python utilise 3 s sur les gros objets)
     */
    public function __construct(
        public readonly string $endpoint,
        public readonly ?int $limit = 10,
        public readonly ?array $fields = null,
        public readonly ?string $filter = null,
        public readonly string|array|null $sort = null,
        public readonly ?int $offset = null,
        public readonly ?string $search = null,
        public readonly array $extraQuery = [],
        ?float $timeout = null,
    ) {
        if ($timeout !== null) {
            $this->requestTimeout = $timeout;
        }
    }

    public function resolveEndpoint(): string
    {
        return '/'.trim($this->endpoint, '/');
    }

    protected function defaultQuery(): array
    {
        return DirectusQuery::build(
            fields: $this->fields,
            limit: $this->limit,
            filter: $this->filter,
            sort: $this->sort,
            offset: $this->offset,
            search: $this->search,
            extra: $this->extraQuery,
        );
    }
}
