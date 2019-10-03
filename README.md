# phpcfdi/sat-catalogos-populate

[![Source Code][badge-source]][source]
[![Latest Version][badge-release]][release]
[![Software License][badge-license]][license]
[![Build Status][badge-build]][build]
[![Scrutinizer][badge-quality]][quality]
[![Coverage Status][badge-coverage]][coverage]
[![Total Downloads][badge-downloads]][downloads]

> Generación del contenido de la base de datos del proyecto PhpCfdi\SatCatalogos

## Installation

Use [composer](https://getcomposer.org/), so please run
```shell
composer require phpcfdi/sat-catalogos-populate
```

It also require external software
```shell
apt-get install libreoffice-calc xlsx2csv 
```

## Basic usage

```php
rm -rf build/files
mkdir -p build/files
php bin/sat-catalogos-update dump-origins > build/files/origins.xml
php bin/sat-catalogos-update update-origins build/files/origins.xml
php bin/sat-catalogos-update update-database build/files/ build/files/catalogos.sqlite3
```


## PHP Support

This library is compatible with PHP versions 7.2 and above.
Please, try to use the full potential of the language.


## Contributing

Contributions are welcome! Please read [CONTRIBUTING][] for details
and don't forget to take a look in the [TODO][] and [CHANGELOG][] files.


## Copyright and License

The phpcfdi/sat-catalogos-populate library is copyright © [Carlos C Soto](http://eclipxe.com.mx/)
and licensed for use under the MIT License (MIT). Please see [LICENSE][] for more information.


[contributing]: https://github.com/phpcfdi/sat-catalogos-populate/blob/master/CONTRIBUTING.md
[changelog]: https://github.com/phpcfdi/sat-catalogos-populate/blob/master/docs/CHANGELOG.md
[todo]: https://github.com/phpcfdi/sat-catalogos-populate/blob/master/docs/TODO.md

[source]: https://github.com/phpcfdi/sat-catalogos-populate
[release]: https://github.com/phpcfdi/sat-catalogos-populate/releases
[license]: https://github.com/phpcfdi/sat-catalogos-populate/blob/master/LICENSE
[build]: https://travis-ci.org/phpcfdi/sat-catalogos-populate?branch=master
[quality]: https://scrutinizer-ci.com/g/phpcfdi/sat-catalogos-populate/
[coverage]: https://scrutinizer-ci.com/g/phpcfdi/sat-catalogos-populate/code-structure/master/code-coverage/src
[downloads]: https://packagist.org/packages/phpcfdi/sat-catalogos-populate

[badge-source]: http://img.shields.io/badge/source-phpcfdi/sat--catalogos--populate-blue?style=flat-square
[badge-release]: https://img.shields.io/github/release/phpcfdi/sat-catalogos-populate?style=flat-square
[badge-license]: https://img.shields.io/github/license/phpcfdi/sat-catalogos-populate?style=flat-square
[badge-build]: https://img.shields.io/travis/phpcfdi/sat-catalogos-populate/master?style=flat-square
[badge-quality]: https://img.shields.io/scrutinizer/g/phpcfdi/sat-catalogos-populate/master?style=flat-square
[badge-coverage]: https://img.shields.io/scrutinizer/coverage/g/phpcfdi/sat-catalogos-populate/master?style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/phpcfdi/sat-catalogos-populate?style=flat-square
