<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\BoolDataField;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

use function PhpCfdi\SatCatalogosPopulate\Utils\array_rtrim;

class RegimenesFiscales extends AbstractCsvInjector implements InjectorInterface
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(4);
        $expected = [
            'c_RegimenFiscal',
            'Descripción',
            'Física',
            'Moral',
            'Fecha de inicio de vigencia',
            'Fecha de fin de vigencia',
        ];
        $headers = array_rtrim($csv->readLine());

        if ($expected !== $headers) {
            throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
        }

        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable('cfdi_40_regimenes_fiscales', new DataFields([
            new TextDataField('id'),
            new TextDataField('texto'),
            new BoolDataField('aplica_fisica', ['Sí']),
            new BoolDataField('aplica_moral', ['Sí']),
            new DateDataField('vigencia_desde'),
            new DateDataField('vigencia_hasta'),
        ]));
    }
}
