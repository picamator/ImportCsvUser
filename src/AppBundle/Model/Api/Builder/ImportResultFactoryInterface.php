<?php
namespace AppBundle\Model\Api\Builder;

use AppBundle\Model\Api\Data\ImportResultInterface;

/**
 * Create Import result
 */
interface ImportResultFactoryInterface
{
    /**
     * Create
     *
     * @param int   $imported
     * @param int   $skipped
     * @param array $errorList
     *
     * @return ImportResultInterface
     */
    public function create(int $imported, int $skipped, array $errorList) : ImportResultInterface;
}
