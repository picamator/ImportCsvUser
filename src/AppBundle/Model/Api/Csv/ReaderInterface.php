<?php
namespace AppBundle\Model\Api\Csv;

/**
 * Csv reader, iterate over csv file collection header and current row together into one object
 */
interface ReaderInterface extends \Iterator
{
    /**
     * Get delimiter
     *
     * @return string
     */
    public function getDelimiter() : string;

    /**
     * Get enclosure
     *
     * @return string
     */
    public function getEnclosure() : string;
}
