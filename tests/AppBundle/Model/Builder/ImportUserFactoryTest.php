<?php
namespace AppBundle\Tests\Builder;

use AppBundle\Model\Builder\ImportUserFactory;
use AppBundle\Tests\Model\BaseTest;

class ImportUserFactoryTest extends BaseTest
{
    /**
     * @var ImportUserFactory
     */
    private $factory;

    /**
     * @var \AppBundle\Model\Api\ObjectManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $objectManagerMock;

    /**
     * @var \AppBundle\Model\Api\Entity\ImportUserInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $importUserMock;

    /**
     * @var \AppBundle\Model\Api\Csv\Data\RowInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $rowMock;

    protected  function setUp()
    {
        parent::setUp();

        $this->objectManagerMock = $this->getMockBuilder('AppBundle\Model\Api\ObjectManagerInterface')
            ->getMock();

        $this->importUserMock = $this->getMockBuilder('AppBundle\Model\Api\Entity\ImportUserInterface')
            ->getMock();

        $this->rowMock = $this->getMockBuilder('AppBundle\Model\Api\Csv\Data\RowInterface')
            ->getMock();

        $this->factory = new ImportUserFactory($this->objectManagerMock);
    }

    public function testFullCreate()
    {
        $header = [
            'firstname',
            'infix',
            'lastname',
            'date of birth',
            'gender',
            'zipcode',
            'housenumber',
        ];
        $row = [
            'Test name',
            'der',
            'Test last name',
            '1991-08-24',
            'm',
            '000001',
            '12b',
        ];

        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo('AppBundle\Entity\ImportUser'))
            ->willReturn($this->importUserMock);

        // row mock
        $this->rowMock->expects($this->atLeastOnce())
            ->method('getHeader')
            ->willReturn($header);

        $this->rowMock->expects($this->once())
            ->method('getRow')
            ->willReturn($row);

        // import user mock
        $this->importUserMock->expects($this->once())
            ->method('setFirstName')
            ->with($this->equalTo($row[0]))
            ->willReturnSelf();

        $this->importUserMock->expects($this->once())
            ->method('setInfix')
            ->with($this->equalTo($row[1]))
            ->willReturnSelf();

        $this->importUserMock->expects($this->once())
            ->method('setLastName')
            ->with($this->equalTo($row[2]))
            ->willReturnSelf();

        $this->importUserMock->expects($this->once())
            ->method('setBirthDate')
            ->with($this->equalTo($row[3]))
            ->willReturnSelf();

        $this->importUserMock->expects($this->once())
            ->method('setGender')
            ->with($this->equalTo($row[4]))
            ->willReturnSelf();

        $this->importUserMock->expects($this->once())
            ->method('setZipCode')
            ->with($this->equalTo($row[5]))
            ->willReturnSelf();

        $this->importUserMock->expects($this->once())
            ->method('setHouseNumber')
            ->with($this->equalTo($row[6]))
            ->willReturnSelf();

        $this->factory->create($this->rowMock);
    }

    public function testPartialCreate()
    {
        $header = [
            'firstname',
            'infix',
            'lastname',
            'date of birth',
            'gender',
            'zipcode',
            'housenumber',
        ];
        $row = [
            'Test name',
            'der',
            'Test last name',
            '1991-08-24',
        ];

        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo('AppBundle\Entity\ImportUser'))
            ->willReturn($this->importUserMock);

        // row mock
        $this->rowMock->expects($this->atLeastOnce())
            ->method('getHeader')
            ->willReturn($header);

        $this->rowMock->expects($this->once())
            ->method('getRow')
            ->willReturn($row);

        // import user mock
        $this->importUserMock->expects($this->once())
            ->method('setFirstName')
            ->with($this->equalTo($row[0]))
            ->willReturnSelf();

        $this->importUserMock->expects($this->once())
            ->method('setInfix')
            ->with($this->equalTo($row[1]))
            ->willReturnSelf();

        $this->importUserMock->expects($this->once())
            ->method('setLastName')
            ->with($this->equalTo($row[2]))
            ->willReturnSelf();

        $this->importUserMock->expects($this->once())
            ->method('setBirthDate')
            ->with($this->equalTo($row[3]))
            ->willReturnSelf();

        // never
        $this->importUserMock->expects($this->never())
            ->method('setGender');
        $this->importUserMock->expects($this->never())
            ->method('setZipCode');

        $this->importUserMock->expects($this->never())
            ->method('setHouseNumber');

        $this->factory->create($this->rowMock);
    }

    public function testEmptyCreate()
    {
        $header = [
            'firstname',
            'infix',
            'lastname',
            'date of birth',
            'gender',
            'zipcode',
            'housenumber',
        ];
        $row = [];

        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo('AppBundle\Entity\ImportUser'))
            ->willReturn($this->importUserMock);

        // row mock
        $this->rowMock->expects($this->atLeastOnce())
            ->method('getHeader')
            ->willReturn($header);

        $this->rowMock->expects($this->once())
            ->method('getRow')
            ->willReturn($row);

        // never
        $this->importUserMock->expects($this->never())
            ->method('setFirstName');
        $this->importUserMock->expects($this->never())
            ->method('setInfix');
        $this->importUserMock->expects($this->never())
            ->method('setLastName');
        $this->importUserMock->expects($this->never())
            ->method('setBirthDate');
        $this->importUserMock->expects($this->never())
            ->method('setGender');
        $this->importUserMock->expects($this->never())
            ->method('setZipCode');
        $this->importUserMock->expects($this->never())
            ->method('setHouseNumber');

        $this->factory->create($this->rowMock);
    }

    public function testRowWiderThenHeaderCreate()
    {
        $header = [
            'firstname',
        ];
        $row = [
            'Test name',
            'test'
        ];

        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo('AppBundle\Entity\ImportUser'))
            ->willReturn($this->importUserMock);

        // row mock
        $this->rowMock->expects($this->atLeastOnce())
            ->method('getHeader')
            ->willReturn($header);

        $this->rowMock->expects($this->once())
            ->method('getRow')
            ->willReturn($row);

        // import user mock
        $this->importUserMock->expects($this->once())
            ->method('setFirstName')
            ->with($this->equalTo($row[0]))
            ->willReturnSelf();

        // never
        $this->importUserMock->expects($this->never())
            ->method('setInfix');
        $this->importUserMock->expects($this->never())
            ->method('setLastName');
        $this->importUserMock->expects($this->never())
            ->method('setBirthDate');
        $this->importUserMock->expects($this->never())
            ->method('setGender');
        $this->importUserMock->expects($this->never())
            ->method('setZipCode');
        $this->importUserMock->expects($this->never())
            ->method('setHouseNumber');


        $this->factory->create($this->rowMock);
    }

    public function testUnknownHeaderCreate()
    {
        $header = [
            'firstname',
            'New header'
        ];
        $row = [
            'Test name',
            'test'
        ];

        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo('AppBundle\Entity\ImportUser'))
            ->willReturn($this->importUserMock);

        // row mock
        $this->rowMock->expects($this->atLeastOnce())
            ->method('getHeader')
            ->willReturn($header);

        $this->rowMock->expects($this->once())
            ->method('getRow')
            ->willReturn($row);

        // import user mock
        $this->importUserMock->expects($this->once())
            ->method('setFirstName')
            ->with($this->equalTo($row[0]))
            ->willReturnSelf();

        // never
        $this->importUserMock->expects($this->never())
            ->method('setInfix');
        $this->importUserMock->expects($this->never())
            ->method('setLastName');
        $this->importUserMock->expects($this->never())
            ->method('setBirthDate');
        $this->importUserMock->expects($this->never())
            ->method('setGender');
        $this->importUserMock->expects($this->never())
            ->method('setZipCode');
        $this->importUserMock->expects($this->never())
            ->method('setHouseNumber');


        $this->factory->create($this->rowMock);
    }
}
