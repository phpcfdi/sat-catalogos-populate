<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Injectors;

class Ret20Catalogs extends AbstractXlsImporter
{
    public function createInjectors(string $csvFolder): Injectors
    {
        return new Injectors([
            new Ret20\Injectors\ClavesRetencion($csvFolder . '/c_CveRetenc.csv'),
            new Ret20\Injectors\Ejercicios($csvFolder . '/c_Ejercicio.csv'),
            new Ret20\Injectors\EntidadesFederativas($csvFolder . '/c_EntidadesFederativas.csv'),
            new Ret20\Injectors\Paises($csvFolder . '/c_Pais.csv'),
            new Ret20\Injectors\Periodicidades($csvFolder . '/c_Periodicidad.csv'),
            new Ret20\Injectors\Periodos($csvFolder . '/c_Periodo.csv'),
            new Ret20\Injectors\TiposContribuyentes($csvFolder . '/c_TipoContribuyenteSujetoRetenc.csv'),
            new Ret20\Injectors\TiposDividendosUtilidades($csvFolder . '/c_TipoDividendoOUtilidadDistrib.csv'),
            new Ret20\Injectors\TiposImpuestos($csvFolder . '/c_TipoImpuesto.csv'),
            new Ret20\Injectors\TiposPagoRetencion($csvFolder . '/c_TipoPagoRet.csv'),
        ]);
    }
}
