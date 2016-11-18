<?php
namespace AppBundle\Tests\Model;

use AppBundle\Model\ImportCsvUser;

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
     * @var \Symfony\Component\Validator\ConstraintViolationListInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $constraintViolationListMock;

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
    private $readerFilterIteratorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->entityManagerMock = $this->getTransactionalEntityManagerMock();

        // validator mock
        $this->validatorMock = $this->getMockBuilder('Symfony\Component\Validator\Validator\ValidatorInterface')
            ->getMock();
        $this->constraintViolationListMock = $this->getMockBuilder('Symfony\Component\Validator\ConstraintViolationListInterface')
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

        $this->readerFilterIteratorMock = $this->getMockBuilder('AppBundle\Model\Api\Csv\ReaderFilterIteratorInterface')
            ->getMock();

        $this->importCsvUser = new ImportCsvUser(
            $this->entityManagerMock,
            $this->validatorMock,
            $this->importUserFactoryMock,
            $this->importUserManagerMock,
            $this->importResultFactoryMock
        );
    }

    public function testValidImport()
    {
        $this->markTestIncomplete();

        // row mock
        $rowMock = $this->getMockBuilder('AppBundle\Model\Api\Csv\Data\RowInterface')
            ->getMock();

        // reader mock
        $this->readerFilterIteratorMock->expects($this->once())
            ->method('accept')
            ->willReturn(true);

        // import user factory mock
        $this->importUserFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($rowMock))
            ->willReturn($this->importUserMock);

        // constraint violation list mock
        $this->constraintViolationListMock->expects($this->once())
            ->method('count')
            ->willReturn(0);

        // validator mock
        $this->validatorMock->expects($this->once())
            ->method('validate')
            ->with($this->equalTo($this->importUserMock))
            ->willReturn($this->constraintViolationListMock);

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
        $rowMock->expects($this->never())
            ->method('getLineNumber');

        $this->importCsvUser->import($this->readerFilterIteratorMock);
    }
}
