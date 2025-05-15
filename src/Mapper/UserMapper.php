<?php

namespace App\Mapper;

use App\Dto\User\UpdateAdminUpdateRequest;
use App\Dto\User\UserRequestInterface;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserMapper
{
    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
    ) {
    }

    public function map(UserRequestInterface $dto, ?User $user): User
    {
        $user ??= new User();

        if (null !== $dto->getUsername()) {
            $user->setUsername($dto->getUsername());
        }
        if (null !== $dto->getFirstName()) {
            $user->setFirstName($dto->getFirstName());
        }
        if (null !== $dto->getLastName()) {
            $user->setLastName($dto->getLastName());
        }

        if (null !== $dto->getPlainPassword()) {
            $hashed = $this->hasher->hashPassword($user, $dto->getPlainPassword());
            $user->setPassword($hashed);
        }

        if ($dto instanceof UpdateAdminUpdateRequest && null !== $dto->getRoles()) {
            $user->setRoles($dto->getRoles());
        }

        return $user;
    }
}