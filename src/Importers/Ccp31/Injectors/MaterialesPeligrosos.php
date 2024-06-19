<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Ccp31\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\PaddingDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class MaterialesPeligrosos extends AbstractCsvInjector
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'Clave material peligroso',
            'Descripción',
            'Clase o div.',
            'Peligro \nsecundario',
            'Nombre técnico',
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
        return new DataTable('ccp_31_materiales_peligrosos', new DataFields([
            new PaddingDataField('id', '0', 4),
            new TextDataField('texto'),
            new TextDataField('clase_o_div'),
            new TextDataField('peligro_secundario'),
            new TextDataField('nombre_tecnico'),
            new DateDataField('vigencia_desde'),
            new DateDataField('vigencia_hasta'),
        ]), [], true);
    }
}
