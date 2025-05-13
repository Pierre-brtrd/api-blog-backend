<?php

namespace App\Dto\User;

use App\Validator\Constraints\UniqueUsername;
use App\Validator\Constraints\ValidPasswordChange;
use Symfony\Component\Validator\Constraints as Assert;

// #[ValidPasswordChange]
class UpdateProfileRequest implements UserRequestInterface
{
    public function __construct(
        #[Assert\Length(
            min: 2,
            max: 255,
            minMessage: 'Le prénom doit contenir au moins {{ limit }} caractères.',
            maxMessage: 'Le prénom ne peut pas dépasser {{ limit }} caractères.'
        )]
        public readonly ?string $firstName,

        #[Assert\Length(
            min: 2,
            max: 255,
            minMessage: 'Le nom de famille doit contenir au moins {{ limit }} caractères.',
            maxMessage: 'Le nom de famille ne peut pas dépasser {{ limit }} caractères.'
        )]
        public readonly ?string $lastName,

        #[UniqueUsername(message: 'Le nom d’utilisateur "{{ value }}" est déjà utilisé.')]
        #[Assert\Length(min: 3, max: 180)]
        public readonly ?string $username,

        public readonly ?string $currentPassword,

        public readonly ?string $plainPassword,

        public readonly ?string $confirmPassword,
    ) {
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }
}