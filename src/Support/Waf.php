<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Support;

use Saloon\Http\Response;

/**
 * Détection des blocages WAF BunnyCDN (miroir de retry_utils._is_bunnycdn_block).
 *
 * BunnyCDN renvoie une page HTML (content-type text/html, marqueur « bunnycdn »
 * ou document « <html ») quand le User-Agent n'est pas autorisé.
 * Directus renvoie du JSON avec le code FORBIDDEN.
 */
final class Waf
{
    public static function isBunnyCdnBlock(?Response $response): bool
    {
        if ($response === null) {
            return false;
        }

        $contentType = $response->header('Content-Type');
        $contentType = is_array($contentType) ? implode(',', $contentType) : (string) $contentType;

        if (str_contains(strtolower($contentType), 'text/html')) {
            return true;
        }

        $body = strtolower($response->body());

        if (str_contains($body, 'bunnycdn')) {
            return true;
        }

        $stripped = ltrim($body);

        return str_starts_with($stripped, '<!doctype') || str_starts_with($stripped, '<html');
    }

    public static function isBunnyCdnForbidden(?Response $response): bool
    {
        return $response !== null && $response->status() === 403 && self::isBunnyCdnBlock($response);
    }
}
