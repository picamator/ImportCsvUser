<?php
declare(strict_types = 1);

namespace AppBundle\Model\Csv\Data;

use AppBundle\Model\Api\Csv\Data\RowInterface;

/**
 * Csv row value object
 *
 * @codeCoverageIgnore
 */
class Row implements RowInterface
{
    /**
     * @var array
     */
    private $header;

    /**
     * @var array
     */
    private $row;

    /**
     * @var int
     */
    private $lineNumber;

    /**
     * @param array $header
     * @param array $row
     * @param int   $lineNumber
     */
    public function __construct(array $header, array $row, int $lineNumber)
    {
        $this->header       = $header;
        $this->row          = $row;
        $this->lineNumber   = $lineNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader() : array
    {
        return $this->header;
    }

    /**
     * {@inheritdoc}
     */
    public function getRow() : array
    {
        return $this->row;
    }

    /**
     * {@inheritdoc}
     */
    public function getLineNumber() : int
    {
        return $this->lineNumber;
    }

    public function __debugInfo()
    {
        return [
            'header'        => $this->header,
            'row  '         => $this->row,
            'lineNumber'    => $this->lineNumber,
        ];
    }
}
