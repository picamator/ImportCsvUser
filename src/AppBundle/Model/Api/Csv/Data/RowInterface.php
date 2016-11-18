<?php
namespace AppBundle\Model\Api\Csv\Data;

/**
 * Csv row value object
 */
interface RowInterface
{
    /**
     * Get header
     *
     * @return array
     */
    public function getHeader() : array;

    /**
     * Get row
     *
     * @return array
     */
    public function getRow() : array;

    /**
     * Get line number
     *
     * @return int
     */
    public function getLineNumber() : int;
}
