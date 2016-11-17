<?php
declare(strict_types = 1);

namespace AppBundle\Model\Csv\Builder;

use AppBundle\Model\Api\Csv\Builder\ReaderFactoryInterface;
use AppBundle\Model\Api\Csv\Builder\ReaderFilterIteratorFactoryInterface;
use AppBundle\Model\Api\Csv\Builder\RowFactoryInterface;
use AppBundle\Model\Api\Csv\ReaderFilterIteratorInterface;
use AppBundle\Model\Api\Csv\RowFilterInterface;
use AppBundle\Model\Api\ObjectManagerInterface;

/**
 * Create Reader Filter iterator factory
 *
 * @codeCoverageIgnore
 */
class ReaderFilterIteratorFactory implements ReaderFilterIteratorFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var ReaderFactoryInterface
     */
    private $readerFactory;

    /**
     * @var RowFilterInterface
     */
    private $rowFilter;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface    $objectManager
     * @param ReaderFactoryInterface    $readerFactory
     * @param RowFilterInterface        $rowFilter,
     * @param string                    $className
     */
    public function __construct(
        ObjectManagerInterface  $objectManager,
        ReaderFactoryInterface  $readerFactory,
        RowFilterInterface      $rowFilter,
        string                  $className = 'AppBundle\Model\Csv\ReaderFilterIterator'
    ) {
        $this->objectManager    = $objectManager;
        $this->readerFactory    = $readerFactory;
        $this->rowFilter        = $rowFilter;
        $this->className        = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $path) : ReaderFilterIteratorInterface
    {
        $reader = $this->readerFactory->create($path);

        return $this->objectManager->create($this->className, [$reader, $this->rowFilter]);
    }
}
