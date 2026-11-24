<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Fields;

enum FieldSet: string
{
    case Basic = 'basic';
    case Default = 'default';
    case Detailed = 'detailed';
    case Minimal = 'minimal';
}
