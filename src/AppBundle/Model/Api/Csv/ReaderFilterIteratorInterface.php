<?php
namespace AppBundle\Model\Api\Csv;

/**
 * Reader Filter iterator
 */
interface ReaderFilterIteratorInterface
{
   /**
    * Check whether the current element of the iterator is acceptable
    * @link http://php.net/manual/en/filteriterator.accept.php
    * @return bool true if the current element is acceptable, otherwise false.
    * @since 5.1.0
    */
    public function accept();
}
