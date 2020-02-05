<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckPreviousEntry extends Constraint
{
    /**
     * @var string
     */
    public $message = '"{{ value }}" a déjà été utilisé.';
}
