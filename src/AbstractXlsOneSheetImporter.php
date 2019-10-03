<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate;

use PhpCfdi\SatCatalogosPopulate\Converters\XlsToCsvFolderConverter;
use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use function PhpCfdi\SatCatalogosPopulate\Utils\tempdir;
use Psr\Log\LoggerInterface;

abstract class AbstractXlsOneSheetImporter implements ImporterInterface
{
    abstract public function sheetName(): string;

    abstract public function createInjector(string $csvFile): InjectorInterface;

    public function import(string $source, Repository $repository, LoggerInterface $logger): void
    {
        $csvFolder = tempdir();
        $csvFile = $csvFolder . '/' . $this->sheetName() . '.csv';

        try {
            // convert xls to csv
            $logger->info("Convirtiendo XLS $source a CSV en $csvFolder ...");
            $converter = new XlsToCsvFolderConverter();
            $converter->convert($source, $csvFolder);

            // create injector
            $injector = $this->createInjector($csvFile);
            $injector->validate();

            $logger->info("Inyectando contenidos de {$this->sheetName()} ...");
            $injector->inject($repository, $logger);
        } finally {
            // remove files after import (fail or correct)
            $this->removeCsvFolder($csvFolder);
        }
    }

    protected function removeCsvFolder(string $csvFolder): void
    {
        array_map('unlink', glob($csvFolder . '/*.csv'));
        rmdir($csvFolder);
    }
}
