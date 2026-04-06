<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Converters\ConverterInterface;
use PhpCfdi\SatCatalogosPopulate\Converters\XlsToCsvFolderConverter;
use PhpCfdi\SatCatalogosPopulate\ImporterInterface;
use PhpCfdi\SatCatalogosPopulate\Injectors;

abstract class AbstractXlsImporter extends AbstractExcelImporter implements ImporterInterface
{
    abstract public function createInjectors(string $csvFolder): Injectors;

    protected function createConverter(): ConverterInterface
    {
        return new XlsToCsvFolderConverter();
    }
}
