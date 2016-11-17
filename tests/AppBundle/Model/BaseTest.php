<?php
namespace AppBundle\Tests\Model;

use AppBundle\Model\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Base to share configuration over all tests
 */
abstract class BaseTest extends TestCase 
{
	protected function setUp() 
	{
		parent::setUp();
	}

    /**
     * Get EntityManager mock
     *
     * @return \Doctrine\ORM\EntityManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
	protected function getTransactionalEntityManagerMock()
    {
        $entityManagerMock = $this->getMockBuilder('Doctrine\ORM\EntityManagerInterface')
            ->getMock();

        $entityManagerMock->expects($this->any())
            ->method('transactional')
            ->willReturnCallback(function($callback) use ($entityManagerMock) {
                return call_user_func($callback, $entityManagerMock);
            });

        return $entityManagerMock;
    }

    /**
     * Gets data path
     *
     * @param string $fileName
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    protected function getDataPath(string $fileName) : string
    {
        $path = __DIR__ . '/../data/' . $fileName;
        if(!file_exists($path) || !is_readable($path)) {
            throw new InvalidArgumentException(
                sprintf('Con not run test. Data file "%s" does not exist or has wrong permission.', $path)
            );
        }

        return $path;
    }
}
