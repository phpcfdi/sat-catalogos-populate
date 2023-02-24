# phpcfdi/sat-catalogos-populate

[![Source Code][badge-source]][source]
[![PHP Version][badge-php-version]][php-version]
[![Latest Version][badge-release]][release]
[![Software License][badge-license]][license]
[![Build Status][badge-build]][build]
[![Scrutinizer][badge-quality]][quality]
[![Coverage Status][badge-coverage]][coverage]

> Herramienta para crear y actualizar los catálogos de SAT/CFDI en una base de datos SQLite3

Use this project to produce the SQLite database for [`phpcfdi/sat-catalogos`](https://github.com/phpcfdi/sat-catalogos)
but this database can also be used in any other project.

## Install and use by docker image

This project provides a `Dockerfile` to build an image with the project and all its dependences. Use it to execute
the commands provided by this package, for more information check the [`README.Docker.md`](Docker.README.md) file.

```shell script
git clone https://github.com/phpcfdi/sat-catalogos-populate.git
docker build -t sat-catalogos-populate sat-catalogos-populate/
docker run -it --rm sat-catalogos-populate --help
```

## Installation on local system

This project is not a library, and it is not included on [Packagist](https://packagist.org/).
You cannot install it on your system using `composer`. 

Install it by cloning the project `https://github.com/phpcfdi/sat-catalogos-populate.git` or download zip file.

```shell script
git clone https://github.com/phpcfdi/sat-catalogos-populate.git
cd sat-catalogos-populate
composer install
```

Be aware it also requires external software to work:

```shell script
apt-get install libreoffice-calc xlsx2csv
```

## Basic usage

```shell script
mkdir catalogs
php bin/sat-catalogos-update dump-origins > catalogs/origins.xml
php bin/sat-catalogos-update update-origins catalogs/
php bin/sat-catalogos-update update-database catalogs/ catalogs/catalogos.sqlite3
```

## About the catalogs included

Read the file [*Catálogos SAT*](docs/Catalogos.md) for more information about the catalogs included (in spanish).

- Catálogos de CFDI 3.3.
- Catálogos de CFDI 4.0.
- Catálogos de Complemento de Comercio Exterior 1.1.
- Catálogos de Complemento de Nóminas 1.2.
- Catálogos de Complemento de Carta Porte 2.0.
- Catálogos de Complemento de Recepción de Pagos 1.0.
- Catálagos de CFDI De Retenciones e Información de Pagos 2.0

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
[php-version]: https://github.com/phpcfdi/sat-catalogos-populate/blob/master/composer.json
[release]: https://github.com/phpcfdi/sat-catalogos-populate/releases
[license]: https://github.com/phpcfdi/sat-catalogos-populate/blob/master/LICENSE
[build]: https://github.com/phpcfdi/sat-catalogos-populate/actions/workflows/build.yml?query=branch:master
[quality]: https://scrutinizer-ci.com/g/phpcfdi/sat-catalogos-populate/
[coverage]: https://scrutinizer-ci.com/g/phpcfdi/sat-catalogos-populate/code-structure/master/code-coverage/src

[badge-source]: https://img.shields.io/badge/source-phpcfdi/sat--catalogos--populate-blue?style=flat-square
[badge-php-version]: https://img.shields.io/badge/php-^8.1-blue?style=flat-square
[badge-release]: https://img.shields.io/github/release/phpcfdi/sat-catalogos-populate?style=flat-square
[badge-license]: https://img.shields.io/github/license/phpcfdi/sat-catalogos-populate?style=flat-square
[badge-build]: https://img.shields.io/github/actions/workflow/status/phpcfdi/sat-catalogos-populate/build.yml?branch=master&style=flat-square
[badge-quality]: https://img.shields.io/scrutinizer/g/phpcfdi/sat-catalogos-populate/master?style=flat-square
[badge-coverage]: https://img.shields.io/scrutinizer/coverage/g/phpcfdi/sat-catalogos-populate/master?style=flat-square
