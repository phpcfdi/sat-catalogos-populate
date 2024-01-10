<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cce20;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;

class CceTipoOperacion extends AbstractXlsOneSheetImporter
{
    public function sheetName(): string
    {
        return 'c_TipoOperacion';
    }

    public function createInjector(string $csvFile): InjectorInterface
    {
        return new Injectors\TiposOperacion($csvFile);
    }
}
