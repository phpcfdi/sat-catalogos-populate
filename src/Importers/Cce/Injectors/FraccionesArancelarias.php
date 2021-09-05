<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\PaddingDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\RightTrim;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class FraccionesArancelarias extends AbstractCsvInjector
{
    /** @var bool Indicates if the injector must recreate the table */
    private bool $shouldRecreateTable;

    public function __construct(string $sourceFile, bool $shouldRecreateTable)
    {
        parent::__construct($sourceFile);
        $this->shouldRecreateTable = $shouldRecreateTable;
    }

    protected function createCsvFileReader(): CsvFile
    {
        return new CsvFile($this->sourceFile(), new RightTrim());
    }

    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'c_FraccionArancelaria',
            'Descripción',
            'Fecha de inicio de vigencia',
            'Fecha de fin de vigencia',
            'UMT',
        ];
        $headers = $csv->readLine();

        if ($expected !== $headers) {
            throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
        }

        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable('cce_fracciones_arancelarias', new DataFields([
            new TextDataField('fraccion'),
            new TextDataField('texto'),
            new DateDataField('vigencia_desde'),
            new DateDataField('vigencia_hasta'),
            new PaddingDataField('unidad', '0', 2),
        ]));
    }

    protected function shouldRecreateTable(): bool
    {
        return $this->shouldRecreateTable;
    }
}
