<?php
namespace AppBundle\Model\Api\Csv\Builder;

use AppBundle\Model\Api\Csv\ReaderInterface;

/**
 * Create Reader
 */
interface ReaderFactoryInterface
{
    /**
     * Create
     *
     * @param string $path
     *
     * @return ReaderInterface
     */
    public function create(string $path) : ReaderInterface;
}
