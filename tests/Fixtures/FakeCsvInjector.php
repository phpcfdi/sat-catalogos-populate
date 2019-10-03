<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Fixtures;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\IntegerDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class FakeCsvInjector extends AbstractCsvInjector
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(0);
        $headers = ['id', 'name', 'description', 'date'];
        $retrieved = $csv->readLine();
        if ($headers !== $retrieved) {
            throw new RuntimeException("Headers don't match");
        }
        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable('sample', new DataFields([
            new IntegerDataField('id'),
            new TextDataField('name'),
            new TextDataField('description'),
            new DateDataField('date'),
        ]));
    }
}
