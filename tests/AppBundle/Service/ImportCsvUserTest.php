<?php
namespace AppBundle\Tests\Service;

use AppBundle\Service\ImportCsvUser;
use AppBundle\Tests\BaseTest;

class ImportCsvUserTest extends BaseTest
{
    /**
     * @var ImportCsvUser
     */
    private $importCsvUser;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManagerMock;

    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $validatorMock;

    /**
     * @var \Symfony\Component\Validator\ConstraintViolationList | \PHPUnit_Framework_MockObject_MockObject
     */
    private $constraintViolationListMock;

    /**
     * @var \Symfony\Component\Validator\ConstraintViolationInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $constraintViolation;

    /**
     * @var \AppBundle\Model\Api\Csv\Builder\ReaderFilterIteratorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $readerFactoryMock;

    /**
     * @var \AppBundle\Model\Api\Builder\ImportUserFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $importUserFactoryMock;

    /**
     * @var \AppBundle\Model\Api\Entity\ImportUserInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $importUserMock;

    /**
     * @var \AppBundle\Model\Api\Manager\ImportUserManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $importUserManagerMock;

    /**
     * @var \AppBundle\Model\Api\Builder\ImportResultFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $importResultFactoryMock;

    /**
     * @var \AppBundle\Model\Api\Data\ImportResultInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $importResultMock;

    /**
     * @var \AppBundle\Model\Api\Csv\ReaderFilterIteratorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $readerMock;

    /**
     * @var \AppBundle\Model\Api\Data\PathInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pathMock;

    /**
     * @var \AppBundle\Model\Api\Csv\Data\RowInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $rowMock;

    protected function setUp()
    {
        parent::setUp();

        $this->entityManagerMock = $this->getTransactionalEntityManagerMock();

        // validator mock
        $this->validatorMock = $this->getMockBuilder('Symfony\Component\Validator\Validator\ValidatorInterface')
            ->getMock();
        $this->constraintViolationListMock = $this->getMockBuilder('Symfony\Component\Validator\ConstraintViolationList')
            ->getMock();
        $this->constraintViolation = $this->getMockBuilder('Symfony\Component\Validator\ConstraintViolationInterface')
            ->getMock();

        $this->readerFactoryMock = $this->getMockBuilder('AppBundle\Model\Api\Csv\Builder\ReaderFilterIteratorFactoryInterface')
            ->getMock();

        // import user factory
        $this->importUserFactoryMock = $this->getMockBuilder('AppBundle\Model\Api\Builder\ImportUserFactoryInterface')
            ->getMock();
        $this->importUserMock = $this->getMockBuilder('AppBundle\Model\Api\Entity\ImportUserInterface')
            ->getMock();

        $this->importUserManagerMock = $this->getMockBuilder('AppBundle\Model\Api\Manager\ImportUserManagerInterface')
            ->getMock();

        // import result factory
        $this->importResultFactoryMock = $this->getMockBuilder('AppBundle\Model\Api\Builder\ImportResultFactoryInterface')
            ->getMock();
        $this->importResultMock = $this->getMockBuilder('AppBundle\Model\Api\Data\ImportResultInterface')
            ->getMock();

        $this->readerMock = $this->getMockBuilder('AppBundle\Model\Csv\ReaderFilterIterator')
            ->disableOriginalConstructor()
            ->getMock();

        $this->pathMock = $this->getMockBuilder('AppBundle\Model\Api\Data\PathInterface')
            ->getMock();

        $this->rowMock = $this->getMockBuilder('AppBundle\Model\Api\Csv\Data\RowInterface')
            ->getMock();

        $this->importCsvUser = new ImportCsvUser(
            $this->entityManagerMock,
            $this->validatorMock,
            $this->readerFactoryMock,
            $this->importUserFactoryMock,
            $this->importUserManagerMock,
            $this->importResultFactoryMock
        );
    }

    public function testInvalidPathImport()
    {
        // constraint violation list mock
        $this->constraintViolationListMock->expects($this->once())
            ->method('count')
            ->willReturn(1);

        $this->constraintViolationListMock->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator([$this->constraintViolation]));

        // constraint violation mock
        $this->constraintViolation->expects($this->once())
            ->method('getPropertyPath')
            ->willReturn('');

        $this->constraintViolation->expects($this->once())
            ->method('getMessage')
            ->willReturn('');

        // validator mock
        $this->validatorMock->expects($this->once())
            ->method('validate')
            ->with($this->equalTo($this->pathMock))
            ->willReturn($this->constraintViolationListMock);

        // import result factory mock
        $this->importResultFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo(0), $this->equalTo(1), $this->anything())
            ->willReturn($this->importResultMock);

        // never
        $this->pathMock->expects($this->never())
            ->method('getPath');
        $this->importUserManagerMock->expects($this->never())
            ->method('save');

        $this->importCsvUser->import($this->pathMock);
    }

    public function testInvalidRowImport()
    {
        $path = 'test.csv';

        // constraint violation list mock
        $this->constraintViolationListMock->expects($this->exactly(2))
            ->method('count')
            ->willReturnOnConsecutiveCalls(0, 1);

        $this->constraintViolationListMock->expects($this->once())
            ->method('getIterator')
            ->willReturn(new \ArrayIterator([$this->constraintViolation]));

        // constraint violation mock
        $this->constraintViolation->expects($this->once())
            ->method('getPropertyPath')
            ->willReturn('');

        $this->constraintViolation->expects($this->once())
            ->method('getMessage')
            ->willReturn('');

        // validator mock
        $this->validatorMock->expects($this->exactly(2))
            ->method('validate')
            ->withConsecutive($this->pathMock, $this->importUserMock)
            ->willReturn($this->constraintViolationListMock);

        // path mock
        $this->pathMock->expects($this->once())
            ->method('getPath')
            ->willReturn($path);

        // reader factory mock
        $this->readerFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->readerMock);

        // reader mock
        $this->readerMock->expects($this->exactly(2))
            ->method('valid')
            ->willReturnOnConsecutiveCalls(true, false);

        $this->readerMock->expects($this->once())
            ->method('current')
            ->willReturn($this->rowMock);

        // row mock
        $rowMock = $this->getMockBuilder('AppBundle\Model\Api\Csv\Data\RowInterface')
            ->getMock();

        // import user factory mock
        $this->importUserFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($rowMock))
            ->willReturn($this->importUserMock);

        // row mock
        $this->rowMock->expects($this->once())
            ->method('getLineNumber')
            ->willReturn(1);

        // import result factory mock
        $this->importResultFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo(0), $this->equalTo(1), $this->anything())
            ->willReturn($this->importResultMock);

        // never
        $this->importUserManagerMock->expects($this->never())
            ->method('save');

        $this->importCsvUser->import($this->pathMock);
    }

    public function testValidImport()
    {
        $path = 'test.csv';

        // constraint violation list mock
        $this->constraintViolationListMock->expects($this->exactly(2))
            ->method('count')
            ->willReturn(0);



        // validator mock
        $this->validatorMock->expects($this->exactly(2))
            ->method('validate')
            ->withConsecutive($this->pathMock, $this->importUserMock)
            ->willReturn($this->constraintViolationListMock);

        // import user factory mock
        $this->importUserFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($this->rowMock))
            ->willReturn($this->importUserMock);

        // path mock
        $this->pathMock->expects($this->once())
            ->method('getPath')
            ->willReturn($path);

        // reader factory mock
        $this->readerFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->readerMock);

        // reader mock
        $this->readerMock->expects($this->exactly(2))
            ->method('valid')
            ->willReturnOnConsecutiveCalls(true, false);

        $this->readerMock->expects($this->once())
            ->method('current')
            ->willReturn($this->rowMock);

        // import user manager mock
        $this->importUserManagerMock->expects($this->once())
            ->method('save')
            ->with($this->equalTo($this->importUserMock));

        // import result factory mock
        $this->importResultFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo(1), $this->equalTo(0), $this->equalTo([]))
            ->willReturn($this->importResultMock);

        // never
        $this->constraintViolationListMock->expects($this->never())
            ->method('getIterator');
        $this->rowMock->expects($this->never())
            ->method('getLineNumber');

        $this->importCsvUser->import($this->pathMock);
    }
}
