<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Exceptions;

/**
 * HTTP 429 — trop de requêtes (FFBBRateLimitError).
 */
class FfbbRateLimitException extends FfbbHttpException {}
