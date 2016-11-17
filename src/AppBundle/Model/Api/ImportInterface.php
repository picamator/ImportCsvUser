<?php
namespace AppBundle\Model\Api;

use AppBundle\Model\Api\Csv\ReaderInterface;
use AppBundle\Model\Api\Data\ImportResultInterface;

interface ImportInterface
{
    /**
     * Import
     *
     * @param ReaderInterface $reader
     *
     * @return ImportResultInterface
     */
    public function import(ReaderInterface $reader) : ImportResultInterface;
}
