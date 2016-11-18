<?php
namespace AppBundle\Tests\Command;

use AppBundle\Tests\BaseTest;

class UserImportCsvCommandTest extends BaseTest
{
    /**
     * @var \AppBundle\Command\UserImportCsvCommand | \PHPUnit_Framework_MockObject_MockObject
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
     * @var \AppBundle\Model\Api\Data\ImportResultInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $importResultMock;

    /**
     * @var \AppBundle\Model\Api\Csv\Builder\PathFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pathFactoryMock;

    /**
     * @var \AppBundle\Model\Api\Data\PathInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pathMock;

    /**
     * @var \AppBundle\Service\ImportCsvUser | \PHPUnit_Framework_MockObject_MockObject
     */
    private $importUserMock;

    protected function setUp()
    {
        parent::setUp();

        $this->inputMock = $this->getMockBuilder('Symfony\Component\Console\Input\InputInterface')
            ->getMock();

        $this->outputMock = $this->getMockBuilder('Symfony\Component\Console\Output\OutputInterface')
            ->getMock();

        $this->containerMock = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerInterface')
            ->getMock();

        $this->importResultMock = $this->getMockBuilder('AppBundle\Model\Api\Data\ImportResultInterface')
            ->getMock();

        $this->pathFactoryMock = $this->getMockBuilder('AppBundle\Model\Api\Csv\Builder\PathFactoryInterface')
            ->getMock();

        $this->pathMock = $this->getMockBuilder('AppBundle\Model\Api\Data\PathInterface')
            ->getMock();

        $this->importUserMock = $this->getMockBuilder('AppBundle\Service\ImportCsvUser')
            ->disableOriginalConstructor()
            ->getMock();

        $this->commandMock = $this->getMockBuilder('AppBundle\Command\UserImportCsvCommand')
            ->setMethods(['getContainer'])
            ->getMock();
    }

    public function testExecute()
    {
        $path = 'test.csv';

        // input mock
        $this->inputMock->expects($this->once())
            ->method('getOption')
            ->with($this->equalTo('path'))
            ->willReturn($path);

        // container mock
        $this->containerMock->expects($this->exactly(2))
            ->method('get')
            ->withConsecutive(['csv_builder_path_factory'], ['service_import_csv_user'])
            ->willReturnOnConsecutiveCalls($this->pathFactoryMock, $this->importUserMock);

        // path factory mock
        $this->pathFactoryMock->expects($this->once())
            ->method('create')
            ->with($path)
            ->willReturn($this->pathMock);

        // import user mock
        $this->importUserMock->expects($this->once())
            ->method('import')
            ->with($this->equalTo($this->pathMock))
            ->willReturn($this->importResultMock);

        // import result mock
        $this->importResultMock->expects($this->once())
            ->method('getImported')
            ->willReturn(0);

        $this->importResultMock->expects($this->once())
            ->method('getSkipped')
            ->willReturn(1);

        $this->importResultMock->expects($this->once())
            ->method('getErrorList')
            ->willReturn(['message']);

        // output mock
        $this->outputMock->expects($this->once())
            ->method('writeln');

        // command mock
        $this->commandMock->expects($this->exactly(2))
            ->method('getContainer')
            ->willReturn($this->containerMock);

        $this->commandMock->run($this->inputMock, $this->outputMock);
    }
}
