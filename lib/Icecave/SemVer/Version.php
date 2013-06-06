<?php
namespace Icecave\SemVer;

use InvalidArgumentException;
use Icecave\SemVer\TypeCheck\TypeCheck;

/**
 * Represents a Semantic Version number as per http://semver.org/ @ 2.0.0-rc.2
 */
class Version
{
    /**
     * @param integer     $major             The major version number.
     * @param integer     $minor             The minor version number.
     * @param integer     $patch             The patch version number.
     * @param string|null $preReleaseVersion The pre-release version, not including the leading hyphen.
     * @param string|null $buildMetaData     The build meta-data, not including the leading plus-sign.
     */
    public function __construct($major = 0, $minor = 0, $patch = 0, $preReleaseVersion = null, $buildMetaData = null)
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        $this->setMajor($major);
        $this->setMinor($minor);
        $this->setPatch($patch);
        $this->setPreReleaseVersion($preReleaseVersion);
        $this->setBuildMetaData($buildMetaData);
    }

    /**
     * Create a Version instance from a string.
     *
     * @param string $version The string to parse.
     *
     * @return Version                  The resulting Version instance.
     * @throws InvalidArgumentException if the version string is not a valid semantic version number.
     */
    public static function parse($version)
    {
        TypeCheck::get(__CLASS__)->parse(func_get_args());

        $parsedVersion = null;
        if (static::tryParse($version, $parsedVersion)) {
            return $parsedVersion;
        }

        throw new InvalidArgumentException('The string "' . $version . '" does not describe a valid semantic version.');
    }

    /**
     * Create a Version instance from a string, if possible.
     *
     * @param string       $version        The string to parse.
     * @param Version|null &$parsedVersion The resulting Version instance.
     *
     * @return boolean True if the version string was parsed successfully; otherwise, false.
     */
    public static function tryParse($version, Version &$parsedVersion = null)
    {
        TypeCheck::get(__CLASS__)->tryParse(func_get_args());

        $matches = array();
        if (!preg_match(static::$versionPattern, $version, $matches)) {
            return false;
        }

        if (array_key_exists('preReleaseVersion', $matches) && $matches['preReleaseVersion'] !== '') {
            $preReleaseVersion = $matches['preReleaseVersion'];
        } else {
            $preReleaseVersion = null;
        }

        if (array_key_exists('buildMetaData', $matches) && $matches['buildMetaData'] !== '') {
            $buildMetaData = $matches['buildMetaData'];
        } else {
            $buildMetaData = null;
        }

        $parsedVersion = new static(
            intval($matches['major']),
            intval($matches['minor']),
            intval($matches['patch']),
            $preReleaseVersion,
            $buildMetaData
        );

        return true;
    }

    /**
     * Check if a version string represents a valid semantic version.
     *
     * @param string $version The version string to check.
     *
     * @return boolean True if the version string was parsed successfully; otherwise, false.
     */
    public static function isValid($version)
    {
        TypeCheck::get(__CLASS__)->isValid(func_get_args());

        return preg_match(static::$versionPattern, $version) === 1;
    }

    /**
     * Adapt a value to a Version instance.
     *
     * If $version is an instance of Version it is return unchanged, otherwise an attempt is made to parse $version as a string.
     *
     * @param Version|string $version A Version instance, or semantic version number string to parse.
     *
     * @return Version                  The resulting Version instance.
     * @throws InvalidArgumentException if the $version is a string and is not a valid semantic version number.
     */
    public static function adapt($version)
    {
        TypeCheck::get(__CLASS__)->adapt(func_get_args());

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
        $this->typeCheck->major(func_get_args());

        return $this->major;
    }

    /**
     * Set the major version.
     *
     * @param integer $major The major version number.
     */
    public function setMajor($major)
    {
        $this->typeCheck->setMajor(func_get_args());

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
        $this->typeCheck->minor(func_get_args());

        return $this->minor;
    }

    /**
     * Set the minor version.
     *
     * @param integer $minor The minor version number.
     */
    public function setMinor($minor)
    {
        $this->typeCheck->setMinor(func_get_args());

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
        $this->typeCheck->patch(func_get_args());

        return $this->patch;
    }

    /**
     * Set the patch version.
     *
     * @param integer $patch The patch version number.
     */
    public function setPatch($patch)
    {
        $this->typeCheck->setPatch(func_get_args());

        if ($patch < 0) {
            throw new InvalidArgumentException('Major version number must be a positive integer.');
        }

        $this->patch = $patch;
    }

    /**
     * @return string|null The pre-release version.
     */
    public function preReleaseVersion()
    {
        $this->typeCheck->preReleaseVersion(func_get_args());

        return $this->preReleaseVersion;
    }

    /**
     * @return array An array containing the dot-separated components of the pre-release version.
     */
    public function preReleaseVersionParts()
    {
        $this->typeCheck->preReleaseVersionParts(func_get_args());

        if (null === $this->preReleaseVersion) {
            return array();
        }

        return explode('.', $this->preReleaseVersion);
    }

    /**
     * Set the pre-release version.
     *
     * @param string|null $preReleaseVersion The pre-release version, not including the leading hyphen.
     */
    public function setPreReleaseVersion($preReleaseVersion)
    {
        $this->typeCheck->setPreReleaseVersion(func_get_args());

        if (null !== $preReleaseVersion && !preg_match(static::$identifierPattern, $preReleaseVersion)) {
            throw new InvalidArgumentException('The string "' . $preReleaseVersion . '" is not a valid pre-release version.');
        }

        $this->preReleaseVersion = $preReleaseVersion;
    }

    /**
     * @return string|null The build meta-data.
     */
    public function buildMetaData()
    {
        $this->typeCheck->buildMetaData(func_get_args());

        return $this->buildMetaData;
    }

    /**
     * @return array An array containing the dot-separated components of the build meta-data.
     */
    public function buildMetaDataParts()
    {
        $this->typeCheck->buildMetaDataParts(func_get_args());

        if (null === $this->buildMetaData) {
            return array();
        }

        return explode('.', $this->buildMetaData);
    }

    /**
     * Set the build meta-data.
     *
     * @param string|null $buildMetaData The build meta-data, not including the leading plus-sign.
     */
    public function setBuildMetaData($buildMetaData)
    {
        $this->typeCheck->setBuildMetaData(func_get_args());

        if (null !== $buildMetaData && !preg_match(static::$identifierPattern, $buildMetaData)) {
            throw new InvalidArgumentException('The string "' . $buildMetaData . '" is not a valid build meta-data.');
        }

        $this->buildMetaData = $buildMetaData;
    }

    /**
     * @return boolean Indicates whether or not this version represents a stable release.
     */
    public function isStable()
    {
        $this->typeCheck->isStable(func_get_args());

        return $this->major() > 0
            && null === $this->preReleaseVersion();
    }

    /**
     * @return string The string representation of this version.
     */
    public function string()
    {
        $this->typeCheck->string(func_get_args());

        if (null !== $this->preReleaseVersion) {
            $preReleaseVersionString = '-' . $this->preReleaseVersion;
        } else {
            $preReleaseVersionString = '';
        }

        if (null !== $this->buildMetaData) {
            $buildMetaDataString = '+' . $this->buildMetaData;
        } else {
            $buildMetaDataString = '';
        }

        return sprintf(
            '%d.%d.%d%s%s',
            $this->major(),
            $this->minor(),
            $this->patch(),
            $preReleaseVersionString,
            $buildMetaDataString
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
    private static $versionPattern = '/^(?P<major>[0-9]+)\.(?P<minor>[0-9]+)\.(?P<patch>[0-9]+)(?:-(?P<preReleaseVersion>[0-9a-z-]+(?:\.[0-9a-z-]+)*))?(?:\+(?P<buildMetaData>[0-9a-z-]+(?:\.[0-9a-z-]+)*))?$/i';
    private $typeCheck;
    private $major;
    private $minor;
    private $patch;
    private $preReleaseVersion;
    private $buildMetaData;
}
