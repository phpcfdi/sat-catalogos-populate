<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Injectors;

class NominaCatalogs extends AbstractXlsImporter
{
    public function createInjectors(string $csvFolder): Injectors
    {
        return new Injectors([
            new Nomina\Injectors\Bancos($csvFolder . '/c_Banco.csv'),
            new Nomina\Injectors\OrigenesRecursos($csvFolder . '/c_OrigenRecurso.csv'),
            new Nomina\Injectors\PeriodicidadesPagos($csvFolder . '/c_PeriodicidadPago.csv'),
            new Nomina\Injectors\TiposContratos($csvFolder . '/c_TipoContrato.csv'),
            new Nomina\Injectors\TiposDeducciones($csvFolder . '/c_TipoDeduccion.csv'),
            new Nomina\Injectors\TiposHoras($csvFolder . '/c_TipoHoras.csv'),
            new Nomina\Injectors\TiposIncapacidades($csvFolder . '/c_TipoIncapacidad.csv'),
            new Nomina\Injectors\TiposJornadas($csvFolder . '/c_TipoJornada.csv'),
            new Nomina\Injectors\TiposNominas($csvFolder . '/c_TipoNomina.csv'),
            new Nomina\Injectors\TiposOtrosPagos($csvFolder . '/c_TipoOtroPago.csv'),
            new Nomina\Injectors\TiposPercepciones($csvFolder . '/c_TipoPercepcion.csv'),
            new Nomina\Injectors\TiposRegimenes($csvFolder . '/c_TipoRegimen.csv'),
            new Nomina\Injectors\RiesgosPuestos($csvFolder . '/c_RiesgoPuesto.csv'),
        ]);
    }
}
