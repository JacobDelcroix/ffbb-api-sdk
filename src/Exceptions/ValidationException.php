<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Exceptions;

use InvalidArgumentException;

/**
 * Paramètre d'entrée invalide (ValidationError de input_validation.py).
 */
class ValidationException extends InvalidArgumentException implements FfbbException {}
