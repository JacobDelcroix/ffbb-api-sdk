<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Connectors;

use CoachBasket\Ffbb\Auth\FfbbTokenAuthenticator;
use CoachBasket\Ffbb\Auth\TokenManager;
use CoachBasket\Ffbb\Config;
use Saloon\Contracts\Authenticator;

/**
 * Connector Meilisearch (https://meilisearch-prod.ffbb.app/) — miroir de MeilisearchClient.
 */
class MeilisearchConnector extends FfbbConnector
{
    use RetriesFfbbRequests;

    /**
     * @param  list<string>|null  $userAgents
     */
    public function __construct(
        public readonly TokenManager $tokens,
        ?string $baseUrl = null,
        ?array $userAgents = null,
    ) {
        parent::__construct($baseUrl ?? Config::meilisearchBaseUrl(), $userAgents);
        $this->configureRetries();
    }

    protected function defaultHeaders(): array
    {
        return [
            'User-Agent' => $this->currentUserAgent(),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function defaultAuth(): Authenticator
    {
        return new FfbbTokenAuthenticator(fn (): string => $this->tokens->getTokens()->meilisearchToken);
    }
}
