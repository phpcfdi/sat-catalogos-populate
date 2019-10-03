<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\BoolDataField;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class CodigosPostales extends AbstractCsvInjector
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expectedLines = [
            [
                'c_CodigoPostal',
                'c_Estado',
                'c_Municipio',
                'c_Localidad',
                'Estímulo Franja Fronteriza',
                'Fecha inicio de vigencia del estímulo',
                'Fecha fin de vigencia del estímulo',
                'Referencias del Huso Horario',
            ],
            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Descripción del Huso Horario',
                'Mes_Inicio_Horario_Verano',
                'Día_Inicio_Horario_Verano',
                'Día_Inicio_Horario_Verano',
                'Diferencia_Horaria_Verano',
                'Mes_Inicio_Horario_Invierno',
                'Día_Inicio_Horario_Invierno',
                'Día_Inicio_Horario_Invierno',
                'Diferencia_Horaria_Invierno'
            ]
        ];
        foreach ($expectedLines as $line => $expected) {
            $line = $line + 1;
            $headers = $csv->readLine();
            if ($expected !== $headers) {
                throw new RuntimeException("The headers did not match on file {$this->sourceFile()} line {$line}");
            }
            $csv->next();
        }
    }

    public function dataTable(): DataTable
    {
        return new DataTable('cfdi_codigos_postales', new DataFields([
            new TextDataField('id'),
            new TextDataField('estado'),
            new TextDataField('municipio'),
            new TextDataField('localidad'),
            new BoolDataField('estimulo_frontera', ['1']),
            new DateDataField('estimulo_vigencia_desde'),
            new DateDataField('estimulo_vigencia_hasta'),
            new TextDataField('huso_descripcion'),
            new TextDataField('huso_verano_mes_inicio'),
            new TextDataField('huso_verano_dia_inicio'),
            new TextDataField('huso_verano_hora_inicio'),
            new TextDataField('huso_verano_diferencia'),
            new TextDataField('huso_invierno_mes_inicio'),
            new TextDataField('huso_invierno_dia_inicio'),
            new TextDataField('huso_invierno_hora_inicio'),
            new TextDataField('huso_invierno_diferencia'),
        ]));
    }

    protected function readLinesFromCsv(CsvFile $csv)
    {
        foreach ($csv->readLines() as $line) {
            if ('00000' === $line[0]) {
                continue;
            }

            yield $line;
        }
    }
}
