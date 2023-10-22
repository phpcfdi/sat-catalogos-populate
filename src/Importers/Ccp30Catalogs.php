<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Injectors;

class Ccp30Catalogs extends AbstractXlsImporter
{
    public function createInjectors(string $csvFolder): Injectors
    {
        return new Injectors([
            new Ccp30\Injectors\AutorizacionesNaviero($csvFolder . '/c_NumAutorizacionNaviero.csv'),
            new Ccp30\Injectors\ClavesUnidades($csvFolder . '/c_ClaveUnidadPeso.csv'),
            new Ccp30\Injectors\CodigosTransporteAereo($csvFolder . '/c_CodigoTransporteAereo.csv'),
            new Ccp30\Injectors\Colonias($csvFolder . '/c_Colonia.csv'),
            new Ccp30\Injectors\CondicionesEspeciales($csvFolder . '/c_CondicionesEspeciales.csv'),
            new Ccp30\Injectors\ConfiguracionesAutotransporte($csvFolder . '/c_ConfigAutotransporte.csv'),
            new Ccp30\Injectors\ConfiguracionesMaritimas($csvFolder . '/c_ConfigMaritima.csv'),
            new Ccp30\Injectors\Contenedores($csvFolder . '/c_Contenedor.csv'),
            new Ccp30\Injectors\ContenedoresMaritimos($csvFolder . '/c_ContenedorMaritimo.csv'),
            new Ccp30\Injectors\DerechosDePaso($csvFolder . '/c_DerechosDePaso.csv'),
            new Ccp30\Injectors\DocumentosAduaneros($csvFolder . '/c_DocumentoAduanero.csv'),
            new Ccp30\Injectors\Estaciones($csvFolder . '/c_Estaciones.csv'),
            new Ccp30\Injectors\FigurasTransporte($csvFolder . '/c_FiguraTransporte.csv'),
            new Ccp30\Injectors\FormasFarmaceuticas($csvFolder . '/c_FormaFarmaceutica.csv'),
            new Ccp30\Injectors\Localidades($csvFolder . '/c_Localidad.csv'),
            new Ccp30\Injectors\MaterialesPeligrosos($csvFolder . '/c_MaterialPeligroso.csv'),
            new Ccp30\Injectors\Municipios($csvFolder . '/c_Municipio.csv'),
            new Ccp30\Injectors\PartesTransporte($csvFolder . '/c_ParteTransporte.csv'),
            new Ccp30\Injectors\ProductosServicios($csvFolder . '/c_ClaveProdServCP.csv'),
            new Ccp30\Injectors\RegimenesAduaneros($csvFolder . '/c_RegimenAduanero.csv'),
            new Ccp30\Injectors\RegistrosIstmo($csvFolder . '/c_RegistroISTMO.csv'),
            new Ccp30\Injectors\SectoresCofepris($csvFolder . '/c_SectorCOFEPRIS.csv'),
            new Ccp30\Injectors\TiposCarga($csvFolder . '/c_ClaveTipoCarga.csv'),
            new Ccp30\Injectors\TiposCarro($csvFolder . '/c_TipoCarro.csv'),
            new Ccp30\Injectors\TiposEmbalaje($csvFolder . '/c_TipoEmbalaje.csv'),
            new Ccp30\Injectors\TiposEstacion($csvFolder . '/c_TipoEstacion.csv'),
            new Ccp30\Injectors\TiposMateria($csvFolder . '/c_TipoMateria.csv'),
            new Ccp30\Injectors\TiposPermiso($csvFolder . '/c_TipoPermiso.csv'),
            new Ccp30\Injectors\TiposRemolque($csvFolder . '/c_SubTipoRem.csv'),
            new Ccp30\Injectors\TiposServicio($csvFolder . '/c_TipoDeServicio.csv'),
            new Ccp30\Injectors\TiposTrafico($csvFolder . '/c_TipoDeTrafico.csv'),
            new Ccp30\Injectors\Transportes($csvFolder . '/c_CveTransporte.csv'),
        ]);
    }
}
