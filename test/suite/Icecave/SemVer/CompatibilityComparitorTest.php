<?php
namespace Icecave\SemVer;

use PHPUnit_Framework_TestCase;

class CompatibilityComparitorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_comparitor = new CompatibilityComparitor;
    }

    // public function testCompareCompatible()
    // {
    //     $left = Version::parse('1.0.0');
    //     $right = Version::parse('1.9.9');
    // }

    /**
     * @dataProvider comparisonTestVectors
     */
    public function xtestCompareEquality($left, $right)
    {
        $left = Version::parse($left);
        $right = Version::parse($right);

        $this->assertSame(0, $this->_comparitor->compare($left, $left));
        $this->assertSame(0, $this->_comparitor->compare($right, $right));
    }

    /**
     * @dataProvider comparisonTestVectors
     */
    public function testCompare($left, $right, $isCompatible)
    {
        $left = Version::parse($left);
        $right = Version::parse($right);

        if ($isCompatible) {
            $this->assertSame(0, $this->_comparitor->compare($left, $right));
        } else {
            $this->assertLessThan(0, $this->_comparitor->compare($left, $right));
        }
    }

    /**
     * @dataProvider comparisonTestVectors
     */
    public function xtestCompareInverse($left, $right, $isCompatible)
    {
        $left = Version::parse($left);
        $right = Version::parse($right);
        $this->assertGreaterThan(0, $this->_comparitor->compare($right, $left));
    }

    /**
     * Test vectors.
     *
     * For each pair the left hand side should be less than the right.
     */
    public function comparisonTestVectors()
    {
        return array(
            'major version comparison'              => array('1.0.0', '2.0.0', false),
            'major version comparison, pre-release' => array('1.0.0', '2.0.0-foo', false),
            'minor version comparison'              => array('1.1.0', '1.2.0', true),
            'patch version comparison'              => array('1.1.1', '1.1.2', true),
        );
    }
}
