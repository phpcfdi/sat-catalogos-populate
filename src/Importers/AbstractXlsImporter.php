<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers;

use PhpCfdi\SatCatalogosPopulate\Converters\XlsToCsvFolderConverter;
use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\ImporterInterface;
use PhpCfdi\SatCatalogosPopulate\Injectors;
use Psr\Log\LoggerInterface;

use function PhpCfdi\SatCatalogosPopulate\Utils\tempdir;

abstract class AbstractXlsImporter implements ImporterInterface
{
    abstract public function createInjectors(string $csvFolder): Injectors;

    public function import(string $source, Repository $repository, LoggerInterface $logger): void
    {
        $csvFolder = tempdir();

        try {
            // convert from xls to csv files
            $logger->info("Convirtiendo a archivos CSV de {$source} a {$csvFolder}...");
            $converter = $this->createConverter();
            $converter->convert($source, $csvFolder);

            // create the injector (use a collection)
            $injector = $this->createInjectors($csvFolder);
            $injector->validate();

            // inject
            $injector->inject($repository, $logger);
        } finally {
            // remove files after import (fail or correct)
            $this->removeCsvFolder($csvFolder);
        }
    }

    protected function removeCsvFolder(string $csvFolder): void
    {
        array_map('unlink', glob($csvFolder . '/*.csv') ?: []);
        rmdir($csvFolder);
    }

    protected function createConverter(): XlsToCsvFolderConverter
    {
        return new XlsToCsvFolderConverter();
    }
}
