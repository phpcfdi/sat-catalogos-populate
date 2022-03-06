<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\PaddingDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class Colonias extends AbstractCsvInjector
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = ['c_Colonia', 'c_CodigoPostal', 'Nombre del asentamiento'];
        $headers = $csv->readLine();

        if ($expected !== $headers) {
            throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
        }

        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable('ccp_20_colonias', new DataFields([
            new PaddingDataField('colonia', '0', 4),
            new PaddingDataField('codigo_postal', '0', 5),
            new TextDataField('texto'),
        ]), ['colonia', 'codigo_postal']);
    }
}
