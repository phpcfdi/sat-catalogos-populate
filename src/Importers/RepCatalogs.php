<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Injectors;

class RepCatalogs extends AbstractXlsImporter
{
    public function createInjectors(string $csvFolder): Injectors
    {
        return new Injectors([
            new Rep\Injectors\TiposCadenaPago($csvFolder . '/c_TIpoCadenaPago.csv'),
        ]);
    }
}
