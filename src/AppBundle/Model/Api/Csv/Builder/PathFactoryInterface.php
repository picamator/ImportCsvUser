<?php
namespace AppBundle\Model\Api\Csv\Builder;

use AppBundle\Model\Api\Data\PathInterface;

/**
 * Create Path value object
 */
interface PathFactoryInterface
{
    /**
     * Create
     *
     * @param string $path
     *
     * @return PathInterface
     */
    public function create(string $path) : PathInterface;
}
