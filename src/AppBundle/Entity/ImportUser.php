<?php
namespace AppBundle\Entity;

use AppBundle\Model\Api\Entity\ImportUserInterface;

/**
 * ImportUser entity
 *
 * @codeCoverageIgnore
 */
class ImportUser implements ImportUserInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $infix;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var \DateTime
     */
    private $birthDate;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string
     */
    private $zipCode;

    /**
     * @var string
     */
    private $houseNumber;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return ImportUser
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set infix
     *
     * @param string $infix
     *
     * @return ImportUser
     */
    public function setInfix($infix)
    {
        $this->infix = $infix;

        return $this;
    }

    /**
     * Get infix
     *
     * @return string
     */
    public function getInfix()
    {
        return $this->infix;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return ImportUser
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return ImportUser
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return ImportUser
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return ImportUser
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set houseNumber
     *
     * @param string $houseNumber
     *
     * @return ImportUser
     */
    public function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;

        return $this;
    }

    /**
     * Get houseNumber
     *
     * @return string
     */
    public function getHouseNumber()
    {
        return $this->houseNumber;
    }
}
