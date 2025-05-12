<?php

namespace App\Dto\User;

use App\Validator\Constraints\UniqueUsername;
use Symfony\Component\Validator\Constraints as Assert;

class RegistrationRequest implements UserRequestInterface
{
    public function __construct(
        #[Assert\NotBlank(message: 'Le nom d’utilisateur est requis.')]
        #[UniqueUsername(message: 'Le nom d’utilisateur "{{ value }}" est déjà utilisé.')]
        #[Assert\Length(min: 3, max: 180)]
        public readonly string $username,

        #[Assert\Length(min: 2, max: 255)]
        public readonly ?string $firstName,

        #[Assert\Length(min: 2, max: 255)]
        public readonly ?string $lastName,

        #[Assert\NotBlank(message: 'Le mot de passe est requis.')]
        #[Assert\Length(min: 6, max: 4096)]
        public readonly string $plainPassword,

        #[Assert\NotBlank(message: 'La confirmation du mot de passe est requise.')]
        #[Assert\EqualTo(propertyPath: 'plainPassword', message: 'Les mots de passe doivent correspondre.')]
        public readonly string $confirmPassword,
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
