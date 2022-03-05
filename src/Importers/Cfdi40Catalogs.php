<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Injectors;

class Cfdi40Catalogs extends AbstractXlsImporter
{
    public function createInjectors(string $csvFolder): Injectors
    {
        return new Injectors([
            new Cfdi40\Injectors\Aduanas($csvFolder . '/c_Aduana.csv'),
            new Cfdi40\Injectors\ClavesUnidades($csvFolder . '/c_ClaveUnidad.csv'),
            new Cfdi40\Injectors\CodigosPostales($csvFolder . '/c_CodigoPostal.csv'),
            new Cfdi40\Injectors\Colonias($csvFolder . '/C_Colonia.csv'),
            new Cfdi40\Injectors\Estados($csvFolder . '/c_Estado.csv'),
            new Cfdi40\Injectors\Exportaciones($csvFolder . '/c_Exportacion.csv'),
            new Cfdi40\Injectors\FormasDePago($csvFolder . '/c_FormaPago.csv'),
            new Cfdi40\Injectors\Impuestos($csvFolder . '/c_Impuesto.csv'),
            new Cfdi40\Injectors\Localidades($csvFolder . '/C_Localidad.csv'),
            new Cfdi40\Injectors\Meses($csvFolder . '/c_Meses.csv'),
            new Cfdi40\Injectors\MetodosDePago($csvFolder . '/c_MetodoPago.csv'),
            new Cfdi40\Injectors\Monedas($csvFolder . '/c_Moneda.csv'),
            new Cfdi40\Injectors\Municipios($csvFolder . '/C_Municipio.csv'),
            new Cfdi40\Injectors\NumerosPedimentoAduana($csvFolder . '/c_NumPedimentoAduana.csv'),
            new Cfdi40\Injectors\ObjetosDeImpuestos($csvFolder . '/c_ObjetoImp.csv'),
            new Cfdi40\Injectors\Paises($csvFolder . '/c_Pais.csv'),
            new Cfdi40\Injectors\PatentesAduanales($csvFolder . '/c_PatenteAduanal.csv'),
            new Cfdi40\Injectors\Periodicidades($csvFolder . '/c_Periodicidad.csv'),
            new Cfdi40\Injectors\ProductosServicios($csvFolder . '/c_ClaveProdServ.csv'),
            new Cfdi40\Injectors\RegimenesFiscales($csvFolder . '/c_RegimenFiscal.csv'),
            new Cfdi40\Injectors\ReglasTasaCuota($csvFolder . '/c_TasaOCuota.csv'),
            new Cfdi40\Injectors\TiposComprobantes($csvFolder . '/c_TipoDeComprobante.csv'),
            new Cfdi40\Injectors\TiposFactores($csvFolder . '/c_TipoFactor.csv'),
            new Cfdi40\Injectors\TiposRelaciones($csvFolder . '/c_TipoRelacion.csv'),
            new Cfdi40\Injectors\UsosCfdi($csvFolder . '/c_UsoCFDI.csv'),
        ]);
    }
}
