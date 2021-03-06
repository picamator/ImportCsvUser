<?php
declare(strict_types = 1);

namespace AppBundle\Service;

use AppBundle\Model\Api\Builder\ImportResultFactoryInterface;
use AppBundle\Model\Api\Builder\ImportUserFactoryInterface;
use AppBundle\Model\Api\Csv\Builder\ReaderFilterIteratorFactoryInterface;
use AppBundle\Model\Api\Csv\Data\RowInterface;
use AppBundle\Model\Api\Data\ImportResultInterface;
use AppBundle\Model\Api\Data\PathInterface;
use AppBundle\Model\Api\Manager\ImportUserManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Import user
 *
 * @todo move error rendering to different class
 */
class ImportCsvUser
{
    /**
     * @var string
     */
    private static $errorTemplate = 'Line #%s: Invalid parameter \'%s\'. %s';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ReaderFilterIteratorFactoryInterface
     */
    private $readerFactory;

    /**
     * @var ImportUserFactoryInterface
     */
    private $importUserFactory;

    /**
     * @var ImportUserManagerInterface
     */
    private $importUserManager;

    /**
     * @var ImportResultFactoryInterface
     */
    private $importResultFactory;

    /**
     * Error pool
     *
     * @var array
     */
    private $errorList= [];

    /**
     * @var int
     */
    private $skipped = 0;

    /**
     * @var int
     */
    private $imported = 0;

    /**
     * @param EntityManagerInterface                $entityManager
     * @param ValidatorInterface                    $validator
     * @param ReaderFilterIteratorFactoryInterface  $readerFactory
     * @param ImportUserFactoryInterface            $importUserFactory
     * @param ImportUserManagerInterface            $importUserManager
     * @param ImportResultFactoryInterface          $importResultFactory
     */
    public function __construct(
        EntityManagerInterface                  $entityManager,
        ValidatorInterface                      $validator,
        ReaderFilterIteratorFactoryInterface    $readerFactory,
        ImportUserFactoryInterface              $importUserFactory,
        ImportUserManagerInterface              $importUserManager,
        ImportResultFactoryInterface            $importResultFactory
    ) {
        $this->entityManager        = $entityManager;
        $this->validator            = $validator;
        $this->readerFactory        = $readerFactory;
        $this->importUserFactory    = $importUserFactory;
        $this->importUserManager    = $importUserManager;
        $this->importResultFactory  = $importResultFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function import(PathInterface $path) : ImportResultInterface
    {
        // validate path
        $errorList = $this->validator->validate($path);
        if ($errorList->count() > 0) {
            $this->addError(0, $errorList);

            $importResult =  $this->importResultFactory->create($this->imported, $this->skipped, $this->errorList);
            $this->postClean();

            return $importResult;
        }

        // save
        $reader = $this->readerFactory->create($path->getPath());

        $this->entityManager->transactional(function() use ($reader) {
            /** @var RowInterface $item */
            foreach ($reader as $item) {
                $importUser = $this->importUserFactory->create($item);

                // validate
                $errorList = $this->validator->validate($importUser);
                if ($errorList->count() > 0) {
                    $this->addError($item->getLineNumber(), $errorList);
                    continue;
                }
                $this->importUserManager->save($importUser);
                $this->imported ++;
            }
        });

        // create result
        $importResult = $this->importResultFactory->create($this->imported, $this->skipped, $this->errorList);
        $this->postClean();

        return $importResult;
    }

    /**
     * Add error
     *
     * @param int $lineNumber
     * @param ConstraintViolationListInterface  $errorList
     *
     * @return void
     */
    private function addError(int $lineNumber, ConstraintViolationListInterface $errorList)
    {
        $renderedList= [];

        /** @var ConstraintViolationInterface $item */
        foreach ($errorList as $item) {
            $renderedList[] = sprintf(self::$errorTemplate, $lineNumber, $item->getPropertyPath(), $item->getMessage());
        }

        $this->errorList[] = implode($renderedList, PHP_EOL);
        $this->skipped ++;
    }

    /**
     * Post clean
     *
     * @return void
     */
    private function postClean()
    {
        // clear parameters
        $this->skipped      = 0;
        $this->imported     = 0;
        $this->errorList    = [];
    }
}
