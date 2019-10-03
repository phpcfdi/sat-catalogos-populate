<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\PaddingDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class TiposJornadas extends AbstractCsvInjector
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'c_TipoJornada',
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
        return new DataTable('nomina_tipos_jornadas', new DataFields([
            new PaddingDataField('id', '0', 2),
            new TextDataField('texto'),
        ]));
    }
}
