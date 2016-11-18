<?php
namespace AppBundle\Tests\Service;

use AppBundle\Service\AgeStatistics;
use AppBundle\Tests\Model\BaseTest;

class AgeStatisticsTest extends BaseTest
{
    /**
     * @var AgeStatistics
     */
    private $service;

    /**
     * @var \Doctrine\ORM\EntityManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManagerMock;

    /**
     * @var \AppBundle\Model\Api\Repository\ImportUserRepositoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $repositoryMock;

    protected function setUp()
    {
        parent::setUp();

        $this->entityManagerMock = $this->getMockBuilder('Doctrine\ORM\EntityManagerInterface')
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder('AppBundle\Model\Api\Repository\ImportUserRepositoryInterface')
            ->getMock();

        $this->service = new AgeStatistics($this->entityManagerMock);
    }

    public function testGetAverageAge()
    {
        $gender = 'm';
        $age = 10;

        // entity manager mock
        $this->entityManagerMock->expects($this->once())
            ->method('getRepository')
            ->with($this->equalTo('AppBundle\Entity\ImportUser'))
            ->willReturn($this->repositoryMock);

        // repository mock
        $this->repositoryMock->expects($this->once())
            ->method('getAverageAge')
            ->with($this->equalTo($gender))
            ->willReturn($age);

        $this->service->getAverageAge($gender);
    }
}
