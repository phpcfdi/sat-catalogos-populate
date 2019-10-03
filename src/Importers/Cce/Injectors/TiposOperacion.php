<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class TiposOperacion extends AbstractCsvInjector
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'c_TipoOperacion',
            'Descripción',
        ];
        $headers = $csv->readLine();

        if ($expected !== $headers) {
            throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
        }

        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable('cce_tipos_operacion', new DataFields([
            new TextDataField('id'),
            new TextDataField('texto'),
        ]));
    }
}
