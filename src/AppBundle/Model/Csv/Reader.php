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
     * @var string
     */
    private $path;

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
        $this->path         = $path;
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
        fclose($this->file);
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
        $this->position ++;

        $row        = $this->getRow();
        $this->row  = $this->rowFactory->create($this->header, $row, $this->position);
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
        $this->position = 0;
        rewind($this->file);

        // skip header
        $this->setHeader();
        $this->next();
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
        return fgetcsv($this->file, null, $this->delimiter, $this->enclosure) ? : [];
    }

    /**
     * Set header
     */
    private function setHeader()
    {
        if (!empty($this->header)) {
            return;
        }

        $row = $this->getRow();
        $this->header = array_map(function($item) {
            return strtolower(trim(str_replace('#', '', $item)));
        }, $row);

    }
}
