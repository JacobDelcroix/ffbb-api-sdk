<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Laravel;

use CoachBasket\Ffbb\FfbbDataClient;
use Illuminate\Contracts\Cache\Factory as CacheFactory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Enregistre FfbbDataClient comme singleton, branché sur le cache Laravel.
 */
final class FfbbServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/ffbb.php', 'ffbb');

        $this->app->singleton(FfbbDataClient::class, static function (Application $app): FfbbDataClient {
            /** @var array<string, mixed> $config */
            $config = $app['config']->get('ffbb');

            $cache = $app->make(CacheFactory::class)->store($config['cache']['store'] ?? null);
            $ttl = $config['cache']['ttl'] ?? 1800;

            return FfbbDataClient::create(
                meilisearchBearerToken: $config['meilisearch_token'] ?? null,
                apiBearerToken: $config['api_token'] ?? null,
                cache: $cache,
                cacheTtl: $ttl > 0 ? (int) $ttl : null,
                apiBaseUrl: $config['api_base_url'] ?? null,
                meilisearchBaseUrl: $config['meilisearch_base_url'] ?? null,
            );
        });

        $this->app->alias(FfbbDataClient::class, 'ffbb');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/ffbb.php' => $this->app->configPath('ffbb.php'),
            ], 'ffbb-config');
        }
    }
}
