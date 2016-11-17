<?php
declare(strict_types = 1);

namespace AppBundle\Model\Data;

use AppBundle\Model\Api\Data\ImportResultInterface;

/**
 * Import result value object
 *
 * @codeCoverageIgnore
 */
class ImportResult implements ImportResultInterface
{
    /**
     * @var int
     */
    private $imported;

    /**
     * @var int
     */
    private $skipped;

    /**
     * @var array
     */
    private $errorList;

    /**
     * @param int $imported
     * @param int $skipped
     * @param array $errorList
     */
    public function __construct(int $imported, int $skipped, array $errorList)
    {
        $this->imported     = $imported;
        $this->skipped      = $skipped;
        $this->errorList    = $errorList;
    }

    /**
     * {@inheritdoc}
     */
    public function getImported() : int
    {
        return $this->imported;
    }

    /**
     * {@inheritdoc}
     */
    public function getSkipped() : int
    {
        return $this->skipped;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorList() : array
    {
        return $this->errorList;
    }

    /**
     * {@inheritdoc}
     */
    public function __debugInfo()
    {
        return [
            'imported'  => $this->imported,
            'skipped'   => $this->skipped,
            'errorList' => $this->errorList,
        ];
    }
}
