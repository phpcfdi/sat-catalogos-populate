<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\PaddingDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

use function PhpCfdi\SatCatalogosPopulate\Utils\array_rtrim;

class ClavesUnidades extends AbstractCsvInjector implements InjectorInterface
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'c_ClaveUnidad',
            'Nombre',
            'Descripción',
            'Nota',
            'Fecha de inicio de vigencia',
            'Fecha de fin de vigencia',
            'Símbolo',
        ];
        $headers = array_rtrim($csv->readLine());

        if ($expected !== $headers) {
            throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
        }

        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable('cfdi_40_claves_unidades', new DataFields([
            new PaddingDataField('id', '0', 2),
            new TextDataField('texto'),
            new TextDataField('descripcion'),
            new TextDataField('notas'),
            new DateDataField('vigencia_desde'),
            new DateDataField('vigencia_hasta'),
            new TextDataField('simbolo'),
        ]));
    }
}
