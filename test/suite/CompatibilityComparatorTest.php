<?php
namespace Icecave\SemVer;

use PHPUnit_Framework_TestCase;

class CompatibilityComparatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->comparator = new CompatibilityComparator();
    }

    /**
     * @dataProvider comparisonTestVectors
     */
    public function testCompareEquality($left, $right)
    {
        $left  = Version::parse($left);
        $right = Version::parse($right);

        $this->assertSame(
            0,
            $this->comparator->compare($left, $left)
        );

        $this->assertSame(
            0,
            $this->comparator->compare($right, $right)
        );
    }

    /**
     * @dataProvider comparisonTestVectors
     */
    public function testCompare($left, $right, $isCompatible)
    {
        $left  = Version::parse($left);
        $right = Version::parse($right);

        if ($isCompatible) {
            $this->assertSame(
                0,
                $this->comparator->compare($left, $right)
            );
        } else {
            $this->assertLessThan(
                0,
                $this->comparator->compare($left, $right)
            );
        }
    }

    /**
     * @dataProvider comparisonTestVectors
     */
    public function testCompareInverse($left, $right, $isCompatible)
    {
        $left  = Version::parse($left);
        $right = Version::parse($right);

        $this->assertGreaterThan(
            0,
            $this->comparator->compare($right, $left)
        );
    }

    /**
     * Test vectors.
     *
     * For each pair the left hand side should be less than the right.
     */
    public function comparisonTestVectors()
    {
        return array(
            'major version comparison'              => array('1.0.0', '2.0.0',     false),
            'major version comparison, pre-release' => array('1.0.0', '2.0.0-foo', false),
            'minor version comparison'              => array('1.1.0', '1.2.0',     true),
            'patch version comparison'              => array('1.1.1', '1.1.2',     true),
            'zero major version comparison'         => array('0.1.0', '0.2.0',     false), // never compatible unless equal
        );
    }
}
