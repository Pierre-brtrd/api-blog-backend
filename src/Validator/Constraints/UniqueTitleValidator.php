<?php

namespace App\Validator\Constraints;

use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueTitleValidator extends ConstraintValidator
{
    public function __construct(
        private readonly ArticleRepository $articleRepository,
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

        if ($this->articleRepository->findOneBy(['title' => $value])) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}