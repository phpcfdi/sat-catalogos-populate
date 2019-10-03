<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Fixtures;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;

class FakeXlsOneSheetInjector extends AbstractCsvInjector
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(1);
        $headers = ['id', 'description'];
        $retrieved = $csv->readLine();
        if ($headers !== $retrieved) {
            throw new \RuntimeException("Headers don't match");
        }
        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable('foo', new DataFields([
            new TextDataField('id'),
            new TextDataField('description'),
        ]));
    }
}
