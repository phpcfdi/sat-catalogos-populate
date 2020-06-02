# phpcfdi/sat-catalogos-populate

[![Source Code][badge-source]][source]
[![Latest Version][badge-release]][release]
[![Software License][badge-license]][license]
[![Build Status][badge-build]][build]
[![Scrutinizer][badge-quality]][quality]
[![Coverage Status][badge-coverage]][coverage]
[![Total Downloads][badge-downloads]][downloads]

> Herramienta para crear y actualizar los catálogos de SAT/CFDI en una base de datos SQLite3

Use this project to produce the SQLite database for [`phpcfdi/sat-catalogos`](https://github.com/phpcfdi/sat-catalogos)
but this database can also be used in any other project.

## Installation

Install it by `git clone https://github.com/phpcfdi/sat-catalogos-populate.git` or download zip file.
You can use `composer` by adding this to your `composer.json` and run `composer install`. It is not on packagist. 

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/phpcfdi/sat-catalogos-populate"
        }
    ],
    "require": {
        "phpcfdi/sat-catalogos-populate": "dev-master"
    }
}
```

It also requires external software:

```shell script
apt-get install libreoffice-calc xlsx2csv
```

## Basic usage

```shell script
mkdir -p catalogs
php bin/sat-catalogos-update dump-origins > catalogs/origins.xml
php bin/sat-catalogos-update update-origins catalogs/origins.xml
php bin/sat-catalogos-update update-database catalogs/ catalogs/catalogos.sqlite3
```

## PHP Support

This tool is compatible with last [PHP supported version](https://www.php.net/supported-versions.php).
Please, try to use the full potential of the language.

## Contributing

Contributions are welcome! Please read [CONTRIBUTING][] for details
and don't forget to take a look in the [TODO][] and [CHANGELOG][] files.

## Copyright and License

The `phpcfdi/sat-catalogos-populate` project is copyright © [PhpCfdi](https://www.phpcfdi.com/)
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
[downloads]: https://github.com/phpcfdi/sat-catalogos-populate

[badge-source]: https://img.shields.io/badge/source-phpcfdi/sat--catalogos--populate-blue?style=flat-square
[badge-release]: https://img.shields.io/github/release/phpcfdi/sat-catalogos-populate?style=flat-square
[badge-license]: https://img.shields.io/github/license/phpcfdi/sat-catalogos-populate?style=flat-square
[badge-build]: https://img.shields.io/travis/phpcfdi/sat-catalogos-populate/master?style=flat-square
[badge-quality]: https://img.shields.io/scrutinizer/g/phpcfdi/sat-catalogos-populate/master?style=flat-square
[badge-coverage]: https://img.shields.io/scrutinizer/coverage/g/phpcfdi/sat-catalogos-populate/master?style=flat-square
[badge-downloads]: https://img.shields.io/github/downloads/phpcfdi/sat-catalogos-populate/total?style=flat-square
