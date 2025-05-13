<?php

namespace App\Validator\Constraints;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueTitleValidator extends ConstraintValidator
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof UniqueTitle) {
            throw new UnexpectedTypeException($constraint, UniqueTitle::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $existing = $this->articleRepository->findOneBy(['title' => $value]);
        if (null === $existing) {
            return;
        }

        $req = $this->requestStack->getCurrentRequest();
        $currentId = $req?->attributes->get('id');

        if (null !== $currentId && $existing->getId() === (int) $currentId) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}