<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Models;

use CoachBasket\Ffbb\Data\EngagementsItem;

/**
 * Contacts d'une équipe engagée : correspondant + entraîneurs.
 */
final readonly class EngagementContacts
{
    public function __construct(
        public EngagementsItem $engagement,
        public ?ContactInfo $correspondant,
        public ?ContactInfo $entraineur,
        public ?ContactInfo $entraineurAdjoint,
    ) {}
}
