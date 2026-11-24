<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Auth;

/**
 * Jetons Bearer publics de l'app mobile FFBB (key_dh / key_ms).
 */
final readonly class FfbbTokens
{
    public function __construct(
        public string $apiToken,
        public string $meilisearchToken,
        public TokenSource $source = TokenSource::Configuration,
    ) {}

    /**
     * @return array{api_token: string, meilisearch_token: string, source: string}
     */
    public function toArray(): array
    {
        return [
            'api_token' => $this->apiToken,
            'meilisearch_token' => $this->meilisearchToken,
            'source' => $this->source->value,
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): ?self
    {
        $api = $data['api_token'] ?? null;
        $meili = $data['meilisearch_token'] ?? null;

        if (! is_string($api) || $api === '' || ! is_string($meili) || $meili === '') {
            return null;
        }

        return new self($api, $meili, TokenSource::tryFrom((string) ($data['source'] ?? '')) ?? TokenSource::Cache);
    }
}
