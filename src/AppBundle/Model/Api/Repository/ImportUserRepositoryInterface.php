<?php
namespace AppBundle\Model\Api\Repository;

/**
 * ImportUser repository
 */
interface ImportUserRepositoryInterface
{
    const MALE = 'm';

    const FEMALE = 'f';

    /**
     * Get average age
     *
     * @param string $gender
     * @return float
     */
    public function getAverageAge(string $gender) : float;
}
