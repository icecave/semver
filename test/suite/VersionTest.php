<?php
namespace Icecave\SemVer;

use PHPUnit_Framework_TestCase;

class VersionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->version = new Version(1, 2, 3, 'preReleaseVersion', 'buildMetaData');
    }

    public function testDefaults()
    {
        $version = new Version();
        $this->assertSame(0, $version->major());
        $this->assertSame(0, $version->minor());
        $this->assertSame(0, $version->patch());
        $this->assertNull($version->preReleaseVersion());
        $this->assertNull($version->buildMetaData());
    }

    public function testMajor()
    {
        $this->assertSame(1, $this->version->major());
    }

    public function testSetMajor()
    {
        $this->version->setMajor(100);
        $this->assertSame(100, $this->version->major());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetMajorFailure()
    {
        $this->version->setMajor(-1);
    }

    public function testMinor()
    {
        $this->assertSame(2, $this->version->minor());
    }

    public function testSetMinor()
    {
        $this->version->setMinor(100);
        $this->assertSame(100, $this->version->minor());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetMinorFailure()
    {
        $this->version->setMinor(-1);
    }

    public function testPatch()
    {
        $this->assertSame(3, $this->version->patch());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetPatchFailure()
    {
        $this->version->setPatch(-1);
    }

    public function testSetPatch()
    {
        $this->version->setPatch(100);
        $this->assertSame(100, $this->version->patch());
    }

    public function testPreReleaseVersion()
    {
        $this->assertSame('preReleaseVersion', $this->version->preReleaseVersion());
    }

    public function testSetPreReleaseVersion()
    {
        $this->version->setPreReleaseVersion('foo');
        $this->assertSame('foo', $this->version->preReleaseVersion());
    }

    public function testPreReleaseVersionParts()
    {
        $this->version->setPreReleaseVersion(null);
        $this->assertSame(array(), $this->version->preReleaseVersionParts());

        $this->version->setPreReleaseVersion('foo');
        $this->assertSame(array('foo'), $this->version->preReleaseVersionParts());

        $this->version->setPreReleaseVersion('foo.bar');
        $this->assertSame(array('foo', 'bar'), $this->version->preReleaseVersionParts());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetPreReleaseVersionFailure()
    {
        $this->version->setPreReleaseVersion('foo_bar');
    }

    public function testBuildMetaData()
    {
        $this->assertSame('buildMetaData', $this->version->buildMetaData());
    }

    public function testBuildMetaDataParts()
    {
        $this->version->setBuildMetaData(null);
        $this->assertSame(array(), $this->version->buildMetaDataParts());

        $this->version->setBuildMetaData('foo');
        $this->assertSame(array('foo'), $this->version->buildMetaDataParts());

        $this->version->setBuildMetaData('foo.bar');
        $this->assertSame(array('foo', 'bar'), $this->version->buildMetaDataParts());
    }

    public function testSetBuildMetaData()
    {
        $this->version->setBuildMetaData('foo');
        $this->assertSame('foo', $this->version->buildMetaData());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetBuildMetaDataFailure()
    {
        $this->version->setBuildMetaData('foo_bar');
    }

    public function testString()
    {
        $this->assertSame('1.2.3-preReleaseVersion+buildMetaData', $this->version->string());
        $this->assertSame('1.2.3-preReleaseVersion+buildMetaData', strval($this->version));
    }

    /**
     * @dataProvider validVersionStrings
     */
    public function testIsStable($string, $isStable)
    {
        $version = Version::parse($string);
        $this->assertSame($isStable, $version->isStable());
    }

    /**
     * @dataProvider validVersionStrings
     */
    public function testParse($string)
    {
        $version = Version::parse($string);
        $this->assertInstanceOf(__NAMESPACE__ . '\Version', $version);
        $this->assertSame($string, $version->string());
    }

    /**
     * @dataProvider validVersionStrings
     */
    public function testAdaptWithValidStrings($string)
    {
        $version = Version::adapt($string);
        $this->assertInstanceOf(__NAMESPACE__ . '\Version', $version);
        $this->assertSame($string, $version->string());
    }

    /**
     * @dataProvider validVersionStrings
     */
    public function testTryParse($string)
    {
        $version = null;
        $result  = Version::tryParse($string, $version);
        $this->assertTrue($result);
        $this->assertInstanceOf(__NAMESPACE__ . '\Version', $version);
        $this->assertSame($string, $version->string());
    }

    /**
     * @dataProvider validVersionStrings
     */
    public function testIsValid($string)
    {
        $this->assertTrue(Version::isValid($string));
    }

    public function testAdapt()
    {
        $this->assertSame($this->version, Version::adapt($this->version));
    }

    public function validVersionStrings()
    {
        return array(
            'numeric unstable'                  => array('0.0.0', false),
            'numeric'                           => array('1.2.3', true),
            'with pre-release'                  => array('1.2.3-preRelease', false),
            'with pre-release, all chars'       => array('1.2.3-abcdefghijklmnopqrstuvwxyz.ABCDEFGHIJKLMNOPQRSTUVWXYZ.1234567890', false),
            'with build'                        => array('1.2.3+build', true),
            'with build, all chars'             => array('1.2.3+abcdefghijklmnopqrstuvwxyz.ABCDEFGHIJKLMNOPQRSTUVWXYZ.1234567890', true),
            'with build, leading zero'          => array('1.2.3+0123', true),
            'with pre-release + build'          => array('1.2.3-preRelease+build', false),
        );
    }

    /**
     * @dataProvider invalidVersionStrings
     * @expectedException InvalidArgumentException
     */
    public function testParseFailure($string)
    {
        Version::parse($string);
    }

    /**
     * @dataProvider invalidVersionStrings
     * @expectedException InvalidArgumentException
     */
    public function testTryParseFailure($string)
    {
        $version = null;
        $result  = Version::parse($string, $version);

        $this->assertFalse($result);
        $this->assertNull($version);
    }

    /**
     * @dataProvider invalidVersionStrings
     */
    public function testIsValidFailure($string)
    {
        $this->assertFalse(Version::isValid($string));
    }

    /**
     * @dataProvider invalidVersionStrings
     * @expectedException InvalidArgumentException
     */
    public function testAdaptFailure($string)
    {
        Version::adapt($string);
    }

    public function invalidVersionStrings()
    {
        return array(
            'single digit'                      => array('1'),
            'double digits'                     => array('1.2'),
            'extra digits'                      => array('1.2.3.4'),
            'invalid pre-release'               => array('1.2.3-foo_bar'),
            'invalid pre-release, leading zero' => array('1.2.3-0123'),
            'invalid pre-release, empty'        => array('1.2.3-'),
            'invalid pre-release, empty atom'   => array('1.2.3-foo..bar'),
            'invalid build'                     => array('1.2.3+foo_bar'),
            'invalid build, empty'              => array('1.2.3+'),
            'invalid build, empty atom'         => array('1.2.3+foo..bar'),
        );
    }

    public function testCompare()
    {
        $version1 = Version::parse('1.0.0');
        $version2 = Version::parse('2.0.0');

        $this->assertLessThan(0, $version1->compare($version2));
    }

    public function testCompareFailure()
    {
        $this->setExpectedException('Icecave\Parity\Exception\NotComparableException');
        Version::parse('1.0.0')->compare(123);
    }
}
