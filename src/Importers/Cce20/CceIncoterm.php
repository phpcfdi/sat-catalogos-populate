<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cce20;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;

class CceIncoterm extends AbstractXlsOneSheetImporter
{
    public function sheetName(): string
    {
        return 'c_INCOTERM';
    }

    public function createInjector(string $csvFile): InjectorInterface
    {
        return new Injectors\Incoterms($csvFile);
    }
}
