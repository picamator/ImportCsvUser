<?php
declare(strict_types = 1);

namespace AppBundle\Model;

use AppBundle\Model\Api\ObjectManagerInterface;
use AppBundle\Model\Exception\RuntimeException;

/**
 * Creates objects, the main usage inside factories
 *
 * All objects are unshared, for shared objects please use DI service libraries
 */
class ObjectManager implements ObjectManagerInterface
{
    /**
     * @var array
     */
    private $reflectionContainer;

   /**
    * {@inheritdoc}
    */
    public function create(string $className, array $arguments = [])
    {
        // invalid class name
        if(empty($className) || !class_exists($className)) {
            throw new RuntimeException(sprintf('Class "%s" does not exist', $className));
        }

        // without arguments
        if (empty($arguments)) {
            return new $className();
        }

        // construction does not available
        if (method_exists($className,  '__construct') === false) {
            throw new RuntimeException(sprintf('Class "%s" does not have __construct', $className));
        }

        return $this->getReflection($className)
            ->newInstanceArgs($arguments);
    }

    /**
     * Retrieve reflection
     *
     * @param string $className
     *
     * @return \ReflectionClass
     */
    private function getReflection(string $className) : \ReflectionClass
    {
        if (empty($this->reflectionContainer[$className])) {
            $this->reflectionContainer[$className] = new \ReflectionClass($className);
        }

        return $this->reflectionContainer[$className];
    }
}
