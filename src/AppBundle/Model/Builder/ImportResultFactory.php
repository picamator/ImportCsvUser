<?php
declare(strict_types = 1);

namespace AppBundle\Model\Builder;

use AppBundle\Model\Api\Builder\ImportResultFactoryInterface;
use AppBundle\Model\Api\Data\ImportResultInterface;

/**
 * Create Import result
 *
 * @codeCoverageIgnore
 */
class ImportResultFactory implements ImportResultFactoryInterface
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
        string $className = 'AppBundle\Model\Data\ImportResult'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function create(int $imported, int $skipped, array $errorList) : ImportResultInterface
    {
        return $this->objectManager->create($this->className, [$imported, $skipped, $errorList]);
    }
}
