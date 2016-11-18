<?php
namespace AppBundle\Tests\Command;

use AppBundle\Tests\BaseTest;

class UserAgeAverageCommandTest extends BaseTest
{
    /**
     * @var \AppBundle\Command\UserAgeAverageCommand | \PHPUnit_Framework_MockObject_MockObject
     */
    private $commandMock;

    /**
     * @var \Symfony\Component\Console\Input\InputInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $inputMock;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $outputMock;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $containerMock;

    /**
     * @var \AppBundle\Service\AgeStatistics | \PHPUnit_Framework_MockObject_MockObject
     */
    private $ageAverageMock;

    protected function setUp()
    {
        parent::setUp();

        $this->inputMock = $this->getMockBuilder('Symfony\Component\Console\Input\InputInterface')
            ->getMock();

        $this->outputMock = $this->getMockBuilder('Symfony\Component\Console\Output\OutputInterface')
            ->getMock();

        $this->containerMock = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerInterface')
            ->getMock();

        $this->ageAverageMock = $this->getMockBuilder('AppBundle\Service\AgeStatistics')
            ->disableOriginalConstructor()
            ->getMock();

        $this->commandMock = $this->getMockBuilder('AppBundle\Command\UserAgeAverageCommand')
            ->setMethods(['getContainer'])
            ->getMock();
    }

    public function testExecute()
    {
        // container mock
        $this->containerMock->expects($this->once())
            ->method('get')
            ->with($this->equalTo('service_age_average'))
            ->willReturn($this->ageAverageMock);

        // age average mock
        $this->ageAverageMock->expects($this->exactly(2))
            ->method('getAverageAge')
            ->withConsecutive(['m'], ['f'])
            ->willReturnOnConsecutiveCalls(30, 25);

        // output mock
        $this->outputMock->expects($this->once())
            ->method('writeln');

        // command mock
        $this->commandMock->expects($this->once())
            ->method('getContainer')
            ->willReturn($this->containerMock);

        $this->commandMock->run($this->inputMock, $this->outputMock);
    }
}
