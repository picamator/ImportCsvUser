<?php
declare(strict_types = 1);

namespace AppBundle\Model\Builder;

use AppBundle\Model\Api\Builder\ImportUserFactoryInterface;
use AppBundle\Model\Api\Csv\Data\RowInterface;
use AppBundle\Model\Api\Entity\ImportUserInterface;

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
     * @var ImportUserInterface
     */
    private $importUser;

    /**
     * @param ImportUserInterface $importUser
     */
    public function __construct(ImportUserInterface $importUser)
    {
        $this->importUser = $importUser;
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

        // sets
        foreach($row->getRow() as $key => $value) {
            if(!isset($schemaIndex[$key])) {
                continue;
            }

            $methodName = 'set' . ucfirst($schemaIndex[$key]);
            $this->importUser->$methodName($value);
        }

        return $this->importUser;
    }
}
