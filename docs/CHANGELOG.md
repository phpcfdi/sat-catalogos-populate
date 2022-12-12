# phpcfdi/sat-catalogos-populate Changelog

## Version 2.5.2 2022-12-12

The catalog *CCE - Fracciones arancelarias* is composed of 3 different catalogs:

- *Catálogo vigente hasta el 27 de diciembre de 2020*.
- *Catálogo vigente del 28 de diciembre de 2020 al 11 de diciembre de 2022*.
- *Catálogo vigente a partir del 12 de diciembre de 2022*.

This update create the catalog `cce_fracciones_arancelarias` by inserting or replacing the catalogs one after another.
Using this method, if an harmonized tariff schedule is found, it will override the previous record.

Other minor changes:

- Update dependencies, install `libreoffice-calc-nogui` and `libreoffice-java-common`.
- 

## Version 2.5.2 2022-12-08

- Fix text to locate the link for *CCE - Fracciones arancelarias 2021*.

## Version 2.5.1 2022-11-18

Fix how to find how many first equal lines are between two CSV files.
In *Catálogos de CFDI 4.0* published at 2022-11-18 was found that the headers on files
`c_CodigoPostal_Parte_1` and `c_CodigoPostal_Parte_2` were different because of empty
cells at the end.

This fix include a better test and fix the issue by changing how csv lines are normalized.
Normalization: explode values, trim values, remove empty values at end & implode values back.

## Version 2.5.0 2022-11-08

- Fix PHPStan issue: `str_getcsv` can return `array<scalar|null>`.
- Update signature for `SeekableIterator::seek`.
- `UrlResponse` can have a `Stringable|string` body property.
- Move logic to create a UrlResponse from a PSR Response
- Bump to PHP 8.1.
- Add badge for PHP 8.1.
- Remove badge for downloads.
- Upgrade development tools.
- Update GH workflow:
  - Add PHP 8.2 to test matrix.
  - Update GH actions to 8.1.
  - Remove composer requierement when not needed.
- Fix composer script `dev:coverage`.
- Implement development tool `composer-normalize`.

## Version 2.4.2 2022-04-01

- Fix *Carta Porte 2.0* injector *ProductosServicios* headers.
- Update sample files for *Carta Porte 2.0*.
- Minimal improvements to PHP 8.0 features and strict types.

## Version 2.4.1 2022-03-18

- Fix origin `CCE - Fracciones arancelarias 2021`, the link contains extra characters now.
- CI: run `apt-get update` before install other packages.

## Version 2.4.0 2022-03-07

Add CCP (*Complemento de Carta Porte*) 2.0 catalogs.

- Add *Origin* as a constant source, saving the file as `CatalogosCartaPorte20.xls`.
- Add *Source importer* from `CatalogosCartaPorte20.xls`. It includes 25 catalogs.
- Importers create tables with prefix `ccp_20_*`.
- Update `docs/Catalogos.md` with CCP 2.0 catalogs.
- Refactor export XLSX to CSV, rename all exported files to remove spaces from name.

## Version 2.3.0 2022-03-05

Add CFDI 4.0 catalogs.

- Add *Origin* as a scrap from SAT website, saving the file as `cfdi_40.xsl`.
- Add *Source importer* from `cfdi_40.xsl`. It includes 25 catalogs.
- Importers create tables with prefix `cfdi_40_*`.
- Update `docs/Catalogos.md` with CFDI 4.0 catalogs.
- Refactor how to know what lines to skip when join two CVS files.

## Version 2.2.1 2022-03-04

Include `Nóminas - Estados` origin to `dump-origins` command.

## Version 2.2.0 2022-03-04

Allow scrap link text use wildcards as in `fnmatch`.

Fix build because now `catNomina.xls` does not contain *Catálogo de estados*.
Uses `C_Estado.xls` from *Complemento de comercio exterior* to build `nomina_estados`.
This is confirmed by XSD contents.

Update `docs/Catalogos.md`, add missing `nomina_*` tables.

Improve development environment:

- Update development tools.
- CI run `phpcs` on files set by config file.
- Update `php-cs-fixer` config file.
- Update `rector/rector` from development dependencies.

## Version 2.1.0 2022-02-10

Some catalogs structure have been updated: *CCE Estados*, *CCE Localidades*, *CCE Municipios* and *Nomina Estados*.
The main change is that now these catalogs contains validity period.

## Version 2.0.0 2022-01-19

- Change CFDI 3.3 catalogs from fixed URL <http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/catCFDI.xls>
  to scrap <http://omawww.sat.gob.mx/tramitesyservicios/Paginas/anexo_20_version3-3.htm>
  and search for link with text `Catálogos CFDI Versión 3.3(xls)`.
- Update license year to 2022. Happy new year!
- Upgrade to PHP 8.0.
- Fix compatibility on PHP 8.1.
- Upgrade to PHPStan 1.3.3. Fix a lot of issues found. Thank you, PHPStan!
- Move development dependencies to Phive.
- Remove Travis CI. Thank you, Travis CI!
- Add GitHub Workflows.
- Update `CONTRIBUTING.md`.
- Refactor Docker image to use `debian:bullseye` and PHP Packages from <https://deb.sury.org/>.

Backwards compatibility changes:

```text
[BC] CHANGED: Constant PhpCfdi\SatCatalogosPopulate\Commands\UpdateOrigins::DEFAULT_ORIGINS_FILENAME visibility reduced from public to private
[BC] CHANGED: Parameter 0 of PhpCfdi\SatCatalogosPopulate\Utils\CsvFile#seek() changed name from position to offset
[BC] CHANGED: The parameter $arguments of PhpCfdi\SatCatalogosPopulate\Commands\CliApplication#runCommand() changed from array to a non-contravariant string
[BC] CHANGED: The parameter $arguments of PhpCfdi\SatCatalogosPopulate\Commands\CliApplication#runCommand() changed from array to string
[BC] CHANGED: The parameter $member of PhpCfdi\SatCatalogosPopulate\AbstractCollection#isValidMember() changed from no type to mixed
[BC] CHANGED: The parameter $member of PhpCfdi\SatCatalogosPopulate\Injectors#isValidMember() changed from no type to mixed
[BC] CHANGED: The parameter $member of PhpCfdi\SatCatalogosPopulate\Origins\Origins#isValidMember() changed from no type to mixed
[BC] CHANGED: The parameter $member of PhpCfdi\SatCatalogosPopulate\Origins\Reviews#isValidMember() changed from no type to mixed
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\AbstractCollection#getIterator() changed from no type to ArrayIterator
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector#readLinesFromCsv() changed from no type to Iterator
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Commands\CommandInterface::createFromArguments() changed from self to no type
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Commands\CommandInterface::createFromArguments() changed from self to the non-covariant no type
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Commands\DumpOrigins::createFromArguments() changed from PhpCfdi\SatCatalogosPopulate\Commands\CommandInterface to self
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Commands\DumpOrigins::createFromArguments() changed from PhpCfdi\SatCatalogosPopulate\Commands\CommandInterface to the non-covariant self
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Commands\UpdateDatabase::createFromArguments() changed from PhpCfdi\SatCatalogosPopulate\Commands\CommandInterface to self
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Commands\UpdateDatabase::createFromArguments() changed from PhpCfdi\SatCatalogosPopulate\Commands\CommandInterface to the non-covariant self
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Commands\UpdateOrigins#createResourcesGateway() changed from PhpCfdi\SatCatalogosPopulate\Origins\ResourcesGatewayInterface to PhpCfdi\SatCatalogosPopulate\Origins\WebResourcesGateway
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Commands\UpdateOrigins::createFromArguments() changed from PhpCfdi\SatCatalogosPopulate\Commands\CommandInterface to self
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Commands\UpdateOrigins::createFromArguments() changed from PhpCfdi\SatCatalogosPopulate\Commands\CommandInterface to the non-covariant self
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Database\DataFields#getIterator() changed from no type to ArrayIterator
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\CodigosPostales#readLinesFromCsv() changed from no type to Generator
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\TiposComprobantes#readLinesFromCsv() changed from no type to Generator
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Origins\ConstantOrigin#withLastModified() changed from self to static
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Origins\ConstantOrigin#withLastModified() changed from self to the non-covariant static
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Origins\OriginInterface#withLastModified() changed from no type to static
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Origins\ScrapingOrigin#withLastModified() changed from self to static
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Origins\ScrapingOrigin#withLastModified() changed from self to the non-covariant static
[BC] CHANGED: The return type of PhpCfdi\SatCatalogosPopulate\Utils\CsvFile#readLines() changed from no type to Iterator
[BC] REMOVED: Constant PhpCfdi\SatCatalogosPopulate\Commands\UpdateOrigins::DEFAULT_ORIGINS_FILENAME was removed
[BC] REMOVED: Method PhpCfdi\SatCatalogosPopulate\Injectors#getByClassname() was removed
```

## Version 1.2.1 2021-03-18

- Found some cases where imported cells contains left or right a non-breaking space `&nbsp;`.
  On this update this chars will be replaced to space and then trimmed.
- Update test files with catalog information for 2021-03-18. The structure remains.

## Version 1.2.0 2021-01-08

- Update `CCE - Unidades de medida`, the new catalog includes "vigencias".
- Add `CCE - Fracciones arancelarias 2021`, the new catalog has the same structure as `CCE - Fracciones arancelarias`
  but it contains a harmonized tariff code (`fraccion`) of 10 digits. The previous codes are imported and preserved.
- Refactor `Origins`:
  - The previous `Origin` is now `ConstantOrigin` and implements `OriginInterface`.
  - The previous is `Reviewer` is now `ConstantReviewer` and implements `ReviewerInterface`.
  - The logic to review all origins is now located on the new class `Reviewers` that is a simple collection of
    `ReviewerInterface` objects.
  - Created `ScrapOrigin` and `ScrapReviewer`.
  - Updated `OriginsIO` to support multiple types of origins and uses `OriginsTranslator` to read or write structure.
- Add dependency to `symfony/dom-crawler` in order to scrap catalog pages.
- Update license year, HNY from PhpCfdi!

## Version 1.1.1 2021-01-05

- Update to new catalog c_ClaveProdServ, the layout (version 4, rev 0) includes a row with a title since 2020-12-29.
- Travis-CI:
  - Install `default-jre-headless` instead of `openjdk-11-jre-headless`.
  - Remove non-required `libsaxonb-java`.

## Version 1.1.0 2020-06-01

- Refactor `docker` implementation. It does not use `sat-catalogos-populate-base` anymore.
- Improve installation and usage documentation.
- Remove `bash` commands located on `bin/`, those files are out of the scope of this project.
- Upgrade `guzzlehttp/guzzle: ^6.0` to `guzzlehttp/guzzle: ^7.0`.
- Require `psr/http-message:^1.0` since is a direct dependence.
- Remove unused functions `file_extension` and `file_extension_replace` on namespace `PhpCfdi\SatCatalogosPopulate\Utils`.

## Version 1.0.5 2020-05-02

The problems fixed here has been present since 2020-02-01.
They have been fixed until now since anybody reports an issue.

- SAT change `CCE/c_FraccionArancelaria`:
    - It does not have fields `Criterio`, `Impuesto IMP` and `Impuesto EXP`.
    - The structure now uses only one row instead of two.
    - It does not require to ignore the first column zero.
- SAT change `CCE/c_INCOTERM`:
    - It now has `vigencia_desde` and `vigencia_hasta`.
- Update testing catalogs according to the instructions located at `docs/Pruebas.md`.

## Version 1.0.4 2019-10-11

- Situation: SAT change again the `c_CodigoPostal`, change the meaning of the columns and introduce a nasty
  change on headers setting trailing spaces into headers and not exactly the same headers on second part.
- Update catalog `CodigosPostales`:
    - `estimulo_vigencia_desde` is now `vigencia_desde`.
    - `estimulo_vigencia_hasta` is now `vigencia_hasta`.
- Fix: change how headers compare between split files, it was strict, now each column is trim.
- Update testing sources (xls and xsv files), add a procedure on `docs/Pruebas.md`. 
- Fix: failing tests because updated files have right empty columns.

## Version 1.0.3 2019-10-09

- When creating a group of data from several sheets allow `space` at the end, like `c_CodigoPostal_Parte_2·`.
  Thank you SAT, you can always break your own rules.

## Version 1.0.2 2019-10-07

- cfdi_reglas_tasa_cuota was not writing with 6 decimals `minimo` & `valor`

## Version 1.0.1 2019-10-07

- cfdi_impuestos was not detecting `true` (value changes from `Sí` to `Si`)
- Dockerfile `sat-catalogos-populate` was using an invalid argument `--no-cache` for composer
- Dockerfile `sat-catalogos-populate-base` was missing sqlite3

## Version 1.0.0 2019-10-07

- First public release, running before locally

