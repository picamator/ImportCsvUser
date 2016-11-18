<?php
namespace AppBundle\Model\Api\Csv\Builder;

use AppBundle\Model\Api\Csv\ReaderFilterIteratorInterface;

/**
 * Create Reader Filter iterator factory
 */
interface ReaderFilterIteratorFactoryInterface
{
    /**
     * Create
     *
     * @param string $path
     *
     * @return ReaderFilterIteratorInterface
     */
    public function create(string $path) : ReaderFilterIteratorInterface;
}
