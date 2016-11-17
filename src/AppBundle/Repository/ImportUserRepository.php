<?php
declare(strict_types = 1);

namespace AppBundle\Repository;

use AppBundle\Model\Api\Repository\ImportUserRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * ImportUser repository
 *
 * @codeCoverageIgnore
 */
class ImportUserRepository extends EntityRepository  implements ImportUserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAverageAge(string $gender) : float
    {
        $query = $this->createQueryBuilder('iu')
            ->select('AVG(TIMESTAMPDIFF(YEAR, iu.birthdate, CURDATE())) AS average')
            ->where('iu.gender = ?1')
            ->andWhere('iu.birthdate IS NOT NUL')
            ->setParameter(1, $gender)
            ->getQuery();

        try {
            return round($query->getSingleScalarResult(), 2);

        } catch (NoResultException $e) {
            return 0;
        }
    }
}
