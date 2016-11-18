<?php
namespace AppBundle\Model\Api\Builder;

use AppBundle\Model\Api\Csv\Data\RowInterface;
use AppBundle\Model\Api\Entity\ImportUserInterface;

/**
 * Create ImportUser entity
 */
interface ImportUserFactoryInterface
{
    /**
     * Create
     *
     * @param RowInterface $row
     *
     * @return ImportUserInterface
     */
    public function create(RowInterface $row) : ImportUserInterface;
}
