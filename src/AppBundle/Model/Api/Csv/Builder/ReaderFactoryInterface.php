<?php
namespace AppBundle\Model\Api\Builder;

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
     * @param string $delimiter
     * @param string $enclosure
     *
     * @return ReaderInterface
     */
    public function create(string $path, string $delimiter = ',', string $enclosure = '"') : ReaderInterface;
}
