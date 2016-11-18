<?php
namespace AppBundle\Model\Api\Manager;

use AppBundle\Model\Api\Entity\ImportUserInterface;

/**
 * ImportUser manager
 */
interface ImportUserManagerInterface
{
    /**
     * Save
     *
     * @param ImportUserInterface $importUser
     *
     * @return void
     */
    public function save(ImportUserInterface $importUser);
}
