<?php
namespace Icecave\SemVer;

use InvalidArgumentException;
use Typhoon\Typhoon;

/**
 * Represents a Semantic Version number as per http://semver.org/ @ 2.0.0-rc.1
 */
class Version
{
    /**
     * @param integer $major The major version number.
     * @param integer $minor The minor version number.
     * @param integer $patch The patch version number.
     * @param string|null $preReleaseIdentifier The pre-release identifier, not including the leading hyphen.
     * @param string|null $buildIdentifier The build identifier, not including the leading plus-sign.
     */
    public function __construct($major = 0, $minor = 0, $patch = 0, $preReleaseIdentifier = null, $buildIdentifier = null)
    {
        $this->typhoon = Typhoon::get(__CLASS__, func_get_args());

        $this->setMajor($major);
        $this->setMinor($minor);
        $this->setPatch($patch);
        $this->setPreReleaseIdentifier($preReleaseIdentifier);
        $this->setBuildIdentifier($buildIdentifier);
    }

    /**
     * Create a Version instance from a string.
     *
     * @param string $version The string to parse.
     *
     * @return Version The resulting Version instance.
     * @throws InvalidArgumentException if the version string is not a valid semantic version number.
     */
    public static function parse($version)
    {
        Typhoon::get(__CLASS__)->parse(func_get_args());

        $matches = array();
        if (!preg_match(static::$versionPattern, $version, $matches)) {
            throw new InvalidArgumentException('The string "' . $version . '" does not describe a valid semantic version.');
        }

        if (array_key_exists('preReleaseIdentifier', $matches) && $matches['preReleaseIdentifier'] !== '') {
            $preReleaseIdentifier = $matches['preReleaseIdentifier'];
        } else {
            $preReleaseIdentifier = null;
        }

        if (array_key_exists('buildIdentifier', $matches) && $matches['buildIdentifier'] !== '') {
            $buildIdentifier = $matches['buildIdentifier'];
        } else {
            $buildIdentifier = null;
        }

        return new static(
            intval($matches['major']),
            intval($matches['minor']),
            intval($matches['patch']),
            $preReleaseIdentifier,
            $buildIdentifier
        );
    }

    /**
     * Adapt a value to a Version instance.
     *
     * If $version is an instance of Version it is return unchanged, otherwise an attempt is made to parse $version as a string.
     *
     * @param Version|string $version A Version instance, or semantic version number string to parse.
     *
     * @return Version The resulting Version instance.
     * @throws InvalidArgumentException if the $version is a string and is not a valid semantic version number.
     */
    public static function adapt($version)
    {
        if ($version instanceof static) {
            return $version;
        }
        return static::parse($version);
    }

    /**
     * @return integer The major version number.
     */
    public function major()
    {
        return $this->major;
    }

    /**
     * Set the major version.
     *
     * @param integer $major The major version number.
     */
    public function setMajor($major)
    {
        $this->typhoon->setMajor(func_get_args());

        if ($major < 0) {
            throw new InvalidArgumentException('Major version number must be a positive integer.');
        }

        $this->major = $major;
    }

    /**
     * @return integer The minor version number.
     */
    public function minor()
    {
        return $this->minor;
    }

    /**
     * Set the minor version.
     *
     * @param integer $minor The minor version number.
     */
    public function setMinor($minor)
    {
        $this->typhoon->setMinor(func_get_args());

        if ($minor < 0) {
            throw new InvalidArgumentException('Major version number must be a positive integer.');
        }

        $this->minor = $minor;
    }

    /**
     * @return integer The patch version number.
     */
    public function patch()
    {
        return $this->patch;
    }

    /**
     * Set the patch version.
     *
     * @param integer $patch The patch version number.
     */
    public function setPatch($patch)
    {
        $this->typhoon->setPatch(func_get_args());

        if ($patch < 0) {
            throw new InvalidArgumentException('Major version number must be a positive integer.');
        }

        $this->patch = $patch;
    }

    /**
     * @return string|null The pre-release identifier.
     */
    public function preReleaseIdentifier()
    {
        return $this->preReleaseIdentifier;
    }

    /**
     * Set the pre-release identifier.
     *
     * @param string|null $preReleaseIdentifier The pre-release identifier, not including the leading hyphen.
     */
    public function setPreReleaseIdentifier($preReleaseIdentifier)
    {
        $this->typhoon->setPreReleaseIdentifier(func_get_args());

        if (null !== $preReleaseIdentifier && !preg_match(static::$identifierPattern, $preReleaseIdentifier)) {
            throw new InvalidArgumentException('The string "' . $preReleaseIdentifier . '" is not a valid pre-release identifier.');
        }

        $this->preReleaseIdentifier = $preReleaseIdentifier;
    }

    /**
     * @return string|null The build identifier.
     */
    public function buildIdentifier()
    {
        return $this->buildIdentifier;
    }

    /**
     * Set the build identifier.
     *
     * @param string|null $buildIdentifier The build identifier, not including the leading plus-sign.
     */
    public function setBuildIdentifier($buildIdentifier)
    {
        $this->typhoon->setBuildIdentifier(func_get_args());

        if (null !== $buildIdentifier && !preg_match(static::$identifierPattern, $buildIdentifier)) {
            throw new InvalidArgumentException('The string "' . $buildIdentifier . '" is not a valid build identifier.');
        }

        $this->buildIdentifier = $buildIdentifier;
    }

    /**
     * @return boolean Indicates whether or not this version represents a stable release.
     */
    public function isStable()
    {
        return $this->major() > 0
            && null === $this->preReleaseIdentifier();
    }

    /**
     * @return string The string representation of this version.
     */
    public function string()
    {
        if (null !== $this->preReleaseIdentifier) {
            $preReleaseIdentifierString = '-' . $this->preReleaseIdentifier;
        } else {
            $preReleaseIdentifierString = '';
        }

        if (null !== $this->buildIdentifier) {
            $buildIdentifierString = '+' . $this->buildIdentifier;
        } else {
            $buildIdentifierString = '';
        }

        return sprintf(
            '%d.%d.%d%s%s',
            $this->major(),
            $this->minor(),
            $this->patch(),
            $preReleaseIdentifierString,
            $buildIdentifierString
        );
    }

    /**
     * @return string The string representation of this version.
     */
    public function __toString()
    {
        return $this->string();
    }

    private static $identifierPattern = '/^[0-9a-z-]+(\.[0-9a-z-]+)*$/i';
    private static $versionPattern = '/^(?P<major>[0-9]+)\.(?P<minor>[0-9]+)\.(?P<patch>[0-9]+)(?:-(?P<preReleaseIdentifier>[0-9a-z-]+(?:\.[0-9a-z-]+)*))?(?:\+(?P<buildIdentifier>[0-9a-z-]+(?:\.[0-9a-z-]+)*))?$/i';
    private $typhoon;
    private $major;
    private $minor;
    private $patch;
    private $preReleaseIdentifier;
    private $buildIdentifier;
}
