<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Models;

/**
 * Contacts d'une équipe engagée : correspondant + entraîneurs.
 */
final readonly class EngagementContacts
{
    /**
     * @param  array<string, mixed>  $engagement
     */
    public function __construct(
        public array $engagement,
        public ?ContactInfo $correspondant,
        public ?ContactInfo $entraineur,
        public ?ContactInfo $entraineurAdjoint,
    ) {}
}
