<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Injectors;

class HidroPretro10Catalogs extends AbstractXlsxImporter
{
    public function createInjectors(string $csvFolder): Injectors
    {
        return new Injectors([
            new HidroPretro10\Injectors\TiposPermiso($csvFolder . '/c_TipoPermiso.csv'),
            new HidroPretro10\Injectors\ClavesHyp($csvFolder . '/c_ClaveHYP.csv'),
            new HidroPretro10\Injectors\SubproductosHyp($csvFolder . '/c_SubProductoHYP.csv'),
        ]);
    }
}
