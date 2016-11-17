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

    public function testFullFields()
    {
        $this->markTestIncomplete();

        // row factory mock
        $this->rowFactoryMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->rowMock);

        $path   = $this->getDataPath('full.fields.user.csv', $this->rowFactoryMock);
        $reader = new Reader($path, $this->rowFactoryMock);

        foreach($reader as $item) {
           $this->assertEquals($this->rowMock, $item);
        }
    }

    public function testNoData()
    {
        $this->markTestIncomplete();

        // row factory mock
        $this->rowFactoryMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->rowMock);

        $path   = $this->getDataPath('headers.only.user.csv', $this->rowFactoryMock);
        $reader = new Reader($path, $this->rowFactoryMock);

        foreach($reader as $item) {

            var_dump($item);

            $this->assertEquals($this->rowMock, $item);
        }
    }

    public function testEmptyFile()
    {
        $this->markTestIncomplete();

        // row factory mock
        $this->rowFactoryMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->rowMock);

        $path   = $this->getDataPath('empty.user.csv', $this->rowFactoryMock);
        $reader = new Reader($path, $this->rowFactoryMock);

        foreach($reader as $item) {
            $this->assertEquals($this->rowMock, $item);
        }
    }

    public function testFullFieldsWithComments()
    {
        $this->markTestIncomplete();

        // row factory mock
        $this->rowFactoryMock->expects($this->atLeastOnce())
            ->method('create')
            ->willReturn($this->rowMock);

        $path   = $this->getDataPath('full.with.comments.user.csv', $this->rowFactoryMock);
        $reader = new Reader($path, $this->rowFactoryMock);

        foreach($reader as $item) {
            $this->assertEquals($this->rowMock, $item);
        }
    }
}
