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
     * @var string
     */
    private $delimiter;

    /**
     * @var string
     */
    private $enclosure;

    /**
     * @var resource
     */
    private $file;

    /**
     * @var array
     */
    private $header;

    /**
     * @var int
     */
    private $position =  0;

    /**
     * @var RowInterface
     */
    private $row;

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
        $this->rowFactory   = $rowFactory;
        $this->delimiter    = $delimiter;
        $this->enclosure    = $enclosure;

        // file
        $this->file = fopen($path, 'r+');
        $this->setHeader();
    }

    /**
     * Free resource on destruct
     */
    public function __destruct()
    {
        if (!is_null($this->file)) {
            fclose($this->file);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDelimiter() : string
    {
        return $this->delimiter;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnclosure() : string
    {
        return $this->enclosure;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->row;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $row = $this->getRow();
        if ($row === false) {
            return false;
        }

        $this->row  = $this->rowFactory->create($this->header, $row, $this->position);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return !feof($this->file);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        rewind($this->file);
        $this->position = 0;

        $this->getRow();
    }

    /**
     * {@inheritdoc}
     */
    public function __debugInfo()
    {
        return [
            $this->row,
            $this->position
        ];
    }

    /**
     * Get row
     *
     * @return array
     */
    private function getRow() : array
    {
        $this->position ++;

        return fgetcsv($this->file, null, $this->delimiter, $this->enclosure) ? : [];
    }

    /**
     * Set header
     */
    private function setHeader()
    {
        $row = $this->getRow();
        if (empty($this->header)) {

            $this->header = array_map(function($item) {
                return strtolower(trim(str_replace('#', '', $item)));
            }, $row);
        }
    }
}
