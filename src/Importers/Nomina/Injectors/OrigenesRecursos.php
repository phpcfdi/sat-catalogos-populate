<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class OrigenesRecursos extends AbstractCsvInjector
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'c_OrigenRecurso',
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
        return new DataTable('nomina_origenes_recursos', new DataFields([
            new TextDataField('id'),
            new TextDataField('texto'),
        ]));
    }
}
