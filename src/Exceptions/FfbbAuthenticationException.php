<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Exceptions;

use CoachBasket\Ffbb\Support\Waf;

/**
 * HTTP 401/403 — accès refusé par Directus ou bloqué par le WAF BunnyCDN (FFBBAuthenticationError).
 */
class FfbbAuthenticationException extends FfbbHttpException
{
    /**
     * Vrai si le refus vient du WAF BunnyCDN (page HTML) et non de Directus (JSON).
     */
    public function isBunnyCdnBlock(): bool
    {
        return Waf::isBunnyCdnBlock($this->getResponse());
    }
}
