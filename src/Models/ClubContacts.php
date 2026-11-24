<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Models;

/**
 * Contacts d'un club : contact du club + membres (dirigeants).
 */
final readonly class ClubContacts
{
    /**
     * @param  array<string, mixed>  $organisme  organisme source tel que renvoyé par Directus
     * @param  list<ContactInfo>  $membres
     */
    public function __construct(
        public array $organisme,
        public ?ContactInfo $clubContact,
        public array $membres = [],
    ) {}
}
