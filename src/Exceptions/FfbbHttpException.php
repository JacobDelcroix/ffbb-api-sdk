<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Exceptions;

use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Response;
use Throwable;

/**
 * Erreur HTTP renvoyée par un service FFBB (équivalent de FFBBHTTPError).
 *
 * Étend RequestException de Saloon pour que la boucle de retry du connector
 * puisse l'intercepter.
 */
class FfbbHttpException extends RequestException implements FfbbException
{
    public function __construct(Response $response, ?string $message = null, ?Throwable $previous = null)
    {
        parent::__construct(
            $response,
            $message ?? sprintf('FFBB service returned HTTP %d', $response->status()),
            $response->status(),
            $previous,
        );
    }

    public function statusCode(): int
    {
        return $this->getResponse()->status();
    }
}
