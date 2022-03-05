# Catálogos SAT

Los catálogos se encuentran en tablas de una base de datos de Sqlite3.

Si bien hay catálogos que solo contienen 3 renglones y 1 columna hay otros catálogos que contienen
muchas más columnas y miles de registros. La mejor manera *uniforme* que se nos ocurrió para hacer esta
exportación es a una base de datos.

También evaluamos formatos textuales como json, xml personalizado y xml estructurado, pero ninguno de estos métodos
nos provee de una manera rápida y fácil de hacer consultas sin cargar todo el contenido de un catálogo, por lo tanto
buscar dentro de un catálogo grande consumiría muchos recursos.

A pesar de que el SAT les llama catálogos a todos, no todos lo son. Al menos no en el sentido estricto.
Un catálogo contiene una llave, algunos de los catálogos del SAT no contienen llaves o contienen valores duplicados
o no contienen registros que sí deberían contener.


## Consumo de los catálogos en PHP

Esta librería [`phpcfdi/sat-catalogos-populate`](https://github.com/phpcfdi/sat-catalogos-populate)
existe solo para crear la base de datos.

Para consumir estos catálogos puede usar la librería independiente
[`phpcfdi/sat-catalogos`](https://github.com/phpcfdi/sat-catalogos).


## Tabla de catálogos

| Tabla                         | Origen                    | Catálogo              | Notas                                                                                |
|-------------------------------|---------------------------|-----------------------|--------------------------------------------------------------------------------------|
| cfdi_aduanas                  | catCFDI.xls               | c_Aduana              |                                                                                      |
| cfdi_claves_unidades          | catCFDI.xls               | c_ClaveUnidad         |                                                                                      |
| cfdi_codigos_postales         | catCFDI.xls               | c_CodigoPostal        | Este catálogo viene en dos partes, se relaciona con catálogos de CCE                 |
| cfdi_formas_pago              | catCFDI.xls               | c_FormaPago           |                                                                                      |
| cfdi_impuestos                | catCFDI.xls               | c_Impuesto            |                                                                                      |
| cfdi_metodos_pago             | catCFDI.xls               | c_MetodoPago          |                                                                                      |
| cfdi_monedas                  | catCFDI.xls               | c_Moneda              |                                                                                      |
| cfdi_numeros_pedimento_aduana | catCFDI.xls               | c_NumPedimentoAduana  | No es un catálogo, es una tabla de reglas, contiene duplicados                       |
| cfdi_paises                   | catCFDI.xls               | c_Pais                |                                                                                      |
| cfdi_patentes_aduanales       | catCFDI.xls               | c_PatenteAduanal      |                                                                                      |
| cfdi_regimenes_fiscales       | catCFDI.xls               | c_RegimenFiscal       |                                                                                      |
| cfdi_productos_servicios      | catCFDI.xls               | c_ClaveProdServ       |                                                                                      |
| cfdi_reglas_tasa_cuota        | catCFDI.xls               | c_TasaOCuota          | No es un catálogo, es una tabla de reglas                                            |
| cfdi_tipos_comprobantes       | catCFDI.xls               | c_TipoDeComprobante   | No se divide el tipo Nómina en Ns y NdS                                              |
| cfdi_tipos_factores           | catCFDI.xls               | c_TipoFactor          |                                                                                      |
| cfdi_tipos_relaciones         | catCFDI.xls               | c_TipoRelacion        |                                                                                      |
| cfdi_usos_cfdi                | catCFDI.xls               | c_UsoCFDI             |                                                                                      |
| cce_claves_pedimentos         | c_ClavePedimento.xls      | c_ClavePedimento      |                                                                                      |
| cce_colonias                  | c_Colonia.xls             | c_Colonia             | Viene en 3 partes                                                                    |
| cce_estados                   | C_Estado.xls              | c_Estado              | Estados de México, Estados Unidos y Canadá                                           |
| cce_fracciones_arancelarias   | c_FraccionArancelaria.xls | c_FraccionArancelaria |                                                                                      |
| cce_incoterms                 | c_INCOTERM.xls            | c_INCOTERM            |                                                                                      |
| cce_localidades               | c_Localidad.xls           | c_Localidad           |                                                                                      |
| cce_localidades               | c_Localidad.xls           | c_Localidad           |                                                                                      |
| cce_motivos_traslado          | c_MotivoTraslado.xls      | c_MotivoTraslado      |                                                                                      |
| cce_municipios                | c_Municipio.xls           | c_Municipio           |                                                                                      |
| cce_tipos_operacion           | c_TipoOperacion.xls       | c_TipoOperacion       |                                                                                      |
| cce_unidades_aduana           | c_UnidadAduana.xls        | c_UnidadAduana        | No confundir con las claves de unidades, estas son las unidades de comercio exterior |
| nominas_bancos                | catNomina.xls             | c_Banco               |                                                                                      |
| nominas_estados               | nomina_estados.xls        | c_Estado              | Es el mismo que el publicado en cce_estados                                          |
| nomina_origenes_recursos      | catNomina.xls             | c_OrigenRecurso       |                                                                                      |
| nomina_periodicidades_pagos   | catNomina.xls             | c_PeriodicidadPago    |                                                                                      |
| nomina_riesgos_puestos        | catNomina.xls             |                       |                                                                                      |
| nomina_tipos_contratos        | catNomina.xls             | c_TipoContrato        |                                                                                      |
| nomina_tipos_deducciones      | catNomina.xls             | c_TipoDeduccion       |                                                                                      |
| nomina_tipos_horas            | catNomina.xls             | c_TipoHoras           |                                                                                      |
| nomina_tipos_incapacidades    | catNomina.xls             | c_TipoIncapacidad     |                                                                                      |
| nomina_tipos_jornadas         | catNomina.xls             | c_TipoJornada         |                                                                                      |
| nomina_tipos_nominas          | catNomina.xls             | c_TipoNomina          |                                                                                      |
| nomina_tipos_otros_pagos      | catNomina.xls             | c_TipoOtroPago        |                                                                                      |
| nomina_tipos_percepciones     | catNomina.xls             | c_TipoPercepcion      |                                                                                      |
| nomina_tipos_regimenes        | catNomina.xls             | c_TipoRegimen         |                                                                                      |

## CFDI

> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Paginas/Anexo_20_version3.3.aspx>
> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Documents/catCFDI.xls>

Los catálogos de CFDI contienen los catálogos básicos de CFDI versión 3.3.
Están publicados en formato XLS (Microsoft Excel 2003) y la conversión se hace pasando a Microsoft Excel 2007 y luego
a archivos CSV en una sola carpeta. En la conversión también se juntan las hojas que están divididas en partes.

Por lo anterior, solo existe un importador con múltiples inyectores.


## CCE (Complemento de comercio exterior)

> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Paginas/catalogos_emision_de_cfdi_con_complemento_comercio_exterior.aspx>

Los catálogos de CCE contienen información extendida que debe ser respetada para el correcto llenado
del complemento de comercio exterior.

En el caso de estos catálogos, a diferencia de los catálogos de CFDI, se distribuye cada catálogo en un archivo xls
independiente, cada uno con una o varias hojas de excel, por lo que se crea un importador y el importador contiene
un solo inyector.

Se provee un importador que agrupa a todos estos importadores en uno.

No se están importando los catálogos repetidos: `c_Pais`, `c_Moneda`, `c_CodigoPostal` y `c_RegimenFiscal`.

## NOM (Complemento de recibo de pago de nómina)

> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Paginas/complemento_nomina.aspx>
> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Documents/Complementoscfdi/catNomina.xls>

Los catálogos de CCE contienen información extendida que debe ser respetada para el correcto llenado
del complemento de recibo de pago de nómina.

Los catálogos están en un solo archivo de excel por lo que se usa la misma estrategia que en los catálogos de CFDI.

El catálogo de estados `c_Estado` debería considerarse como repetido, sin embargo,
por no estar publicado en los catálogos del CFDI entonces se importa en su propio espacio.

No se están importando los catálogos repetidos: `c_CodigoPostal` y `c_RegimenFiscal`.

## REP (Complemento de recibo electrónico de pagos)

> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Paginas/Recepcion_de_pagos.aspx>
> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Documents/Complementoscfdi/catPagos.xls>

Los catálogos de REP contienen información extendida que debe ser respetada para el correcto llenado
del complemento de recibo electrónico de pagos.

Los catálogos están en un solo archivo de excel por lo que se usa la misma estrategia que en los catálogos de CFDI.

La información de catálogos publicada contiene información de impuestos, que en la implementación final del REP
no es necesaria por lo que no se incluyen `c_Impuesto`, `c_TasaOCuota` o `c_TipoFactor`.

No se están importando los catálogos repetidos `c_MetodoPago` y `c_FormaPago`.

Por lo anterior, el único catálogo que se termina importando es `c_TipoCadenaPago`.
