<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Search;

enum GeoSortOrder: string
{
    case NearestFirst = 'asc';
    case FarthestFirst = 'desc';
}
