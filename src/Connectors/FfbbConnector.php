<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Connectors;

use CoachBasket\Ffbb\Config;
use CoachBasket\Ffbb\Exceptions\FfbbAuthenticationException;
use CoachBasket\Ffbb\Exceptions\FfbbHttpException;
use CoachBasket\Ffbb\Exceptions\FfbbNotFoundException;
use CoachBasket\Ffbb\Exceptions\FfbbRateLimitException;
use CoachBasket\Ffbb\Exceptions\FfbbServerException;
use CoachBasket\Ffbb\Support\Waf;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\Traits\Plugins\HasTimeout;
use Throwable;

/**
 * Base commune aux connectors FFBB : en-têtes « app mobile », timeouts
 * et traduction des erreurs HTTP en exceptions du SDK
 * (miroir de http_requests_utils._raise_for_status).
 */
abstract class FfbbConnector extends Connector
{
    use AlwaysThrowOnErrors;
    use HasTimeout;

    protected float $connectTimeout = Config::CONNECT_TIMEOUT;

    protected float $requestTimeout = Config::READ_TIMEOUT;

    /** @var list<string> */
    protected array $userAgents;

    protected int $userAgentIndex = 0;

    /**
     * @param  list<string>|null  $userAgents  User-Agents à essayer dans l'ordre (rotation sur blocage WAF)
     */
    public function __construct(
        protected readonly string $baseUrl,
        ?array $userAgents = null,
    ) {
        $this->userAgents = $userAgents !== null && $userAgents !== []
            ? array_values($userAgents)
            : Config::fallbackUserAgents();
    }

    public function resolveBaseUrl(): string
    {
        return rtrim($this->baseUrl, '/');
    }

    public function currentUserAgent(): string
    {
        return $this->userAgents[$this->userAgentIndex] ?? $this->userAgents[0];
    }

    /**
     * Passe au User-Agent suivant. Renvoie false s'il n'y en a plus.
     */
    public function rotateUserAgent(): bool
    {
        if ($this->userAgentIndex + 1 >= count($this->userAgents)) {
            return false;
        }

        $this->userAgentIndex++;

        // Saloon mémorise les en-têtes du connector au premier appel : on met à jour le store.
        $this->headers()->add('User-Agent', $this->currentUserAgent());

        return true;
    }

    protected function defaultHeaders(): array
    {
        return Config::defaultHeaders($this->currentUserAgent());
    }

    public function getRequestException(Response $response, ?Throwable $senderException): ?Throwable
    {
        $status = $response->status();

        return match (true) {
            $status === 404 => new FfbbNotFoundException($response, null, $senderException),
            $status === 403 && Waf::isBunnyCdnBlock($response) => new FfbbAuthenticationException(
                $response,
                'FFBB access blocked by CDN (403 BunnyCDN WAF). Directus unreachable from this IP; use Meilisearch-backed data.',
                $senderException,
            ),
            in_array($status, [401, 403], true) => new FfbbAuthenticationException(
                $response,
                sprintf(
                    'FFBB access denied by Directus (HTTP %d). Probable cause: archived-season item or restricted field. Use filter listing or a current-season id.',
                    $status,
                ),
                $senderException,
            ),
            $status === 429 => new FfbbRateLimitException($response, null, $senderException),
            $status >= 500 => new FfbbServerException($response, null, $senderException),
            default => new FfbbHttpException($response, null, $senderException),
        };
    }
}
