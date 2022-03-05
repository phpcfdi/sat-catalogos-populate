<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\IntegerDataField;
use PhpCfdi\SatCatalogosPopulate\Database\PaddingDataField;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

use function PhpCfdi\SatCatalogosPopulate\Utils\array_rtrim;

class NumerosPedimentoAduana extends AbstractCsvInjector implements InjectorInterface
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'c_Aduana',
            'Patente',
            'Ejercicio',
            'Cantidad',
            'Fecha inicio de vigencia',
            'Fecha fin de vigencia',
        ];
        $headers = array_rtrim($csv->readLine());

        if ($expected !== $headers) {
            throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
        }

        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable(
            'cfdi_40_numeros_pedimento_aduana',
            new DataFields([
                new PaddingDataField('aduana', '0', 2),
                new PaddingDataField('patente', '0', 4),
                new IntegerDataField('ejercicio'),
                new IntegerDataField('cantidad'),
                new DateDataField('vigencia_desde'),
                new DateDataField('vigencia_hasta'),
            ]),
            [],
            true
        );
    }
}
