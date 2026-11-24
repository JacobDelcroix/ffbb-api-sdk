<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Auth;

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Connectors\ConfigurationConnector;
use CoachBasket\Ffbb\Requests\Directus\GetConfiguration;
use CoachBasket\Ffbb\Support\Json;
use Psr\SimpleCache\CacheInterface;
use Saloon\Http\Faking\MockClient;
use Throwable;

/**
 * Résolution des jetons FFBB (miroir de utils/token_manager.py).
 *
 * Ordre :
 *  1. jetons passés explicitement ;
 *  2. variables d'environnement API_FFBB_APP_BEARER_TOKEN + MEILISEARCH_BEARER_TOKEN ;
 *  3. cache PSR-16 (si fourni) ;
 *  4. GET items/configuration, en essayant chaque hôte × chaque User-Agent ;
 *  5. jetons publics de repli codés dans Config.
 */
final class TokenManager
{
    public const string CACHE_KEY = 'coach-basket.ffbb.tokens';

    private ?FfbbTokens $tokens = null;

    private ?string $healthyHost = null;

    private ?Throwable $lastError = null;

    /**
     * @param  list<string>|null  $hosts
     * @param  list<string>|null  $userAgents
     */
    public function __construct(
        private readonly ?CacheInterface $cache = null,
        private readonly int $cacheTtl = 21600,
        private ?MockClient $mockClient = null,
        private readonly ?array $hosts = null,
        private readonly ?array $userAgents = null,
        ?FfbbTokens $tokens = null,
    ) {
        $this->tokens = $tokens;
    }

    public static function withTokens(string $apiToken, string $meilisearchToken): self
    {
        return new self(tokens: new FfbbTokens($apiToken, $meilisearchToken, TokenSource::Explicit));
    }

    public function withMockClient(?MockClient $mockClient): self
    {
        $this->mockClient = $mockClient;

        return $this;
    }

    public function getTokens(): FfbbTokens
    {
        if ($this->tokens !== null) {
            return $this->tokens;
        }

        $api = getenv(Config::ENV_API_TOKEN);
        $meili = getenv(Config::ENV_MEILISEARCH_TOKEN);

        if (is_string($api) && $api !== '' && is_string($meili) && $meili !== '') {
            return $this->tokens = new FfbbTokens($api, $meili, TokenSource::Environment);
        }

        $cached = $this->cache?->get(self::CACHE_KEY);

        if (is_array($cached) && ($fromCache = FfbbTokens::fromArray($cached)) !== null) {
            return $this->tokens = new FfbbTokens($fromCache->apiToken, $fromCache->meilisearchToken, TokenSource::Cache);
        }

        return $this->tokens = $this->resolveFromConfigurationOrFallback();
    }

    /**
     * Oublie les jetons courants et les récupère à nouveau (utilisé sur 401).
     */
    public function refresh(): FfbbTokens
    {
        if ($this->tokens?->source === TokenSource::Explicit) {
            return $this->tokens;
        }

        $this->forget();

        return $this->tokens = $this->resolveFromConfigurationOrFallback();
    }

    public function forget(): void
    {
        $this->tokens = null;
        $this->cache?->delete(self::CACHE_KEY);
    }

    public function lastError(): ?Throwable
    {
        return $this->lastError;
    }

    /**
     * Lit items/configuration sur le premier hôte qui répond.
     *
     * @return array<string, mixed>|null la configuration (key_dh, key_ms, ios_version…)
     */
    public function fetchConfiguration(): ?array
    {
        foreach ($this->candidateHosts() as $host) {
            foreach ($this->userAgents ?? Config::fallbackUserAgents() as $userAgent) {
                try {
                    $connector = new ConfigurationConnector($host, $userAgent);
                    $response = $connector->send(new GetConfiguration, $this->mockClient);
                    $data = Json::unwrapData(Json::decode($response->body()));

                    if (is_array($data) && $this->hasTokens($data)) {
                        $this->healthyHost = $host;

                        return $data;
                    }
                } catch (Throwable $e) {
                    $this->lastError = $e;
                }
            }
        }

        return null;
    }

    private function resolveFromConfigurationOrFallback(): FfbbTokens
    {
        $config = $this->fetchConfiguration();

        if ($config === null) {
            return new FfbbTokens(
                Config::DEFAULT_FALLBACK_API_TOKEN,
                Config::DEFAULT_FALLBACK_MEILISEARCH_TOKEN,
                TokenSource::Fallback,
            );
        }

        $tokens = new FfbbTokens((string) $config['key_dh'], (string) $config['key_ms'], TokenSource::Configuration);

        $this->cache?->set(self::CACHE_KEY, $tokens->toArray(), $this->cacheTtl);

        return $tokens;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function hasTokens(array $data): bool
    {
        return is_string($data['key_dh'] ?? null) && $data['key_dh'] !== ''
            && is_string($data['key_ms'] ?? null) && $data['key_ms'] !== '';
    }

    /**
     * @return list<string>
     */
    private function candidateHosts(): array
    {
        $hosts = $this->hosts ?? [Config::apiBaseUrl(), ...Config::CONFIGURATION_HOSTS];

        if ($this->healthyHost !== null) {
            array_unshift($hosts, $this->healthyHost);
        }

        return array_values(array_unique(array_map(
            static fn (string $h): string => rtrim($h, '/').'/',
            $hosts,
        )));
    }
}
