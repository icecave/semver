<?php
namespace Icecave\SemVer;

use PHPUnit_Framework_TestCase;

class VersionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_version = new Version(1, 2, 3, 'preReleaseVersion', 'buildMetaData');
    }

    public function testDefaults()
    {
        $version = new Version;
        $this->assertSame(0, $version->major());
        $this->assertSame(0, $version->minor());
        $this->assertSame(0, $version->patch());
        $this->assertNull($version->preReleaseVersion());
        $this->assertNull($version->buildMetaData());
    }

    public function testMajor()
    {
        $this->assertSame(1, $this->_version->major());
    }

    public function testSetMajor()
    {
        $this->_version->setMajor(100);
        $this->assertSame(100, $this->_version->major());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetMajorFailure()
    {
        $this->_version->setMajor(-1);
    }

    public function testMinor()
    {
        $this->assertSame(2, $this->_version->minor());
    }

    public function testSetMinor()
    {
        $this->_version->setMinor(100);
        $this->assertSame(100, $this->_version->minor());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetMinorFailure()
    {
        $this->_version->setMinor(-1);
    }

    public function testPatch()
    {
        $this->assertSame(3, $this->_version->patch());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetPatchFailure()
    {
        $this->_version->setPatch(-1);
    }

    public function testSetPatch()
    {
        $this->_version->setPatch(100);
        $this->assertSame(100, $this->_version->patch());
    }

    public function testPreReleaseVersion()
    {
        $this->assertSame('preReleaseVersion', $this->_version->preReleaseVersion());
    }

    public function testSetPreReleaseVersion()
    {
        $this->_version->setPreReleaseVersion('foo');
        $this->assertSame('foo', $this->_version->preReleaseVersion());
    }

    public function testPreReleaseVersionParts()
    {
        $this->_version->setPreReleaseVersion(null);
        $this->assertSame(array(), $this->_version->preReleaseVersionParts());

        $this->_version->setPreReleaseVersion('foo');
        $this->assertSame(array('foo'), $this->_version->preReleaseVersionParts());

        $this->_version->setPreReleaseVersion('foo.bar');
        $this->assertSame(array('foo', 'bar'), $this->_version->preReleaseVersionParts());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetPreReleaseVersionFailure()
    {
        $this->_version->setPreReleaseVersion('foo_bar');
    }

    public function testBuildMetaData()
    {
        $this->assertSame('buildMetaData', $this->_version->buildMetaData());
    }

    public function testBuildMetaDataParts()
    {
        $this->_version->setBuildMetaData(null);
        $this->assertSame(array(), $this->_version->buildMetaDataParts());

        $this->_version->setBuildMetaData('foo');
        $this->assertSame(array('foo'), $this->_version->buildMetaDataParts());

        $this->_version->setBuildMetaData('foo.bar');
        $this->assertSame(array('foo', 'bar'), $this->_version->buildMetaDataParts());
    }

    public function testSetBuildMetaData()
    {
        $this->_version->setBuildMetaData('foo');
        $this->assertSame('foo', $this->_version->buildMetaData());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetBuildMetaDataFailure()
    {
        $this->_version->setBuildMetaData('foo_bar');
    }

    public function testString()
    {
        $this->assertSame('1.2.3-preReleaseVersion+buildMetaData', $this->_version->string());
        $this->assertSame('1.2.3-preReleaseVersion+buildMetaData', strval($this->_version));
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
        $result = Version::tryParse($string, $version);
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
        $this->assertSame($this->_version, Version::adapt($this->_version));
    }

    public function validVersionStrings()
    {
        return array(
            'numeric unstable'                  => array('0.0.0', false),
            'numeric'                           => array('1.2.3', true),
            'with pre-release'                  => array('1.2.3-preRelease', false),
            'with pre-release, all chars'       => array('1.2.3-abcdefghijklmnopqrstuvwxyz.ABCDEFGHIJKLMNOPQRSTUVWXYZ.0123456789', false),
            'with build'                        => array('1.2.3+build', true),
            'with build, all chars'             => array('1.2.3+abcdefghijklmnopqrstuvwxyz.ABCDEFGHIJKLMNOPQRSTUVWXYZ.0123456789', true),
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
        $result = Version::parse($string, $version);

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
            'invalid build'                     => array('1.2.3+foo_bar'),
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
