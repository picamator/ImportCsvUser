<?php
namespace AppBundle\Tests\Model\Csv;

use AppBundle\Model\Csv\Reader;
use AppBundle\Tests\Model\BaseTest;

class ImportCsvUserTest extends BaseTest
{
    /**
     * @var \AppBundle\Model\Api\Builder\RowFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $rowFactoryMock;

    /**
     * @var \AppBundle\Model\Api\Csv\Data\RowInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $rowMock;

    protected function setUp()
    {
        $this->rowFactoryMock = $this->getMockBuilder('AppBundle\Model\Api\Csv\Builder\RowFactoryInterface')
            ->getMock();

        $this->rowMock = $this->getMockBuilder('AppBundle\Model\Api\Csv\Data\RowInterface')
            ->getMock();

        parent::setUp();
    }

    public function testGetDelimiter()
    {
        $path   = $this->getDataPath('user.full.fields.csv');
        $reader = new Reader($path, $this->rowFactoryMock);

        $this->assertEquals(',', $reader->getDelimiter());
    }

    public function testGetEnclosure()
    {
        $path   = $this->getDataPath('user.full.fields.csv');
        $reader = new Reader($path, $this->rowFactoryMock);

        $this->assertEquals('"', $reader->getEnclosure());
    }

    public function testCurrent()
    {
        // row factory mock
        $this->rowFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->rowMock);

        $path   = $this->getDataPath('user.full.fields.csv');
        $reader = new Reader($path, $this->rowFactoryMock);

        $this->assertSame($reader->current(), $reader->current());
    }

    public function testFullFields()
    {
        // row factory mock
        $this->rowFactoryMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->rowMock);

        $path   = $this->getDataPath('user.full.fields.csv');
        $reader = new Reader($path, $this->rowFactoryMock);

        foreach($reader as $item) {
           $this->assertEquals($this->rowMock, $item);
        }
    }

    public function testHeadersOnly()
    {
        // row factory mock
        $this->rowFactoryMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->rowMock);

        $path   = $this->getDataPath('user.headers.only.csv', $this->rowFactoryMock);
        $reader = new Reader($path, $this->rowFactoryMock);

        foreach($reader as $item) {
            $this->assertEquals($this->rowMock, $item);
        }
    }

    public function testEmpty()
    {
        // row factory mock
        $this->rowFactoryMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->rowMock);

        $path   = $this->getDataPath('user.empty.csv', $this->rowFactoryMock);
        $reader = new Reader($path, $this->rowFactoryMock);

        foreach($reader as $item) {
            $this->assertEquals($this->rowMock, $item);
        }
    }

    public function testFullFieldsWithComments()
    {
        // row factory mock
        $this->rowFactoryMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->rowMock);

        $path   = $this->getDataPath('user.full.with.comments.csv', $this->rowFactoryMock);
        $reader = new Reader($path, $this->rowFactoryMock);

        foreach($reader as $item) {
            $this->assertEquals($this->rowMock, $item);
        }
    }
}
