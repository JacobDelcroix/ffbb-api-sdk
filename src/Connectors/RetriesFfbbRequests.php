<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Connectors;

use CoachBasket\Ffbb\Auth\TokenManager;
use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Support\Waf;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Request;

/**
 * Politique de retry partagée (miroir de retry_utils.should_retry + _handle_token_refresh) :
 *
 * - erreur réseau, 429, 5xx      → nouvel essai avec backoff exponentiel ;
 * - 403 BunnyCDN (page HTML)     → nouvel essai avec le User-Agent suivant ;
 * - 401                          → jetons rafraîchis une fois, puis nouvel essai ;
 * - autre (404, 403 Directus…)   → pas de nouvel essai.
 *
 * @property TokenManager $tokens
 */
trait RetriesFfbbRequests
{
    private bool $tokensRefreshed = false;

    /**
     * Les propriétés $tries & co viennent du trait HasTries de Saloon :
     * on les initialise ici plutôt que de les redéclarer.
     */
    protected function configureRetries(): void
    {
        $this->tries = Config::MAX_ATTEMPTS;
        $this->retryInterval = Config::RETRY_BASE_DELAY_MS;
        $this->useExponentialBackoff = true;
    }

    public function handleRetry(FatalRequestException|RequestException $exception, Request $request): bool
    {
        if ($exception instanceof FatalRequestException) {
            return true;
        }

        $response = $exception->getResponse();
        $status = $response->status();

        if ($status === 403 && Waf::isBunnyCdnBlock($response)) {
            return $this->rotateUserAgent();
        }

        if ($status === 401 && ! $this->tokensRefreshed) {
            $this->tokensRefreshed = true;
            $this->tokens->refresh();

            return true;
        }

        return in_array($status, Config::RETRY_ON_STATUS_CODES, true);
    }
}
