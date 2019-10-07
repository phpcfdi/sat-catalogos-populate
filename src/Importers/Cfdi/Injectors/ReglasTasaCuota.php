<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\BoolDataField;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\NumberFormatDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class ReglasTasaCuota extends AbstractCsvInjector implements InjectorInterface
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expectedLines = [
            [
                'Rango o Fijo',
                'c_TasaOCuota',
                '',
                'Impuesto',
                'Factor',
                'Traslado',
                'Retención',
                'Fecha inicio de vigencia',
                'Fecha fin de vigencia',
            ],
            [
                '',
                'Valor mínimo',
                'Valor máximo',
            ],
        ];

        foreach ($expectedLines as $expected) {
            $headers = $csv->readLine();

            if ($expected !== $headers) {
                throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
            }
            $csv->next();
        }
    }

    public function dataTable(): DataTable
    {
        return new DataTable(
            'cfdi_reglas_tasa_cuota',
            new DataFields([
                new TextDataField('tipo'),
                new NumberFormatDataField('minimo', 6),
                new NumberFormatDataField('valor', 6),
                new TextDataField('impuesto'),
                new TextDataField('factor'),
                new BoolDataField('traslado', ['Sí']),
                new BoolDataField('retencion', ['Sí']),
                new DateDataField('vigencia_desde'),
                new DateDataField('vigencia_hasta'),
            ]),
            [],
            true
        );
    }
}
