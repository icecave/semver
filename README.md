# SemVer

[![Build Status]](https://travis-ci.org/IcecaveStudios/semver)
[![Test Coverage]](https://coveralls.io/r/IcecaveStudios/semver?branch=develop)
[![SemVer]](http://semver.org)

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

## Contact us

* Follow [@IcecaveStudios](https://twitter.com/IcecaveStudios) on Twitter
* Visit the [Icecave Studios website](http://icecave.com.au)
* Join `#icecave` on [irc.freenode.net](http://webchat.freenode.net?channels=icecave)

<!-- references -->
[Build Status]: http://img.shields.io/travis/IcecaveStudios/semver/develop.svg?style=flat-square
[Test Coverage]: http://img.shields.io/coveralls/IcecaveStudios/semver/develop.svg?style=flat-square
[SemVer]: http://img.shields.io/:semver-3.0.3-brightgreen.svg?style=flat-square
