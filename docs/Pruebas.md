# Pruebas

La mejor forma de probar que todo sigue funcionando es ejecutar `phpunit`.

## Archivos de pruebas

Estos archivos están recortados, no contienen toda la información que sus orígenes.

Solamente se eliminaron filas en archivos de excel muy grandes y se eliminaron líneas en archivos separados por comas.

Importante: **Sí respetan la estructura de los archivos**

Para generar los archivos CSV a partir de un archivo de XLS puede usar la herramienta
`tests/convert-xls-to-csv-folder.php`

Los archivos en `tests/_files/sources/*.xls` son descargados del SAT, para ser procesados.
Si hay algún problema con resolver las nuevas descargas del SAT entonces se pueden sustituir
estos archivos y correr los tests. De esta forma podremos notar un cambio importante en estructura.

- `tests/_files/cce/*.csv`: Archivos que salen de los catálogos de Comercio Exterior
- `tests/_files/cfdi/*.csv`: Archivos que salen de los catálogos de CFDI 3.3
- `tests/_files/cfdi40/*.csv`: Archivos que salen de los catálogos de CFDI 4.0
- `tests/_files/nomina/*.csv`: Archivos que salen de los catálogos de Nómina 1.2
- `tests/_files/rep/*.csv`: Archivos que salen de los catálogos de recibo electrónico de pagos

## Actualizar los archivos de pruebas

Por lo anterior, al detectar un cambio en la estructura de los archivos del SAT lo mejor es:

- Descargar los nuevos orígenes y ponerlos en `tests/_files/sources/`
- Exportar los archivos `tests/_files/sources/*.xls` y ponerlos en `tests/_files/<origen>/*.csv`

Por ejemplo:

```shell script
mkdir build/temp
php bin/sat-catalogos-update dump-origins > build/temp/origins.xml
php bin/sat-catalogos-update update-origins build/temp/origins.xml

# en este momento podría simplificar los archivos de orígenes para correr más rápido los tests
# una forma común es tomar solo 2 páginas iniciales y 2 páginas finales de contenido en cualquier hoja
# que exceda los 500 registros

rm -rf tests/_files/sources
rm -rf tests/_files/cfdi
rm -rf tests/_files/cfdi40
rm -rf tests/_files/nomina
rm -rf tests/_files/rep
rm -rf tests/_files/cce

mkdir -p tests/_files/sources
mkdir -p tests/_files/cfdi
mkdir -p tests/_files/cfdi40
mkdir -p tests/_files/nomina
mkdir -p tests/_files/rep
mkdir -p tests/_files/cce

cp build/temp/*.xls tests/_files/sources

php tests/convert-xls-to-csv-folder.php tests/_files/sources/catCFDI.xls tests/_files/cfdi
php tests/convert-xls-to-csv-folder.php tests/_files/sources/cfdi_40.xls tests/_files/cfdi40
php tests/convert-xls-to-csv-folder.php tests/_files/sources/catNomina.xls tests/_files/nomina
php tests/convert-xls-to-csv-folder.php tests/_files/sources/catPagos.xls tests/_files/rep
php tests/convert-xls-to-csv-folder.php tests/_files/sources/c_ClavePedimento.xls tests/_files/cce
php tests/convert-xls-to-csv-folder.php tests/_files/sources/c_Colonia.xls tests/_files/cce
php tests/convert-xls-to-csv-folder.php tests/_files/sources/C_Estado.xls tests/_files/cce
php tests/convert-xls-to-csv-folder.php tests/_files/sources/c_FraccionArancelaria.xls tests/_files/cce
php tests/convert-xls-to-csv-folder.php tests/_files/sources/c_INCOTERM.xls tests/_files/cce
php tests/convert-xls-to-csv-folder.php tests/_files/sources/c_Localidad.xls tests/_files/cce
php tests/convert-xls-to-csv-folder.php tests/_files/sources/c_MotivoTraslado.xls tests/_files/cce
php tests/convert-xls-to-csv-folder.php tests/_files/sources/c_Municipio.xls tests/_files/cce
php tests/convert-xls-to-csv-folder.php tests/_files/sources/c_TipoOperacion.xls tests/_files/cce
php tests/convert-xls-to-csv-folder.php tests/_files/sources/c_UnidadAduana.xls tests/_files/cce
```

Ten en cuenta que estas operaciones generarán archivos que antes no existían porque el catálogo en
cuestión se estaba ignorando, por ejemplo: `tests/_files/cce/rep/c_Moneda.csv`
