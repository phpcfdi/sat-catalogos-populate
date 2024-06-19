<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Injectors;

class Ccp31Catalogs extends AbstractXlsImporter
{
    public function createInjectors(string $csvFolder): Injectors
    {
        return new Injectors([
            new Ccp31\Injectors\AutorizacionesNaviero($csvFolder . '/c_NumAutorizacionNaviero.csv'),
            new Ccp31\Injectors\ClavesUnidades($csvFolder . '/c_ClaveUnidadPeso.csv'),
            new Ccp31\Injectors\CodigosTransporteAereo($csvFolder . '/c_CodigoTransporteAereo.csv'),
            new Ccp31\Injectors\Colonias($csvFolder . '/c_Colonia.csv'),
            new Ccp31\Injectors\CondicionesEspeciales($csvFolder . '/c_CondicionesEspeciales.csv'),
            new Ccp31\Injectors\ConfiguracionesAutotransporte($csvFolder . '/c_ConfigAutotransporte.csv'),
            new Ccp31\Injectors\ConfiguracionesMaritimas($csvFolder . '/c_ConfigMaritima.csv'),
            new Ccp31\Injectors\Contenedores($csvFolder . '/c_Contenedor.csv'),
            new Ccp31\Injectors\ContenedoresMaritimos($csvFolder . '/c_ContenedorMaritimo.csv'),
            new Ccp31\Injectors\DerechosDePaso($csvFolder . '/c_DerechosDePaso.csv'),
            new Ccp31\Injectors\DocumentosAduaneros($csvFolder . '/c_DocumentoAduanero.csv'),
            new Ccp31\Injectors\Estaciones($csvFolder . '/c_Estaciones.csv'),
            new Ccp31\Injectors\FigurasTransporte($csvFolder . '/c_FiguraTransporte.csv'),
            new Ccp31\Injectors\FormasFarmaceuticas($csvFolder . '/c_FormaFarmaceutica.csv'),
            new Ccp31\Injectors\Localidades($csvFolder . '/c_Localidad.csv'),
            new Ccp31\Injectors\MaterialesPeligrosos($csvFolder . '/c_MaterialPeligroso.csv'),
            new Ccp31\Injectors\Municipios($csvFolder . '/c_Municipio.csv'),
            new Ccp31\Injectors\PartesTransporte($csvFolder . '/c_ParteTransporte.csv'),
            new Ccp31\Injectors\ProductosServicios($csvFolder . '/c_ClaveProdServCP.csv'),
            new Ccp31\Injectors\RegimenesAduaneros($csvFolder . '/c_RegimenAduanero.csv'),
            new Ccp31\Injectors\RegistrosIstmo($csvFolder . '/c_RegistroISTMO.csv'),
            new Ccp31\Injectors\SectoresCofepris($csvFolder . '/c_SectorCOFEPRIS.csv'),
            new Ccp31\Injectors\TiposCarga($csvFolder . '/c_ClaveTipoCarga.csv'),
            new Ccp31\Injectors\TiposCarro($csvFolder . '/c_TipoCarro.csv'),
            new Ccp31\Injectors\TiposEmbalaje($csvFolder . '/c_TipoEmbalaje.csv'),
            new Ccp31\Injectors\TiposEstacion($csvFolder . '/c_TipoEstacion.csv'),
            new Ccp31\Injectors\TiposMateria($csvFolder . '/c_TipoMateria.csv'),
            new Ccp31\Injectors\TiposPermiso($csvFolder . '/c_TipoPermiso.csv'),
            new Ccp31\Injectors\TiposRemolque($csvFolder . '/c_SubTipoRem.csv'),
            new Ccp31\Injectors\TiposServicio($csvFolder . '/c_TipoDeServicio.csv'),
            new Ccp31\Injectors\TiposTrafico($csvFolder . '/c_TipoDeTrafico.csv'),
            new Ccp31\Injectors\Transportes($csvFolder . '/c_CveTransporte.csv'),
        ]);
    }
}
