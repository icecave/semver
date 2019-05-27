# SemVer

> **This project has been deprecated by the authors. Use [composer/semver](https://github.com/composer/semver) instead.**

**SemVer** is a PHP library for parsing and comparing version numbers according to the [Semantic Versioning standard](http://semver.org).
The current version behaves according to version 2.0.0 of the specification.

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
assert($comparator->compare($version1, $version2) < 0);
```
