<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Auth;

use Closure;
use Saloon\Contracts\Authenticator;
use Saloon\Http\PendingRequest;

/**
 * Authenticator Bearer dont le jeton est résolu à chaque requête,
 * ce qui permet de le rafraîchir entre deux essais (401).
 */
final readonly class FfbbTokenAuthenticator implements Authenticator
{
    /**
     * @param  Closure(): string  $token
     */
    public function __construct(private Closure $token) {}

    public function set(PendingRequest $pendingRequest): void
    {
        $pendingRequest->headers()->add('Authorization', 'Bearer '.($this->token)());
    }
}
