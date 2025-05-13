<?php

namespace App\Validator\Constraints;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueUsernameValidator extends ConstraintValidator
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Security $security,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueUsername) {
            throw new UnexpectedTypeException($constraint, UniqueUsername::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $existing = $this->userRepository->findOneBy(['username' => $value]);

        if (null === $existing) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();
        $currentId = $request?->attributes->get('id');

        if ($currentId) {
            if ($existing->getId() === (int) $currentId) {
                return;
            }
        } else {
            /** @var User $currentUser */
            $currentUser = $this->security->getUser();

            if (null !== $currentUser && $existing->getId() === $currentUser->getId()) {
                return;
            }
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}