<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Connectors;

/**
 * Connector sans authentification, utilisé uniquement pour lire
 * items/configuration sur un hôte donné avec un User-Agent donné.
 */
class ConfigurationConnector extends FfbbConnector
{
    public function __construct(string $baseUrl, string $userAgent)
    {
        parent::__construct($baseUrl, [$userAgent]);
    }
}
