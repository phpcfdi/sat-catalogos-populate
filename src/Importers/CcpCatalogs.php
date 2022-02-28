<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Injectors;

class CcpCatalogs extends AbstractXlsImporter
{
    public function createInjectors(string $csvFolder): Injectors
    {
        return new Injectors([
            new Ccp\Injectors\AutorizacionesNaviero($csvFolder . '/c_NumAutorizacionNaviero.csv'),
            new Ccp\Injectors\ClavesUnidades($csvFolder . '/c_ClaveUnidadPeso.csv'),
            new Ccp\Injectors\CodigosTransporteAereo($csvFolder . '/c_CodigoTransporteAereo.csv'),
            new Ccp\Injectors\Colonias($csvFolder . '/c_Colonia.csv'),
            new Ccp\Injectors\ConfiguracionesAutotransporte($csvFolder . '/c_ConfigAutotransporte.csv'),
            new Ccp\Injectors\ConfiguracionesMaritimas($csvFolder . '/c_ConfigMaritima.csv'),
            new Ccp\Injectors\ContenedoresMaritimos($csvFolder . '/c_ContenedorMaritimo.csv'),
            new Ccp\Injectors\Estaciones($csvFolder . '/c_Estaciones .csv'),
            new Ccp\Injectors\FigurasTransporte($csvFolder . '/c_FiguraTransporte.csv'),
            new Ccp\Injectors\Localidades($csvFolder . '/c_Localidad.csv'),
            new Ccp\Injectors\MaterialesPeligrosos($csvFolder . '/c_MaterialPeligroso.csv'),
            new Ccp\Injectors\Municipios($csvFolder . '/c_Municipio.csv'),
            new Ccp\Injectors\PartesTransporte($csvFolder . '/c_ParteTransporte.csv'),
            new Ccp\Injectors\ProductosServicios($csvFolder . '/c_ClaveProdServCP.csv'),
            new Ccp\Injectors\TiposCarga($csvFolder . '/c_ClaveTipoCarga.csv'),
            new Ccp\Injectors\TiposEmbalaje($csvFolder . '/c_TipoEmbalaje.csv'),
            new Ccp\Injectors\TiposEstacion($csvFolder . '/c_TipoEstacion.csv'),
            new Ccp\Injectors\TiposPermiso($csvFolder . '/c_TipoPermiso.csv'),
            new Ccp\Injectors\TiposRemolque($csvFolder . '/ c_SubTipoRem.csv'),
            new Ccp\Injectors\Transportes($csvFolder . '/c_CveTransporte.csv'),
            new Ccp\Injectors\TiposTrafico($csvFolder . '/c_TipoDeTrafico.csv'),
            new Ccp\Injectors\TiposServicio($csvFolder . '/c_TipoDeServicio.csv'),
            new Ccp\Injectors\TiposCarro($csvFolder . '/c_TipoCarro.csv'),
            new Ccp\Injectors\DerechosDePaso($csvFolder . '/c_DerechosDePaso.csv'),
            new Ccp\Injectors\Contenedores($csvFolder . '/c_Contenedor.csv'),
        ]);
    }
}
