<?php
declare(strict_types = 1);

namespace AppBundle\Model\Csv\Builder;

use AppBundle\Model\Api\Csv\Builder\PathFactoryInterface;
use AppBundle\Model\Api\Data\PathInterface;
use AppBundle\Model\Api\ObjectManagerInterface;

/**
 * Create Path
 *
 * @codeCoverageIgnore
 */
class PathFactory implements PathFactoryInterface
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
        string $className = 'AppBundle\Model\Csv\Data\Path'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $path) : PathInterface
    {
        return $this->objectManager->create($this->className, [$path]);
    }
}
