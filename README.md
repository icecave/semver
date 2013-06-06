# SemVer

[![Build Status]](http://travis-ci.org/IcecaveStudios/semver)
[![Test Coverage]](http://icecavestudios.github.io/semver/artifacts/tests/coverage)

**SemVer** is a PHP library for parsing and comparing version numbers according to the [Semantic Versioning standard](http://semver.org).
It currently behaves as per the 2.0.0-rc.2 specification.

* Install via [Composer](http://getcomposer.org) package [icecave/semver](https://packagist.org/packages/icecave/semver)
* Read the [API documentation](http://icecavestudios.github.io/semver/artifacts/documentation/api/)

## Example

```php
use Icecave\SemVer\Version;
use Icecave\SemVer\Comparator;

// Create versions from strings ...
$version1 = Version::parse('1.2.0-rc.1+build.meta.data');
$version2 = Version::parse('1.3.0');

// Compare the versions ...
$comparator = new Comparator;
assert($comparator->compare($version1, $version2 < 0);
```

<!-- references -->
[Build Status]: https://raw.github.com/IcecaveStudios/semver/gh-pages/artifacts/images/icecave/regular/build-status.png
[Test Coverage]: https://raw.github.com/IcecaveStudios/semver/gh-pages/artifacts/images/icecave/regular/coverage.png
