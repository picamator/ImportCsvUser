<?php
declare(strict_types = 1);

namespace AppBundle\Model\Csv;

use AppBundle\Model\Api\Csv\Builder\RowFactoryInterface;
use AppBundle\Model\Api\Csv\Data\RowInterface;
use AppBundle\Model\Api\Csv\ReaderInterface;

/**
 * Csv reader, iterate over csv file collection header and current row together into one object
 *
 * @codeCoverageIgnore
 */
class Reader implements ReaderInterface
{
    /**
     * @var RowFactoryInterface
     */
    private $rowFactory;

    /**
     * @var \SplFileObject
     */
    private $splFileObject;

    /**
     * @var array
     */
    private $header;

    /**
     * @var RowInterface
     */
    private $currentRow;

    /**
     * @param string                $path
     * @param RowFactoryInterface   $rowFactory
     * @param string                $delimiter
     * @param string                $enclosure
     */
    public function __construct(
        string              $path,
        RowFactoryInterface $rowFactory,
        string              $delimiter = ',',
        string              $enclosure = '"'
    ) {
        $this->rowFactory       = $rowFactory;
        $this->splFileObject    = new \SplFileObject($path);

        $this->splFileObject->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::DROP_NEW_LINE);
        $this->splFileObject->setCsvControl($delimiter, $enclosure);
    }

    /**
     * Free resource
     */
    public function __destruct()
    {
        $this->splFileObject= null;
    }

    /**
     * {@inheritdoc}
     */
    public function getDelimiter() : string
    {
        return $this->splFileObject->getCsvControl()[0];
    }

    /**
     * {@inheritdoc}
     */
    public function getEnclosure() : string
    {
        return $this->splFileObject->getCsvControl()[1];
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        // set header
        if ($this->splFileObject->key() === 0) {
            $this->setHeader();
        }

        // prevent creating row object for multiple current asking
        if (is_null($this->currentRow)) {
            $row = $this->splFileObject->current() ? : [];
            $this->currentRow = $this->rowFactory->create($this->header, $row, $this->key());
        }

        return $this->currentRow;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->currentRow = null;
        $this->splFileObject->next();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->splFileObject->key();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->splFileObject->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->splFileObject->rewind();
    }

    /**
     * Set header
     */
    private function setHeader()
    {
        if (is_null($this->header)) {
            $header = $this->splFileObject->current() ? : [];
            $this->header = array_map(function($item) {
                return strtolower(trim(preg_replace('/^[^A-Za-z]+/', '', $item)));
            },  $header);
        }

        $this->next();
    }
}
