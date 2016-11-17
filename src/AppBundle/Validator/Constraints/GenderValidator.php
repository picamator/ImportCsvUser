<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class GenderValidator extends ConstraintValidator
{
    /**
     * @var array
     */
    private $genderList;

    /**
     * Validate
     *
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!empty($value) && !in_array($value, $this->getGenderList())) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%female%', $constraint->female)
                ->setParameter('%male%', $constraint->male)
                ->addViolation();
        }
    }

    /**
     * Get gender list
     *
     * @param Constraint $constraint
     *
     * @return array
     */
    private function getGenderList(Constraint $constraint) : array
    {
        if (!is_null($this->genderList)) {
            $this->genderList = [$constraint->female, $constraint->male];
        }

        return $this->genderList;
    }
}
