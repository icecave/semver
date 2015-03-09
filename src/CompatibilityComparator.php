<?php
namespace Icecave\SemVer;

/**
 * Compares two version instances such that they compare as equal whenever $right is compatible with $left.
 */
class CompatibilityComparator extends Comparator
{
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
        $result = parent::compare($left, $right);

        if (
            $result <= 0
            && $left->major() !== 0
            && $left->major() === $right->major()
        ) {
            return 0;
        }

        return $result;
    }
}
