<?php
namespace Icecave\SemVer;

/**
 * Compares versions according to their precedence.
 */
class Comparator
{
    /**
     * Compare two versions according to their precedence.
     *
     * Versions with the same precedence are considered equal.
     *
     * Versions that differ only by their build meta-data have the same precedence.
     *
     * @param Version $left
     * @param Version $right
     *
     * @return integer A number less than zero if $left is less than $right, greater than zero if $right is less $left, or zero if they are equivalent.
     */
    public function compare(Version $left, Version $right)
    {
        // Compare the major version ...
        if ($diff = $left->major() - $right->major()) {
            return $diff;

        // Compare the minor version ...
        } elseif ($diff = $left->minor() - $right->minor()) {
            return $diff;

        // Compare the patch version ...
        } elseif ($diff = $left->patch() - $right->patch()) {
            return $diff;

        // Compare the pre-release version ...
        } elseif ($diff = $this->compareIdentifierParts($left->preReleaseVersionParts(), $right->preReleaseVersionParts())) {
            return $diff;

        // Do not compare the build meta-data ...
        } else {
            return 0;
        }
    }

    /**
     * Compare the dot-separted parts of a pre-release or build meta-data.
     *
     * @param array<string> $left
     * @param array<string> $right
     *
     * @return integer
     */
    protected function compareIdentifierParts(array $left, array $right)
    {
        $leftCount  = count($left);
        $rightCount = count($right);

        // If either of the sides is empty we can bail early ...
        if (0 === $leftCount || 0 === $rightCount) {
            return $rightCount - $leftCount;
        }

        // Compare the individual parts ...
        for ($index = 0; $index < $leftCount && $index < $rightCount; ++$index) {
            if ($diff = $this->compareIdentifierPart($left[$index], $right[$index])) {
                return $diff;
            }
        }

        // All parts compared equal, the version with the shorter identifier is considered less ...
        return $leftCount - $rightCount;
    }

    /**
     * Compare one component of a pre-release or build meta-data string.
     *
     * @param string $left
     * @param string $right
     *
     * @return integer
     */
    protected function compareIdentifierPart($left, $right)
    {
        $leftDigits  = ctype_digit($left);
        $rightDigits = ctype_digit($right);

        // If both are digits compare as numbers ...
        if ($leftDigits && $rightDigits) {
            return intval($left) - intval($right);

        // Digits are always "less" than text ...
        } elseif ($leftDigits) {
            return -1;

        // Digits are always "less" than text ...
        } elseif ($rightDigits) {
            return +1;
        }

        // Compare both sides as strings ...
        return strcmp($left, $right);
    }
}
