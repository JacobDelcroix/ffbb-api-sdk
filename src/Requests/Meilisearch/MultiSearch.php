<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Requests\Meilisearch;

use CoachBasket\Ffbb\Search\MultiSearchQuery;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * POST multi-search — miroir de MeilisearchClient.multi_search.
 */
class MultiSearch extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  list<MultiSearchQuery>  $queries
     */
    public function __construct(public readonly array $queries) {}

    public function resolveEndpoint(): string
    {
        return '/multi-search';
    }

    protected function defaultBody(): array
    {
        return [
            'queries' => array_map(static fn (MultiSearchQuery $q): array => $q->toArray(), $this->queries),
        ];
    }
}
