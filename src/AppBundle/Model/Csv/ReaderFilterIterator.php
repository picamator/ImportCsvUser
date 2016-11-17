<?php
declare(strict_types = 1);

namespace AppBundle\Model\Csv;

use AppBundle\Model\Api\Csv\ReaderFilterIteratorInterface;
use AppBundle\Model\Api\Csv\ReaderInterface;
use AppBundle\Model\Api\Csv\RowFilterInterface;

/**
 * Reader Filter iterator
 *
 * @codeCoverageIgnore
 */
class ReaderFilterIterator extends \FilterIterator implements ReaderFilterIteratorInterface
{
    /**
     * @var RowFilterInterface
     */
    private $rowFilter;

    /**
     * @param ReaderInterface     $iterator
     * @param RowFilterInterface  $rowFilter
     */
    public function __construct(ReaderInterface $iterator, RowFilterInterface $rowFilter)
    {
        parent::__construct($iterator);

        $this->rowFilter = $rowFilter;
    }

    /**
     * {@inheritdoc}
     */
    public function accept()
    {
        $row = $this->getInnerIterator()->current();

        return $this->rowFilter->filter($row);
    }
}
