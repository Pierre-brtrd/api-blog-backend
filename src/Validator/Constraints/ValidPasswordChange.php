<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class ValidPasswordChange extends Constraint
{
    public string $messageCurrent = 'Le mot de passe actuel est invalide.';
    public string $messageConfirm = 'La confirmation du mot de passe ne correspond pas.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
