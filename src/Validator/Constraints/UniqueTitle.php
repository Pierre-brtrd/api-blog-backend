<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(target: Attribute::TARGET_PROPERTY)]
class UniqueTitle extends Constraint
{
    public string $message = 'Le titre "{{ value }}" est déjà utilisé.';

    public function __construct(
        ?string $message = null,
        array $groups = null,
        array $payload = null,
    ) {
        parent::__construct($groups, $payload);

        if (null !== $message) {
            $this->message = $message;
        }
    }

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}