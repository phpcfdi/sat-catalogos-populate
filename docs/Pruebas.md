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

- `tests/_files/cce/*.csv`: Archivos que salen de los catálogos de comercio exterior
- `tests/_files/cfdi/*.csv`: Archivos que salen de los catálogos de CFDI 3.3
- `tests/_files/nomina/*.csv`: Archivos que salen de los catálogos de Nomina 1.2
- `tests/_files/rep/*.csv`: Archivos que salen de los catálogos de recibo electrónico de pagos
