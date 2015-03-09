<?php
namespace Icecave\SemVer;

use Icecave\Parity\AbstractExtendedComparable;
use Icecave\Parity\Exception\NotComparableException;
use Icecave\Parity\SubClassComparableInterface;
use InvalidArgumentException;

/**
 * Represents a Semantic Version number, as described by v2.0.0 of the Semantic Versioning specification.
 *
 * @link http://semver.org/
 */
class Version extends AbstractExtendedComparable implements SubClassComparableInterface
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
        if ($version instanceof static) {
            return $version;
        }

        return static::parse($version);
    }

    /**
     * Get the major version.
     *
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
        if (!is_integer($major) || $major < 0) {
            throw new InvalidArgumentException('Major version number must be a positive integer.');
        }

        $this->major = $major;
    }

    /**
     * Get the minor version.
     *
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
        if (!is_integer($minor) || $minor < 0) {
            throw new InvalidArgumentException('Major version number must be a positive integer.');
        }

        $this->minor = $minor;
    }

    /**
     * Get the patch version.
     *
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
        if (!is_integer($patch) || $patch < 0) {
            throw new InvalidArgumentException('Major version number must be a positive integer.');
        }

        $this->patch = $patch;
    }

    /**
     * Get the pre-release portion of the version.
     *
     * @return string|null The pre-release version.
     */
    public function preReleaseVersion()
    {
        return $this->preReleaseVersion;
    }

    /**
     * Get the components of the pre-release version.
     *
     * @return array An array containing the dot-separated components of the pre-release version.
     */
    public function preReleaseVersionParts()
    {
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
        if (null !== $preReleaseVersion && !preg_match(static::$preReleaseVersionPattern, $preReleaseVersion)) {
            throw new InvalidArgumentException('The string "' . $preReleaseVersion . '" is not a valid pre-release version.');
        }

        $this->preReleaseVersion = $preReleaseVersion;
    }

    /**
     * Get the build meta-data portion of the version.
     *
     * @return string|null The build meta-data.
     */
    public function buildMetaData()
    {
        return $this->buildMetaData;
    }

    /**
     * Get the components of the build meta-data portion.
     *
     * @return array An array containing the dot-separated components of the build meta-data.
     */
    public function buildMetaDataParts()
    {
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
        if (null !== $buildMetaData && !preg_match(static::$buildMetaDataPattern, $buildMetaData)) {
            throw new InvalidArgumentException('The string "' . $buildMetaData . '" is not a valid build meta-data.');
        }

        $this->buildMetaData = $buildMetaData;
    }

    /**
     * Check if this version is stable.
     *
     * @return boolean Indicates whether or not this version represents a stable release.
     */
    public function isStable()
    {
        return $this->major() > 0
            && null === $this->preReleaseVersion();
    }

    /**
     * Get the string representation of this version.
     *
     * @return string The string representation of this version.
     */
    public function string()
    {
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
     * Get the string representation of this version.
     *
     * @return string The string representation of this version.
     */
    public function __toString()
    {
        return $this->string();
    }

    /**
     * Compare this object with another value, yielding a result according to the following table:
     *
     * +--------------------+---------------+
     * | Condition          | Result        |
     * +--------------------+---------------+
     * | $this == $value    | $result === 0 |
     * | $this < $value     | $result < 0   |
     * | $this > $value     | $result > 0   |
     * +--------------------+---------------+
     *
     * By default, a {@see Comparator} instance is used for comparison, meaning that versions are compared according to
     * their PRECEDENCE, as defined by the Semantic Versioning specification.
     *
     * @param mixed           $value            The value to compare.
     * @param Comparator|null $semverComparator The semantic version comparator to use for comparison, or null to use the default.
     *
     * @return integer                          The result of the comparison.
     * @throws Exception\NotComparableException Indicates that the implementation does not know how to compare $this to $value.
     */
    public function compare($value, Comparator $semverComparator = null)
    {
        if (!$value instanceof self) {
            throw new NotComparableException($this, $value);
        }

        if (null === $semverComparator) {
            if (null === self::$defaultComparator) {
                self::$defaultComparator = new Comparator();
            }
            $semverComparator = self::$defaultComparator;
        }

        return $semverComparator->compare($this, $value);
    }

    private static $defaultComparator;
    private static $preReleaseVersionPattern = '/^([1-9][0-9]*|[0-9a-z-]*[a-z-][0-9a-z-]*)(\.([1-9][0-9]*|[0-9a-z-]*[a-z-][0-9a-z-]*))*$/i';
    private static $buildMetaDataPattern     = '/^[0-9a-z-]+(\.[0-9a-z-]+)*$/i';
    private static $versionPattern           = '/^(?P<major>[0-9]+)\.(?P<minor>[0-9]+)\.(?P<patch>[0-9]+)(?:-(?P<preReleaseVersion>(?:[1-9][0-9]*|[0-9a-z-]*[a-z-][0-9a-z-]*)(?:\.(?:[1-9][0-9]*|[0-9a-z-]*[a-z-][0-9a-z-]*)+)*))?(?:\+(?P<buildMetaData>[0-9a-z-]+(?:\.[0-9a-z-]+)*))?$/i';
    private $major;
    private $minor;
    private $patch;
    private $preReleaseVersion;
    private $buildMetaData;
}
