<?php

declare(strict_types=1);

namespace CoachBasket\Ffbb\Models;

/**
 * Contact compact (miroir de models/contact_info.py).
 */
final readonly class ContactInfo
{
    public function __construct(
        public ?string $nom = null,
        public ?string $prenom = null,
        public ?string $email = null,
        public ?string $telephone = null,
        public ?string $role = null,
    ) {}

    /**
     * @return array{nom: ?string, prenom: ?string, email: ?string, telephone: ?string, role: ?string}
     */
    public function toArray(): array
    {
        return [
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'role' => $this->role,
        ];
    }
}
