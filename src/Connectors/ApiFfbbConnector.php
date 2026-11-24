<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Connectors;

use CoachBasket\Ffbb\Auth\FfbbTokenAuthenticator;
use CoachBasket\Ffbb\Auth\TokenManager;
use CoachBasket\Ffbb\Config;
use Psr\SimpleCache\CacheInterface;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Contracts\Driver;
use Saloon\CachePlugin\Drivers\PsrCacheDriver;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Request;
use Saloon\Http\Response;

/**
 * Connector Directus (https://api.ffbb.com/) — miroir de ApiFFBBAppClient.
 */
class ApiFfbbConnector extends FfbbConnector implements Cacheable
{
    use RetriesFfbbRequests;

    /**
     * @param  int|null  $cacheTtl  TTL du cache HTTP en secondes (null = pas de cache)
     * @param  list<string>|null  $userAgents
     */
    public function __construct(
        public readonly TokenManager $tokens,
        ?string $baseUrl = null,
        protected readonly ?CacheInterface $cache = null,
        protected readonly ?int $cacheTtl = null,
        ?array $userAgents = null,
    ) {
        parent::__construct($baseUrl ?? Config::apiBaseUrl(), $userAgents);
        $this->configureRetries();
    }

    protected function defaultAuth(): Authenticator
    {
        return new FfbbTokenAuthenticator(fn (): string => $this->tokens->getTokens()->apiToken);
    }

    public function cachingEnabled(): bool
    {
        return $this->cache !== null && $this->cacheTtl !== null && $this->cacheTtl > 0;
    }

    public function resolveCacheDriver(): Driver
    {
        return new PsrCacheDriver($this->cache ?? throw new \LogicException('Cache non configuré.'));
    }

    public function cacheExpiryInSeconds(): int
    {
        return $this->cacheTtl ?? 0;
    }

    public function send(Request $request, ?MockClient $mockClient = null, ?callable $handleRetry = null): Response
    {
        if (! $this->cachingEnabled() && method_exists($request, 'disableCaching')) {
            $request->disableCaching();
        }

        return parent::send($request, $mockClient, $handleRetry);
    }
}
