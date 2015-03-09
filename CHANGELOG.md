# SemVer Changelog

### 3.0.3 (2015-03-09)

* **[FIXED]** `CompatibilityComparator` no longer treats versions as compatible when major version is `0` unless they are identical

### 3.0.2 (2014-10-30)

* **[IMPROVED]** Updated to [Parity](https://github.com/IcecaveStudios/parity) version ~1

### 3.0.1 (2013-07-27)

* **[IMPROVED]** Updated to adhere to [Semantic Versioning 2.0.0 specification](http://semver.org/spec/v2.0.0.html)
* **[FIXED]** Pre-release and build meta-data identifies can no longer be empty
* **[FIXED]** Numeric pre-release identifiers can no longer have leading zeroes

### 3.0.0 (2013-06-07)

* **[NEW]** Updated to adhere to [Semantic Versioning 2.0.0-rc.2 specification](http://semver.org/spec/v2.0.0-rc.2.html)
* **[NEW]** `Version` now implements [Parity's](https://github.com/IcecaveStudios/parity) `ComparableInterface`

### 2.0.0 (2013-01-13)

* **[FIXED]** Renamed mispelled Comparator classes

### 1.0.0 (2012-10-03)

* Initial release
