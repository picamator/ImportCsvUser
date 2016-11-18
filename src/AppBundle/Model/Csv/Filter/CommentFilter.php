<?php
declare(strict_types = 1);

namespace AppBundle\Model\Csv\Filter;

use AppBundle\Model\Api\Csv\RowFilterInterface;

/**
 * Comment filter row
 */
class CommentFilter implements RowFilterInterface
{
    /**
     * @var string
     */
    private static $commentMark = '#';

    /**
     * {@inheritdoc}
     */
    public function filter($row) : bool
    {
        $firstRowItem = $row->getRow()[0] ?? self::$commentMark;
        $firstRowItem = trim($firstRowItem);

        return strpos($firstRowItem, self::$commentMark) !== 0;
    }
}
