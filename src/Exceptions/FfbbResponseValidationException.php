<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Exceptions;

use RuntimeException;

/**
 * Réponse FFBB illisible ou incomplète (FFBBResponseValidationError).
 */
class FfbbResponseValidationException extends RuntimeException implements FfbbException {}
