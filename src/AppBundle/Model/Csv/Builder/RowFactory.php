<?php
declare(strict_types = 1);

namespace AppBundle\Model\Csv\Builder;

use AppBundle\Model\Api\Csv\Builder\RowFactoryInterface;
use AppBundle\Model\Api\Csv\Data\RowInterface;
use AppBundle\Model\Api\ObjectManagerInterface;

/**
 * Create Row
 *
 * @codeCoverageIgnore
 */
class RowFactory implements RowFactoryInterface
{
    /**
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var string
     */
    private $className;

    /**
     * @param ObjectManagerInterface    $objectManager
     * @param string                    $className
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        string $className = 'AppBundle\Model\Csv\Data\Row'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $header, array $row, int $lineNumber) : RowInterface
    {
        return $this->objectManager->create($this->className, [$header, $row, $lineNumber]);
    }
}
