<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cce;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;

class CceUnidadAduana extends AbstractXlsOneSheetImporter
{
    public function sheetName(): string
    {
        return 'c_UnidadAduana';
    }

    public function createInjector(string $csvFile): InjectorInterface
    {
        return new Injectors\UnidadesAduana($csvFile);
    }
}
