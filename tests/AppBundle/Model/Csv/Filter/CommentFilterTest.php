<?php
namespace AppBundle\Tests\Model\Csv\Filter;

use AppBundle\Model\Csv\Filter\CommentFilter;
use AppBundle\Tests\Model\BaseTest;

class CommentFilterTest extends BaseTest
{
    /**
     * @var CommentFilter
     */
    private $filter;

    /**
     * @var \AppBundle\Model\Api\Csv\Data\RowInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $rowMock;

    protected function setUp()
    {
        parent::setUp();

        $this->rowMock = $this->getMockBuilder('AppBundle\Model\Api\Csv\Data\RowInterface')
            ->getMock();

        $this->filter = new CommentFilter();
    }

    public function testNullRowFilter()
    {
        // row mock
        $this->rowMock->expects($this->once())
            ->method('getRow');

        $actual = $this->filter->filter($this->rowMock);
        $this->assertFalse($actual);
    }

    public function testEmptyFirstColumnFilter()
    {
        // row mock
        $this->rowMock->expects($this->once())
            ->method('getRow')
            ->willReturn([null]);

        $actual = $this->filter->filter($this->rowMock);
        $this->assertFalse($actual);
    }

    public function testCommentMarkFilter()
    {
        // row mock
        $this->rowMock->expects($this->once())
            ->method('getRow')
            ->willReturn([' # ']);

        $actual = $this->filter->filter($this->rowMock);
        $this->assertFalse($actual);
    }
    public function testFilter()
    {
        // row mock
        $this->rowMock->expects($this->once())
            ->method('getRow')
            ->willReturn(['Test']);

        $actual = $this->filter->filter($this->rowMock);
        $this->assertTrue($actual);
    }

}
