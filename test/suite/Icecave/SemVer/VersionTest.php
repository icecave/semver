<?php
namespace Icecave\SemVer;

use PHPUnit_Framework_TestCase;

class VersionTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->_version = new Version(1, 2, 3, 'preReleaseIdentifier', 'buildIdentifier');
    }

    public function testDefaults()
    {
        $version = new Version;
        $this->assertSame(0, $version->major());
        $this->assertSame(0, $version->minor());
        $this->assertSame(0, $version->patch());
        $this->assertNull($version->preReleaseIdentifier());
        $this->assertNull($version->buildIdentifier());
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

    public function testPreReleaseIdentifier()
    {
        $this->assertSame('preReleaseIdentifier', $this->_version->preReleaseIdentifier());
    }

    public function testSetPreReleaseIdentifier()
    {
        $this->_version->setPreReleaseIdentifier('foo');
        $this->assertSame('foo', $this->_version->preReleaseIdentifier());
    }

    public function testPreReleaseIdentifierParts()
    {
        $this->_version->setPreReleaseIdentifier(null);
        $this->assertSame(array(), $this->_version->preReleaseIdentifierParts());

        $this->_version->setPreReleaseIdentifier('foo');
        $this->assertSame(array('foo'), $this->_version->preReleaseIdentifierParts());

        $this->_version->setPreReleaseIdentifier('foo.bar');
        $this->assertSame(array('foo', 'bar'), $this->_version->preReleaseIdentifierParts());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetPreReleaseIdentifierFailure()
    {
        $this->_version->setPreReleaseIdentifier('foo_bar');
    }

    public function testBuildIdentifier()
    {
        $this->assertSame('buildIdentifier', $this->_version->buildIdentifier());
    }

    public function testBuildIdentifierParts()
    {
        $this->_version->setBuildIdentifier(null);
        $this->assertSame(array(), $this->_version->buildIdentifierParts());

        $this->_version->setBuildIdentifier('foo');
        $this->assertSame(array('foo'), $this->_version->buildIdentifierParts());

        $this->_version->setBuildIdentifier('foo.bar');
        $this->assertSame(array('foo', 'bar'), $this->_version->buildIdentifierParts());
    }

    public function testSetBuildIdentifier()
    {
        $this->_version->setBuildIdentifier('foo');
        $this->assertSame('foo', $this->_version->buildIdentifier());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetBuildIdentifierFailure()
    {
        $this->_version->setBuildIdentifier('foo_bar');
    }

    public function testString()
    {
        $this->assertSame('1.2.3-preReleaseIdentifier+buildIdentifier', $this->_version->string());
        $this->assertSame('1.2.3-preReleaseIdentifier+buildIdentifier', strval($this->_version));
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
}
