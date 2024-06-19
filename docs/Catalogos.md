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

| Tabla                                 | Origen                    | Catálogo                        | Notas                                                                                |
|---------------------------------------|---------------------------|---------------------------------|--------------------------------------------------------------------------------------|
| cfdi_aduanas                          | catCFDI.xls               | c_Aduana                        |                                                                                      |
| cfdi_claves_unidades                  | catCFDI.xls               | c_ClaveUnidad                   |                                                                                      |
| cfdi_codigos_postales                 | catCFDI.xls               | c_CodigoPostal                  | Este catálogo viene en dos partes, se relaciona con catálogos de CCE                 |
| cfdi_formas_pago                      | catCFDI.xls               | c_FormaPago                     |                                                                                      |
| cfdi_impuestos                        | catCFDI.xls               | c_Impuesto                      |                                                                                      |
| cfdi_metodos_pago                     | catCFDI.xls               | c_MetodoPago                    |                                                                                      |
| cfdi_monedas                          | catCFDI.xls               | c_Moneda                        |                                                                                      |
| cfdi_numeros_pedimento_aduana         | catCFDI.xls               | c_NumPedimentoAduana            | No es un catálogo, es una tabla de reglas, contiene duplicados                       |
| cfdi_paises                           | catCFDI.xls               | c_Pais                          |                                                                                      |
| cfdi_patentes_aduanales               | catCFDI.xls               | c_PatenteAduanal                |                                                                                      |
| cfdi_regimenes_fiscales               | catCFDI.xls               | c_RegimenFiscal                 |                                                                                      |
| cfdi_productos_servicios              | catCFDI.xls               | c_ClaveProdServ                 |                                                                                      |
| cfdi_reglas_tasa_cuota                | catCFDI.xls               | c_TasaOCuota                    | No es un catálogo, es una tabla de reglas                                            |
| cfdi_tipos_comprobantes               | catCFDI.xls               | c_TipoDeComprobante             | No se divide el tipo Nómina en Ns y NdS                                              |
| cfdi_tipos_factores                   | catCFDI.xls               | c_TipoFactor                    |                                                                                      |
| cfdi_tipos_relaciones                 | catCFDI.xls               | c_TipoRelacion                  |                                                                                      |
| cfdi_usos_cfdi                        | catCFDI.xls               | c_UsoCFDI                       |                                                                                      |
| cfdi_40_aduanas                       | cfdi_40.xls               | c_Aduana                        |                                                                                      |
| cfdi_40_claves_unidades               | cfdi_40.xls               | c_ClaveUnidad                   |                                                                                      |
| cfdi_40_codigos_postales              | cfdi_40.xls               | c_CodigoPostal                  | Este catálogo viene en dos partes, se relaciona con catálogos de CCE                 |
| cfdi_40_colonias                      | cfdi_40.xls               | C_Colonia                       |                                                                                      |
| cfdi_40_estados                       | cfdi_40.xls               | c_Estado                        |                                                                                      |
| cfdi_40_exportaciones                 | cfdi_40.xls               | c_Exportacion                   |                                                                                      |
| cfdi_40_formas_pago                   | cfdi_40.xls               | c_FormaPago                     |                                                                                      |
| cfdi_40_impuestos                     | cfdi_40.xls               | c_Impuesto                      |                                                                                      |
| cfdi_40_localidades                   | cfdi_40.xls               | C_Localidad                     |                                                                                      |
| cfdi_40_meses                         | cfdi_40.xls               | c_Meses                         |                                                                                      |
| cfdi_40_metodos_pago                  | cfdi_40.xls               | c_MetodoPago                    |                                                                                      |
| cfdi_40_monedas                       | cfdi_40.xls               | c_Moneda                        |                                                                                      |
| cfdi_40_municipios                    | cfdi_40.xls               | C_Municipio                     |                                                                                      |
| cfdi_40_numeros_pedimento_aduana      | cfdi_40.xls               | c_NumPedimentoAduana            | No es un catálogo, es una tabla de reglas, contiene duplicados                       |
| cfdi_40_objetos_impuestos             | cfdi_40.xls               | c_ObjetoImp                     |                                                                                      |
| cfdi_40_paises                        | cfdi_40.xls               | c_Pais                          |                                                                                      |
| cfdi_40_patentes_aduanales            | cfdi_40.xls               | c_PatenteAduanal                |                                                                                      |
| cfdi_40_periodicidades                | cfdi_40.xls               | c_Periodicidad                  |                                                                                      |
| cfdi_40_productos_servicios           | cfdi_40.xls               | c_ClaveProdServ                 |                                                                                      |
| cfdi_40_regimenes_fiscales            | cfdi_40.xls               | c_RegimenFiscal                 |                                                                                      |
| cfdi_40_reglas_tasa_cuota             | cfdi_40.xls               | c_TasaOCuota                    | No es un catálogo, es una tabla de reglas                                            |
| cfdi_40_tipos_comprobantes            | cfdi_40.xls               | c_TipoDeComprobante             | No se divide el tipo Nómina en Ns y NdS                                              |
| cfdi_40_tipos_factores                | cfdi_40.xls               | c_TipoFactor                    |                                                                                      |
| cfdi_40_tipos_relaciones              | cfdi_40.xls               | c_TipoRelacion                  |                                                                                      |
| cfdi_40_usos_cfdi                     | cfdi_40.xls               | c_UsoCFDI                       |                                                                                      |
| cce_claves_pedimentos                 | c_ClavePedimento.xls      | c_ClavePedimento                |                                                                                      |
| cce_colonias                          | c_Colonia.xls             | c_Colonia                       | Viene en 3 partes                                                                    |
| cce_estados                           | C_Estado.xls              | c_Estado                        | Estados de México, Estados Unidos y Canadá                                           |
| cce_fracciones_arancelarias           | *                         | c_FraccionArancelaria           |                                                                                      |
| cce_incoterms                         | c_INCOTERM.xls            | c_INCOTERM                      |                                                                                      |
| cce_localidades                       | c_Localidad.xls           | c_Localidad                     |                                                                                      |
| cce_motivos_traslado                  | c_MotivoTraslado.xls      | c_MotivoTraslado                |                                                                                      |
| cce_municipios                        | c_Municipio.xls           | c_Municipio                     |                                                                                      |
| cce_tipos_operacion                   | c_TipoOperacion.xls       | c_TipoOperacion                 |                                                                                      |
| cce_unidades_aduana                   | c_UnidadAduana.xls        | c_UnidadAduana                  | No confundir con las claves de unidades, estas son las unidades de comercio exterior |
| cce_20_claves_pedimentos              | c_ClavePedimento20.xls    | c_ClavePedimento                |                                                                                      |
| cce_20_colonias                       | c_Colonia20.xls           | c_Colonia                       | Viene en 3 partes                                                                    |
| cce_20_estados                        | C_Estado20.xls            | c_Estado                        | Estados de México, Estados Unidos y Canadá                                           |
| cce_20_fracciones_arancelarias        | *                         | c_FraccionArancelaria           |                                                                                      |
| cce_20_incoterms                      | c_INCOTERM20.xls          | c_INCOTERM                      |                                                                                      |
| cce_20_localidades                    | c_Localidad20.xls         | c_Localidad                     |                                                                                      |
| cce_20_motivos_traslado               | c_MotivoTraslado20.xls    | c_MotivoTraslado                |                                                                                      |
| cce_20_municipios                     | c_Municipio20.xls         | c_Municipio                     |                                                                                      |
| cce_20_tipos_operacion                | c_TipoOperacion20.xls     | c_TipoOperacion                 |                                                                                      |
| cce_20_unidades_aduana                | c_UnidadAduana20.xls      | c_UnidadAduana                  | No confundir con las claves de unidades, estas son las unidades de comercio exterior |
| nominas_bancos                        | catNomina.xls             | c_Banco                         |                                                                                      |
| nominas_estados                       | nomina_estados.xls        | c_Estado                        | Es el mismo que el publicado en cce_estados                                          |
| nomina_origenes_recursos              | catNomina.xls             | c_OrigenRecurso                 |                                                                                      |
| nomina_periodicidades_pagos           | catNomina.xls             | c_PeriodicidadPago              |                                                                                      |
| nomina_riesgos_puestos                | catNomina.xls             |                                 |                                                                                      |
| nomina_tipos_contratos                | catNomina.xls             | c_TipoContrato                  |                                                                                      |
| nomina_tipos_deducciones              | catNomina.xls             | c_TipoDeduccion                 |                                                                                      |
| nomina_tipos_horas                    | catNomina.xls             | c_TipoHoras                     |                                                                                      |
| nomina_tipos_incapacidades            | catNomina.xls             | c_TipoIncapacidad               |                                                                                      |
| nomina_tipos_jornadas                 | catNomina.xls             | c_TipoJornada                   |                                                                                      |
| nomina_tipos_nominas                  | catNomina.xls             | c_TipoNomina                    |                                                                                      |
| nomina_tipos_otros_pagos              | catNomina.xls             | c_TipoOtroPago                  |                                                                                      |
| nomina_tipos_percepciones             | catNomina.xls             | c_TipoPercepcion                |                                                                                      |
| nomina_tipos_regimenes                | catNomina.xls             | c_TipoRegimen                   |                                                                                      |
| ccp_20_autorizaciones_naviero         | CatalogosCartaPorte20.xls | c_NumAutorizacionNaviero        |                                                                                      |
| ccp_20_claves_unidades                | CatalogosCartaPorte20.xls | c_ClaveUnidadPeso               |                                                                                      |
| ccp_20_codigos_transporte_aereo       | CatalogosCartaPorte20.xls | c_CodigoTransporteAereo         |                                                                                      |
| ccp_20_colonias                       | CatalogosCartaPorte20.xls | c_Colonia                       | Se divide en 3 partes, es el mismo que CFDI 4.0                                      |
| ccp_20_configuraciones_autotransporte | CatalogosCartaPorte20.xls | c_ConfigAutotransporte          |                                                                                      |
| ccp_20_configuraciones_maritimas      | CatalogosCartaPorte20.xls | c_ConfigMaritima                |                                                                                      |
| ccp_20_contenedores                   | CatalogosCartaPorte20.xls | c_Contenedor                    |                                                                                      |
| ccp_20_contenedores_maritimos         | CatalogosCartaPorte20.xls | c_ContenedorMaritimo            |                                                                                      |
| ccp_20_derechos_de_paso               | CatalogosCartaPorte20.xls | c_DerechosDePaso                |                                                                                      |
| ccp_20_estaciones                     | CatalogosCartaPorte20.xls | c_Estaciones                    | Nombre de las estaciones aéreas, maritimas y ferroviarias.                           |
| ccp_20_figuras_transporte             | CatalogosCartaPorte20.xls | c_FiguraTransporte              |                                                                                      |
| ccp_20_localidades                    | CatalogosCartaPorte20.xls | c_Localidad                     | Es el mismo que CFDI 4.0.                                                            |
| ccp_20_materiales_peligrosos          | CatalogosCartaPorte20.xls | c_MaterialPeligroso             | La clave de material peligroso no es única.                                          |
| ccp_20_municipios                     | CatalogosCartaPorte20.xls | c_Municipio                     | Es el mismo que CFDI 4.0.                                                            |
| ccp_20_partes_transporte              | CatalogosCartaPorte20.xls | c_ParteTransporte               |                                                                                      |
| ccp_20_productos_servicios            | CatalogosCartaPorte20.xls | c_ClaveProdServCP               | Se parece al catálogo de CFDI 4.0 pero contiene información diferente                |
| ccp_20_tipos_carga                    | CatalogosCartaPorte20.xls | c_ClaveTipoCarga                |                                                                                      |
| ccp_20_tipos_carro                    | CatalogosCartaPorte20.xls | c_TipoCarro                     |                                                                                      |
| ccp_20_tipos_embalaje                 | CatalogosCartaPorte20.xls | c_TipoEmbalaje                  |                                                                                      |
| ccp_20_tipos_estacion                 | CatalogosCartaPorte20.xls | c_TipoEstacion                  |                                                                                      |
| ccp_20_tipos_permiso                  | CatalogosCartaPorte20.xls | c_TipoPermiso                   |                                                                                      |
| ccp_20_tipos_remolque                 | CatalogosCartaPorte20.xls | c_SubTipoRem                    |                                                                                      |
| ccp_20_tipos_servicio                 | CatalogosCartaPorte20.xls | c_TipoDeServicio                |                                                                                      |
| ccp_20_tipos_trafico                  | CatalogosCartaPorte20.xls | c_TipoDeTrafico                 |                                                                                      |
| ccp_20_transportes                    | CatalogosCartaPorte20.xls | c_CveTransporte                 |                                                                                      |
| ret_20_claves_retencion               | ret_20.xls                | c_CveRetenc                     |                                                                                      |
| ret_20_ejercicios                     | ret_20.xls                | c_Ejercicio                     |                                                                                      |
| ret_20_entidades_federativas          | ret_20.xls                | c_EntidadesFederativas          |                                                                                      |
| ret_20_paises                         | ret_20.xls                | c_Pais                          |                                                                                      |
| ret_20_periodicidades                 | ret_20.xls                | c_Periodicidad                  |                                                                                      |
| ret_20_periodos                       | ret_20.xls                | c_Periodo                       |                                                                                      |
| ret_20_tipos_contribuyentes           | ret_20.xls                | c_TipoContribuyenteSujetoRetenc |                                                                                      |
| ret_20_tipos_dividendos_utilidades    | ret_20.xls                | c_TipoDividendoOUtilidadDistrib |                                                                                      |
| ret_20_tipos_impuestos                | ret_20.xls                | c_TipoImpuesto                  |                                                                                      |
| ret_20_tipos_pago_retencion           | ret_20.xls                | c_TipoPagoRet                   |                                                                                      |

## CFDI 3.3 `cfdi_*`

> - <http://omawww.sat.gob.mx/tramitesyservicios/Paginas/anexo_20_version3-3.htm>

Los catálogos de CFDI contienen los catálogos de CFDI versión 3.3.
Están publicados en formato XLS (Microsoft Excel 2003) y la conversión se hace pasando a Microsoft Excel 2007 y luego
a archivos CSV en una sola carpeta. En la conversión también se juntan las hojas que están divididas en partes.

Por lo anterior, solo existe un importador con múltiples inyectores.

## CFDI 4.0 `cfdi_40_*`

> - <http://omawww.sat.gob.mx/tramitesyservicios/Paginas/anexo_20_version3-3.htm>

Los catálogos de CFDI contienen los catálogos de CFDI versión 4.0.
Están publicados en formato XLS (Microsoft Excel 2003) y la conversión se hace pasando a Microsoft Excel 2007 y luego
a archivos CSV en una sola carpeta. En la conversión también se juntan las hojas que están divididas en partes.

Por lo anterior, solo existe un importador con múltiples inyectores.

## CCE 1.1 (Complemento de comercio exterior) `cce_*`

> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Paginas/catalogos_emision_de_cfdi_con_complemento_comercio_exterior.aspx>

Los catálogos de CCE contienen información extendida que debe ser respetada para el correcto llenado
del complemento de comercio exterior.

En el caso de estos catálogos, a diferencia de los catálogos de CFDI, se distribuye cada catálogo en un archivo xls
independiente, cada uno con una o varias hojas de excel, por lo que se crea un importador y el importador contiene
un solo inyector.

Se provee un importador que agrupa a todos estos importadores en uno.

El catálogo de fracciones arancelarias se obtiene mediante scrap, pues el nombre del archivo origen cambia continuamente.

No se están importando los catálogos repetidos: `c_Pais`, `c_Moneda`, `c_CodigoPostal` y `c_RegimenFiscal`.


## CCE 2.0 (Complemento de comercio exterior) `cce_20_*`

> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Paginas/catalogos_emision_de_cfdi_con_complemento_comercio_exterior.aspx>

Los catálogos de CCE contienen información extendida que debe ser respetada para el correcto llenado
del complemento de comercio exterior.

En el caso de estos catálogos, a diferencia de los catálogos de CFDI, se distribuye cada catálogo en un archivo xls
independiente, cada uno con una o varias hojas de excel, por lo que se crea un importador y el importador contiene
un solo inyector.

Se provee un importador que agrupa a todos estos importadores en uno.

No se están importando los catálogos repetidos: `c_Pais`, `c_Moneda`, `c_CodigoPostal` y `c_RegimenFiscal`.

El catálogo de fracciones arancelarias se obtiene mediante scrap, pues el nombre del archivo podría cambiar continuamente.

## NOM 1.0 (Complemento de recibo de pago de nómina) `nómina_*`

> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Paginas/complemento_nomina.aspx>
> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Documents/Complementoscfdi/catNomina.xls>

Los catálogos de CCE contienen información extendida que debe ser respetada para el correcto llenado
del complemento de recibo de pago de nómina.

Los catálogos están en un solo archivo de excel por lo que se usa la misma estrategia que en los catálogos de CFDI.

El catálogo de estados `c_Estado` debería considerarse como repetido, sin embargo,
por no estar publicado en los catálogos del CFDI entonces se importa en su propio espacio.

No se están importando los catálogos repetidos: `c_CodigoPostal` y `c_RegimenFiscal`.

## REP 1.0 (Complemento de recibo electrónico de pagos) `pagos_*`

> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Paginas/Recepcion_de_pagos.aspx>
> - <http://omawww.sat.gob.mx/informacion_fiscal/factura_electronica/Documents/Complementoscfdi/catPagos.xls>

Los catálogos de REP contienen información extendida que debe ser respetada para el correcto llenado
del complemento de recibo electrónico de pagos.

Los catálogos están en un solo archivo de excel por lo que se usa la misma estrategia que en los catálogos de CFDI.

La información de catálogos publicada contiene información de impuestos, que en la implementación final del REP
no es necesaria por lo que no se incluyen `c_Impuesto`, `c_TasaOCuota` o `c_TipoFactor`.

No se están importando los catálogos repetidos `c_MetodoPago` y `c_FormaPago`.

Por lo anterior, el único catálogo que se termina importando es `c_TipoCadenaPago`.

## CCP 2.0 (Complemento Carta Porte 2.0) `ccp_20_*`

> - <http://omawww.sat.gob.mx/tramitesyservicios/Paginas/complemento_carta_porte.htm>
> - <http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/CatalogosCartaPorte20.xls>

Los catálogos de CCP 2.0 contienen información extendida que debe ser respetada para el correcto llenado
del complemento de carta porte versión 2.0.

Los catálogos están en un solo archivo de excel por lo que se usa la misma estrategia que en los catálogos de CFDI.

Algunos nombres de las hojas contienen espacios.

El catálogo `c_MaterialPeligroso` debería tener un índice único en `Clave material peligroso` pero ocurre que
contiene duplicados.

Por lo anterior, solo existe un importador con múltiples inyectores.

## CCP 3.0 (Complemento Carta Porte 3.0) `ccp_30_*`

> - <http://omawww.sat.gob.mx/tramitesyservicios/Paginas/complemento_carta_porte.htm>
> - <http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/CatalogosCartaPorte30.xls>

Los catálogos de CCP 3.0 contienen información extendida que debe ser respetada para el correcto llenado
del complemento de carta porte versión 3.0.

Los catálogos están en un solo archivo de excel por lo que se usa la misma estrategia que en los catálogos de CFDI.

Algunos nombres de las hojas contienen espacios.

El catálogo `c_MaterialPeligroso` debería tener un índice único en `Clave material peligroso` pero ocurre que
contiene duplicados.

Por lo anterior, solo existe un importador con múltiples inyectores.

## CCP 3.1 (Complemento Carta Porte 3.1) `ccp_31_*`

> - <http://omawww.sat.gob.mx/tramitesyservicios/Paginas/complemento_carta_porte.htm>
> - <http://omawww.sat.gob.mx/tramitesyservicios/Paginas/documentos/CatalogosCartaPorte31.xls>

Los catálogos de CCP 3.1 contienen información extendida que debe ser respetada para el correcto llenado
del complemento de carta porte versión 3.1.

Los catálogos están en un solo archivo de excel por lo que se usa la misma estrategia que en los catálogos de CFDI.

Algunos nombres de las hojas contienen espacios: `c_Estaciones`.

El catálogo `c_MaterialPeligroso` debería tener un índice único en `Clave material peligroso` pero ocurre que
contiene duplicados.

Por lo anterior, solo existe un importador con múltiples inyectores.

## RET 2.0 (CFDI De Retenciones e Información de Pagos) `ret_20_*`
> - <http://omawww.sat.gob.mx/tramitesyservicios/Paginas/CFDI_retenciones.htm>

El conjunto de catálogos de RET 2.0 es totalmente independiente del conjunto de CFDI, son fuentes y archivos XLS 
distintos, no obstante el esquema XSD de RET 2.0 (hasta esta fecha) hace uso de los catálogos de 
[CFDI 3.3](http://www.sat.gob.mx/sitio_internet/cfd/catalogos/catCFDI.xsd)
y [RET 1.0](http://www.sat.gob.mx/esquemas/retencionpago/1/catalogos/catRetenciones.xsd)

Los catálogos están en un solo archivo de excel por lo que se usa la misma estrategia que en los catálogos de CFDI.

El catálogo `ret_20_ejercicios` es el único que no contiene algún valor en el campo descripción o texto.