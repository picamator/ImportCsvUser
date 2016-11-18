<?php
declare(strict_types = 1);

namespace AppBundle\Model\Manager;

use AppBundle\Model\Api\Entity\ImportUserInterface;
use AppBundle\Model\Api\Manager\ImportUserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * ImportUser manager
 *
 * @codeCoverageIgnore
 */
class ImportUserManager implements ImportUserManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ImportUserInterface $importUser)
    {
        $this->entityManager->persist($importUser);
    }
}
