<?php
declare(strict_types = 1);

namespace AppBundle\Model\Builder;

use AppBundle\Model\Api\Builder\ImportUserFactoryInterface;
use AppBundle\Model\Api\Csv\Data\RowInterface;
use AppBundle\Model\Api\Entity\ImportUserInterface;
use AppBundle\Model\Api\ObjectManagerInterface;

/**
 * Create ImportUser entity
 */
class ImportUserFactory implements ImportUserFactoryInterface
{
    /**
     * @var array ['row' => 'Entity/ImportUser']
     */
    private static $schema = [
        'firstname'     => 'firstName',
        'infix'         => 'infix',
        'lastname'      => 'lastName',
        'date of birth' => 'birthDate',
        'gender'        => 'gender',
        'zipcode'       => 'zipCode',
        'housenumber'   => 'houseNumber',
    ];

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
        string $className = 'AppBundle\Entity\ImportUser'
    ) {
        $this->objectManager = $objectManager;
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function create(RowInterface $row) : ImportUserInterface
    {
        // convert schema, it's possible to have empty row or invalid one therefore index schema should be always regenerated
        $schemaIndex = [];
        foreach (self::$schema as $key => $value) {
            $indexItem = array_search($key, $row->getHeader());
            if ($indexItem === false) {
                continue;
            }

            $schemaIndex[$indexItem] = $value;
        }

        /** @var ImportUserInterface $importUser */
        $importUser = $this->objectManager->create($this->className);
        foreach($row->getRow() as $key => $value) {
            if(!isset($schemaIndex[$key])) {
                continue;
            }

            $methodName = 'set' . ucfirst($schemaIndex[$key]);
            $importUser->$methodName($value);
        }

        return $importUser;
    }
}
