<?php

namespace App\Mapper;

use App\Dto\RegistrationRequest;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserMapper
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
    ) {
    }

    public function map(RegistrationRequest $dto, ?User $user): User
    {
        $user ??= new User();

        $user
            ->setUsername($dto->username)
            ->setFirstName($dto->firstName)
            ->setLastName($dto->lastName)
            ->setPassword(
                $this->hasher->hashPassword(
                    $user,
                    $dto->plainPassword,
                ),
            );

        return $user;
    }
}