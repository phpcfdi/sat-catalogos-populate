<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Ccp31\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class ClavesUnidades extends AbstractCsvInjector
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'Clave unidad',
            'Nombre',
            'Descripción',
            'Nota',
            'Fecha de inicio de vigencia',
            'Fecha de fin de vigencia',
            'Símbolo',
            'Bandera',
        ];
        $headers = $csv->readLine();

        if ($expected !== $headers) {
            throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
        }

        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable('ccp_31_claves_unidades', new DataFields([
            new TextDataField('id'),
            new TextDataField('texto'),
            new TextDataField('descripcion'),
            new TextDataField('nota'),
            new DateDataField('vigencia_desde'),
            new DateDataField('vigencia_hasta'),
            new TextDataField('simbolo'),
            new TextDataField('bandera'),
        ]));
    }
}
