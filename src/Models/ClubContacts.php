<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Models;

use CoachBasket\Ffbb\Data\OrganismesItem;

/**
 * Contacts d'un club : contact du club + membres (dirigeants).
 */
final readonly class ClubContacts
{
    /**
     * @param  list<ContactInfo>  $membres
     */
    public function __construct(
        public OrganismesItem $organisme,
        public ?ContactInfo $clubContact,
        public array $membres = [],
    ) {}
}
