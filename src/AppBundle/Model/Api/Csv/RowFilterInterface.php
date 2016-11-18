<?php
namespace AppBundle\Model\Api\Csv;

use AppBundle\Model\Api\Csv\Data\RowInterface;

/**
 * Filter row
 */
interface RowFilterInterface
{
    /**
     * Filter
     *
     * @param RowInterface | null $row
     *
     * @return bool
     */
    public function filter($row) : bool;
}
