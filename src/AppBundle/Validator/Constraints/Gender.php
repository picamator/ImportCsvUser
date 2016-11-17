<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @codeCoverageIgnore
 */
class Gender extends Constraint
{
    /**
     * @var string
     */
    public $message = 'Wrong gender. Please set valid gender "%female%" for female and "%male%" for male.';

    /**
     * @var string
     */
    public $female = 'f';

    /**
     * @var string
     */
    public $male = 'm';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this) . 'Validator';
    }
}
