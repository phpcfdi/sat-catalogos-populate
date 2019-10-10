# phpcfdi/sat-catalogos-populate Changelog

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

