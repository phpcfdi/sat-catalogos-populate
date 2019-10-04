<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\PaddingDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\IgnoreColumns;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\RightTrim;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class FraccionesArancelarias extends AbstractCsvInjector
{
    protected function createCsvFileReader(): CsvFile
    {
        return new CsvFile($this->sourceFile(), new IgnoreColumns(new RightTrim(), 0));
    }

    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expectedLines = [
            [
                'c_FraccionArancelaria',
                'Descripción',
                'Fecha de inicio de vigencia',
                'Fecha de fin de vigencia',
                'Criterio',
                'Unidad de Medida',
                'IMPUESTO',
            ],
            ['', '', '', '', '', '', 'IMP', 'EXP'],
        ];

        foreach ($expectedLines as $expected) {
            $headers = $csv->readLine();

            if ($expected !== $headers) {
                throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
            }
            $csv->next();
        }

        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable('cce_fracciones_arancelarias', new DataFields([
            new PaddingDataField('fraccion', '0', 8),
            new TextDataField('texto'),
            new DateDataField('vigencia_desde'),
            new DateDataField('vigencia_hasta'),
            new TextDataField('criterio'),
            new PaddingDataField('unidad', '0', 2),
            new TextDataField('impuesto_importacion'),
            new TextDataField('impuesto_exportacion'),
        ]));
    }
}
