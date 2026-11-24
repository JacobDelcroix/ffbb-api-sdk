<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Auth;

enum TokenSource: string
{
    case Explicit = 'explicit';
    case Environment = 'environment';
    case Cache = 'cache';
    case Configuration = 'configuration';
    case Fallback = 'fallback';
}
