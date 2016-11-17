<?php
namespace AppBundle\Tests\Validator\Constraints;

use AppBundle\Tests\BaseTest;
use AppBundle\Validator\Constraints\GenderValidator;

class GenderValidatorTest extends BaseTest
{
    /**
     * @var GenderValidator
     */
    private $genderValidator;

    /**
     * @var \Symfony\Component\Validator\Context\ExecutionContextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $contextMock;

    /**
     * @var \AppBundle\Validator\Constraints\Gender | \PHPUnit_Framework_MockObject_MockObject
     */
    private $genderConstrainMock;

    /**
     * @var \Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $constrainViolationBuilderMock;

    protected function setUp()
    {
        parent::setUp();

        $this->contextMock = $this->getMockBuilder('Symfony\Component\Validator\Context\ExecutionContextInterface')
            ->getMock();

        $this->genderConstrainMock = $this->getMockBuilder('AppBundle\Validator\Constraints\Gender')
            ->getMock();

        $this->genderConstrainMock->female      = 'f';
        $this->genderConstrainMock->male        = 'm';
        $this->genderConstrainMock->message     = 'Error message';

        $this->constrainViolationBuilderMock = $this->getMockBuilder('Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface')
            ->getMock();

        $this->genderValidator = new GenderValidator();
    }

    /**
     * @dataProvider providerValidValidate
     *
     * @param string | null $value
     */
    public function testValidValidate($value)
    {
        // never
        $this->contextMock->expects($this->never())
            ->method('buildViolation');

        $this->genderValidator->validate($value, $this->genderConstrainMock);
    }

    public function testInvalidValidate()
    {
        // context mock
        $this->contextMock->expects($this->once())
            ->method('buildViolation')
            ->willReturn($this->constrainViolationBuilderMock);

        // constrain violation builder mock
        $this->constrainViolationBuilderMock->expects($this->exactly(2))
            ->method('setParameter')
            ->withConsecutive(
                [$this->equalTo('%female%'), $this->equalTo('f')],
                [$this->equalTo('%male%'), $this->equalTo('m')]
            )
            ->willReturnSelf();

        $this->constrainViolationBuilderMock->expects($this->once())
            ->method('addViolation');

        $this->genderValidator->initialize($this->contextMock);
        $this->genderValidator->validate('t', $this->genderConstrainMock);
    }

    public function providerValidValidate()
    {
        return [
            ['m'],
            ['f'],
            [null],
            ['']
        ];
    }
}

