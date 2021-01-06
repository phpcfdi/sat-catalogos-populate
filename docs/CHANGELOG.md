# phpcfdi/sat-catalogos-populate Changelog

## Version 1.1.1 2020-01-05

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
- Fix: change how headers compare between splitted files, it was strict, now each column is trim.
- Update testing sources (xls and xsv files), add a procedure on `docs/Pruebas.md`. 
- Fix: failing tests because updated files have right empty columns.

## Version 1.0.3 2019-10-09

- When creating a group of data from several sheets allow `space` at the end, like `c_CodigoPostal_Parte_2·`.
  Thank you SAT, you can always break your own rules.

## Version 1.0.2 2019-10-07

- cfdi_reglas_tasa_cuota was not writting with 6 decimals `minimo` & `valor`

## Version 1.0.1 2019-10-07

- cfdi_impuestos was not detecting `true` (vaue changes from `Sí` to `Si`)
- Dockerfile `sat-catalogos-populate` was using an invalid argument `--no-cache` for composer
- Dockerfile `sat-catalogos-populate-base` was missing sqlite3

## Version 1.0.0 2019-10-07

- First public release, running before locally

