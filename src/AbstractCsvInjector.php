<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate;

use Generator;
use Iterator;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DataTableGateway;
use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\RightTrim;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use Psr\Log\LoggerInterface;
use RuntimeException;

abstract class AbstractCsvInjector implements InjectorInterface
{
    private string $sourceFile;

    abstract public function checkHeaders(CsvFile $csv): void;

    abstract public function dataTable(): DataTable;

    public function __construct(string $sourceFile)
    {
        $this->sourceFile = $sourceFile;
    }

    public function sourceFile(): string
    {
        return $this->sourceFile;
    }

    public function validate(): void
    {
        if (! file_exists($this->sourceFile) || is_dir($this->sourceFile) || ! is_readable($this->sourceFile)) {
            throw new RuntimeException("El archivo $this->sourceFile no existe o es un directorio o no se puede leer");
        }
    }

    public function inject(Repository $repository, LoggerInterface $logger): int
    {
        $tableName = $this->dataTable()->name();
        $filename = basename($this->sourceFile);

        $gateway = new DataTableGateway($this->dataTable(), $repository);
        if ($this->shouldRecreateTable()) {
            $logger->info("Creando tabla {$tableName}...");
            $gateway->recreate();
        }

        $logger->info("Verificando encabezado de {$filename}...");
        $csv = $this->createCsvFileReader();
        $this->checkHeaders($csv);

        $logger->info("Inyectando contenidos de {$filename} a {$tableName}...");
        $injected = $this->injectCsvToDataTable($csv, $gateway);
        $logger->info("Se inyectaron {$injected} registros en {$tableName}");

        return $injected;
    }

    protected function createCsvFileReader(): CsvFile
    {
        return new CsvFile($this->sourceFile(), new RightTrim());
    }

    protected function injectCsvToDataTable(CsvFile $csv, DataTableGateway $gateway): int
    {
        $inserted = 0;
        foreach ($this->readLinesFromCsv($csv) as $line) {
            $gateway->insert(
                $gateway->dataTable()->fields()->transform($line)
            );
            $inserted = $inserted + 1;
        }
        return $inserted;
    }

    /**
     * @param CsvFile $csv
     * @return Generator<int, array<int, scalar>>
     */
    protected function readLinesFromCsv(CsvFile $csv): Iterator
    {
        yield from $csv->readLines();
    }

    protected function shouldRecreateTable(): bool
    {
        return true;
    }
}
