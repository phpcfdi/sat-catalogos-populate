<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Injectors;

class Ccp20Catalogs extends AbstractXlsImporter
{
    public function createInjectors(string $csvFolder): Injectors
    {
        return new Injectors([
            new Ccp20\Injectors\AutorizacionesNaviero($csvFolder . '/c_NumAutorizacionNaviero.csv'),
            new Ccp20\Injectors\ClavesUnidades($csvFolder . '/c_ClaveUnidadPeso.csv'),
            new Ccp20\Injectors\CodigosTransporteAereo($csvFolder . '/c_CodigoTransporteAereo.csv'),
            new Ccp20\Injectors\Colonias($csvFolder . '/c_Colonia.csv'),
            new Ccp20\Injectors\ConfiguracionesAutotransporte($csvFolder . '/c_ConfigAutotransporte.csv'),
            new Ccp20\Injectors\ConfiguracionesMaritimas($csvFolder . '/c_ConfigMaritima.csv'),
            new Ccp20\Injectors\ContenedoresMaritimos($csvFolder . '/c_ContenedorMaritimo.csv'),
            new Ccp20\Injectors\Estaciones($csvFolder . '/c_Estaciones.csv'),
            new Ccp20\Injectors\FigurasTransporte($csvFolder . '/c_FiguraTransporte.csv'),
            new Ccp20\Injectors\Localidades($csvFolder . '/c_Localidad.csv'),
            new Ccp20\Injectors\MaterialesPeligrosos($csvFolder . '/c_MaterialPeligroso.csv'),
            new Ccp20\Injectors\Municipios($csvFolder . '/c_Municipio.csv'),
            new Ccp20\Injectors\PartesTransporte($csvFolder . '/c_ParteTransporte.csv'),
            new Ccp20\Injectors\ProductosServicios($csvFolder . '/c_ClaveProdServCP.csv'),
            new Ccp20\Injectors\TiposCarga($csvFolder . '/c_ClaveTipoCarga.csv'),
            new Ccp20\Injectors\TiposEmbalaje($csvFolder . '/c_TipoEmbalaje.csv'),
            new Ccp20\Injectors\TiposEstacion($csvFolder . '/c_TipoEstacion.csv'),
            new Ccp20\Injectors\TiposPermiso($csvFolder . '/c_TipoPermiso.csv'),
            new Ccp20\Injectors\TiposRemolque($csvFolder . '/c_SubTipoRem.csv'),
            new Ccp20\Injectors\Transportes($csvFolder . '/c_CveTransporte.csv'),
            new Ccp20\Injectors\TiposTrafico($csvFolder . '/c_TipoDeTrafico.csv'),
            new Ccp20\Injectors\TiposServicio($csvFolder . '/c_TipoDeServicio.csv'),
            new Ccp20\Injectors\TiposCarro($csvFolder . '/c_TipoCarro.csv'),
            new Ccp20\Injectors\DerechosDePaso($csvFolder . '/c_DerechosDePaso.csv'),
            new Ccp20\Injectors\Contenedores($csvFolder . '/c_Contenedor.csv'),
        ]);
    }
}
