<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Injectors;

class CfdiCatalogs extends AbstractXlsImporter
{
    public function createInjectors(string $csvFolder): Injectors
    {
        return new Injectors([
            new Cfdi\Injectors\Aduanas($csvFolder . '/c_Aduana.csv'),
            new Cfdi\Injectors\ProductosServicios($csvFolder . '/c_ClaveProdServ.csv'),
            new Cfdi\Injectors\ClavesUnidades($csvFolder . '/c_ClaveUnidad.csv'),
            new Cfdi\Injectors\CodigosPostales($csvFolder . '/c_CodigoPostal.csv'),
            new Cfdi\Injectors\FormasDePago($csvFolder . '/c_FormaPago.csv'),
            new Cfdi\Injectors\Impuestos($csvFolder . '/c_Impuesto.csv'),
            new Cfdi\Injectors\MetodosDePago($csvFolder . '/c_MetodoPago.csv'),
            new Cfdi\Injectors\Monedas($csvFolder . '/c_Moneda.csv'),
            new Cfdi\Injectors\Paises($csvFolder . '/c_Pais.csv'),
            new Cfdi\Injectors\PatentesAduanales($csvFolder . '/c_PatenteAduanal.csv'),
            new Cfdi\Injectors\RegimenesFiscales($csvFolder . '/c_RegimenFiscal.csv'),
            new Cfdi\Injectors\TiposComprobantes($csvFolder . '/c_TipoDeComprobante.csv'),
            new Cfdi\Injectors\TiposFactores($csvFolder . '/c_TipoFactor.csv'),
            new Cfdi\Injectors\TiposRelaciones($csvFolder . '/c_TipoRelacion.csv'),
            new Cfdi\Injectors\UsosCfdi($csvFolder . '/c_UsoCFDI.csv'),
            new Cfdi\Injectors\NumerosPedimentoAduana($csvFolder . '/c_NumPedimentoAduana.csv'),
            new Cfdi\Injectors\ReglasTasaCuota($csvFolder . '/c_TasaOCuota.csv'),
        ]);
    }
}
