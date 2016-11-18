<?php
declare(strict_types = 1);

namespace AppBundle\Service;

use AppBundle\Model\Api\Repository\ImportUserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Gender statistics
 */
class AgeStatistics
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get average age
     *
     * @param string $gender
     *
     * @return float
     */
    public function getAverageAge(string $gender) : float
    {
       /** @var ImportUserRepositoryInterface $repository */
        $repository = $this->entityManager->getRepository('AppBundle\Entity\ImportUser');

        return $repository->getAverageAge($gender);
    }
}
