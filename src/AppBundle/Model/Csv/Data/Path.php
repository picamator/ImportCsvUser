<?php
declare(strict_types = 1);

namespace AppBundle\Model\Csv\Data;

use AppBundle\Model\Api\Data\PathInterface;

/**
 * Path date table
 *
 * @codeCoverageIgnore
 */
class Path implements PathInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath() : string
    {
       return $this->path;
    }
}
