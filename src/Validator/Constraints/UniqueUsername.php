<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(target: Attribute::TARGET_PROPERTY)]
class UniqueUsername extends Constraint
{
    public string $message = 'Le nom d’utilisateur "{{ value }}" est déjà utilisé.';

    public bool $admin = false;

    public function __construct(
        ?string $message = null,
        bool $admin = false,
        array $groups = null,
        array $payload = null,
    ) {
        parent::__construct($groups, $payload);

        if (null !== $message) {
            $this->message = $message;
        }

        $this->admin = $admin;
    }

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}