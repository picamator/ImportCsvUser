<?php
declare(strict_types = 1);

namespace AppBundle\Model\Csv\Builder;

use AppBundle\Model\Api\Csv\Builder\ReaderFactoryInterface;
use AppBundle\Model\Api\Csv\Builder\RowFactoryInterface;
use AppBundle\Model\Api\Csv\ReaderInterface;
use AppBundle\Model\Api\ObjectManagerInterface;

/**
 * Create Reader
 *
 * @codeCoverageIgnore
 */
class ReaderFactory implements ReaderFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var RowFactoryInterface
     */
    private $rowFactory;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface    $objectManager
     * @param RowFactoryInterface       $rowFactory
     * @param string                    $className
     */
    public function __construct(
        ObjectManagerInterface  $objectManager,
        RowFactoryInterface     $rowFactory,
        string                  $className = 'AppBundle\Model\Csv\Reader'
    ) {
        $this->objectManager    = $objectManager;
        $this->rowFactory       = $rowFactory;
        $this->className        = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $path) : ReaderInterface
    {
        return $this->objectManager->create($this->className, [$path, $this->rowFactory]);
    }
}
