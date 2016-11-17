<?php
namespace AppBundle\Model\Api\Data;

/**
 * Import result value object
 */
interface ImportResultInterface
{
    /**
     * Get imported
     *
     * @return int
     */
    public function getImported() : int;

    /**
     * Get skipped
     *
     * @return int
     */
    public function getSkipped() : int;

    /**
     * Get all errors as a string
     *
     * @return array
     */
    public function getErrorList() : array;
}
