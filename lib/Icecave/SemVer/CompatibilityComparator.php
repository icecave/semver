<?php
namespace Icecave\SemVer;

use Icecave\SemVer\TypeCheck\TypeCheck;

/**
 * Compares two version instances such that they compare as equal whenever $right is compatible with $left.
 */
class CompatibilityComparator extends Comparator
{
    public function __construct()
    {
        parent::__construct();

        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
    }

    /**
     * Compare two version instances such that they compare as equal whenever $right is compatible with $left.
     *
     * @param Version $left
     * @param Version $right
     *
     * @return integer A number less than zero if $left is less than $right, greater than zero if $right is less $left, or zero if they are equivalent.
     */
    public function compare(Version $left, Version $right)
    {
        $this->typeCheck->compare(func_get_args());

        $result = parent::compare($left, $right);
        if ($result <= 0 && $left->major() === $right->major()) {
            return 0;
        }

        return $result;
    }

    private $typeCheck;
}
