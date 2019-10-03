<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cce;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;

class CceFraccionArancelaria extends AbstractXlsOneSheetImporter
{
    public function sheetName(): string
    {
        return 'c_FraccionArancelaria';
    }

    public function createInjector(string $csvFile): InjectorInterface
    {
        return new Injectors\FraccionesArancelarias($csvFile);
    }
}
