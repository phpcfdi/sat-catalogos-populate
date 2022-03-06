<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class TiposServicio extends AbstractCsvInjector
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'Clave',
            'Descripción',
            'Contenedor',
            'Fecha de inicio de vigencia',
            'Fecha de fin de vigencia',
        ];
        $headers = $csv->readLine();

        if ($expected !== $headers) {
            throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
        }
        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable('ccp_20_tipos_servicio', new DataFields([
            new TextDataField('id'),
            new TextDataField('texto'),
            new TextDataField('contenedor'),
            new DateDataField('vigencia_desde'),
            new DateDataField('vigencia_hasta'),
        ]));
    }
}
