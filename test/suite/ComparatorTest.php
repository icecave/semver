<?php
namespace Icecave\SemVer;

use PHPUnit_Framework_TestCase;

class ComparatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->comparator = new Comparator();
    }

    /**
     * @dataProvider comparisonTestVectors
     */
    public function testCompareEquality($left, $right)
    {
        $left  = Version::parse($left);
        $right = Version::parse($right);

        $this->assertSame(0, $this->comparator->compare($left, $left));
        $this->assertSame(0, $this->comparator->compare($right, $right));
    }

    /**
     * @dataProvider comparisonTestVectors
     */
    public function testCompare($left, $right)
    {
        $left  = Version::parse($left);
        $right = Version::parse($right);
        $this->assertLessThan(0, $this->comparator->compare($left, $right));
    }

    /**
     * @dataProvider comparisonTestVectors
     */
    public function testCompareInverse($left, $right)
    {
        $left  = Version::parse($left);
        $right = Version::parse($right);
        $this->assertGreaterThan(0, $this->comparator->compare($right, $left));
    }

    /**
     * Test vectors.
     *
     * For each pair the left hand side should be less than the right.
     */
    public function comparisonTestVectors()
    {
        return array(
            'major version comparison'       => array('1.0.0', '2.0.0'),
            'minor version comparison'       => array('1.1.0', '1.2.0'),
            'patch version comparison'       => array('1.1.1', '1.1.2'),
            'numeric always less than text'  => array('0.0.0-100', '0.0.0-0x'),
            'pre-release version field size' => array('0.0.0-x', '0.0.0-x.x'),
        );
    }

    /**
     * @dataProvider semverTestVectors
     */
    public function testSemverTestVectors($left, $right)
    {
        $left  = Version::parse($left);
        $right = Version::parse($right);
        $this->assertLessThan(0, $this->comparator->compare($left, $right));
    }

    /**
     * @dataProvider semverTestVectors
     */
    public function testSemverTestVectorsInverse($left, $right)
    {
        $left  = Version::parse($left);
        $right = Version::parse($right);
        $this->assertGreaterThan(0, $this->comparator->compare($right, $left));
    }

    /**
     * @dataProvider semverTestVectorsWithBuildMetaData
     */
    public function testSemverTestVectorsWithBuildMetaData($left, $right)
    {
        $left  = Version::parse($left);
        $right = Version::parse($right);
        $this->assertSame(0, $this->comparator->compare($left, $right));
    }

    /**
     * @dataProvider semverTestVectorsWithBuildMetaData
     */
    public function testSemverTestVectorsWithBuildDataInverse($left, $right)
    {
        $left  = Version::parse($left);
        $right = Version::parse($right);
        $this->assertSame(0, $this->comparator->compare($right, $left));
    }

    /**
     * Test vectors from semver.org.
     *
     * For each pair the left hand side should be less than the right.
     */
    public function semverTestVectors()
    {
        return array(
            array('1.0.0-alpha', '1.0.0-alpha.1'),
            array('1.0.0-alpha.1', '1.0.0-beta.2'),
            array('1.0.0-beta.2', '1.0.0-beta.11'),
            array('1.0.0-beta.11', '1.0.0-rc.1'),
            array('1.0.0-rc.1+build.1', '1.0.0'),
            array('1.0.0+0.3.7', '1.3.7+build'),
        );
    }

    public function semverTestVectorsWithBuildMetaData()
    {
        return array(
            array('1.0.0-rc.1', '1.0.0-rc.1+build.1'),
            array('1.0.0', '1.0.0+0.3.7'),
            array('1.3.7+build', '1.3.7+build.2.b8f12d7'),
            array('1.3.7+build.2.b8f12d7', '1.3.7+build.11.e0f985a'),
        );
    }
}
