<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Exceptions;

use RuntimeException;

/**
 * Service FFBB injoignable : DNS, timeout, connexion refusée (FFBBTransportError).
 */
class FfbbTransportException extends RuntimeException implements FfbbException {}
