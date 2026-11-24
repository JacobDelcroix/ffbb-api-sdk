<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Requests\Meilisearch;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * POST indexes/{index}/search — recherche exacte utilisée par les fallbacks
 * (miroir de meilisearch_fallback.meili_search_async).
 */
class SearchIndex extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        public readonly string $index,
        public readonly array $payload,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/indexes/'.rawurlencode($this->index).'/search';
    }

    protected function defaultBody(): array
    {
        return $this->payload;
    }
}
