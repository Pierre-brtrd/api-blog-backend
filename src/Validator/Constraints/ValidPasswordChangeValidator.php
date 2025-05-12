<?php

namespace App\Validator\Constraints;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidPasswordChangeValidator extends ConstraintValidator
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private UserPasswordHasherInterface $hasher,
    ) {
    }

    public function validate(mixed $dto, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidPasswordChange) {
            throw new UnexpectedTypeException($constraint, ValidPasswordChange::class);
        }

        if (null === $dto->plainPassword) {
            return;
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()?->getUser();
        $current = $dto->currentPassword;

        if (null === $current || !$this->hasher->isPasswordValid($user, $current)) {
            $this->context
                ->buildViolation($constraint->messageCurrent)
                ->atPath('currentPassword')
                ->addViolation();

            return;
        }

        if ($dto->plainPassword !== $dto->confirmPassword) {
            $this->context
                ->buildViolation($constraint->messageConfirm)
                ->atPath('confirmPassword')
                ->addViolation();
        }
    }
}
