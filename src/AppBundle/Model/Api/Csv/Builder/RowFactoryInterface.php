<?php
namespace AppBundle\Model\Api\Csv\Builder;

use AppBundle\Model\Api\Csv\Data\RowInterface;

/**
 * Create Row
 */
interface RowFactoryInterface
{
    /**
     * Create
     *
     * @param array $header
     * @param array $row
     * @param int   $lineNumber
     *
     * @return RowInterface
     */
    public function create(array $header, array $row, int $lineNumber) : RowInterface;
}
