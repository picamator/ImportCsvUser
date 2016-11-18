<?php
namespace AppBundle\Model\Api\Entity;

/**
 * ImportUser entity
 */
interface ImportUserInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return ImportUser
     */
    public function setFirstName($firstName);

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Set infix
     *
     * @param string $infix
     *
     * @return ImportUser
     */
    public function setInfix($infix);

    /**
     * Get infix
     *
     * @return string
     */
    public function getInfix();

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return ImportUser
     */
    public function setLastName($lastName);

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName();

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return ImportUser
     */
    public function setBirthDate($birthDate);

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate();

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return ImportUser
     */
    public function setGender($gender);

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender();

    /**
     * Set zipCode
     *
     * @param string $zipCode
     *
     * @return ImportUser
     */
    public function setZipCode($zipCode);

    /**
     * Get zipCode
     *
     * @return string
     */
    public function getZipCode();

    /**
     * Set houseNumber
     *
     * @param string $houseNumber
     *
     * @return ImportUser
     */
    public function setHouseNumber($houseNumber);

    /**
     * Get houseNumber
     *
     * @return string
     */
    public function getHouseNumber();

    /**
     * Do birthDate pre persist
     *
     * @return void
     */
    public function doBirthDatePrePersist();

    /**
     * Do zipCode pre persist
     *
     * @return void
     */
    public function doZipCodePrePersist();
}
