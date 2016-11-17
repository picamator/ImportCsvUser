<?php
namespace AppBundle\Model\Api;

use AppBundle\Model\Api\Csv\ReaderFilterIteratorInterface;
use AppBundle\Model\Api\Data\ImportResultInterface;

interface ImportInterface
{
    /**
     * Import
     *
     * @param ReaderFilterIteratorInterface $reader
     *
     * @return ImportResultInterface
     */
    public function import(ReaderFilterIteratorInterface $reader) : ImportResultInterface;
}
