<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class TiposComprobantes extends AbstractCsvInjector implements InjectorInterface
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'c_TipoDeComprobante',
            'Descripción',
            'Valor máximo',
            '',
            'Fecha inicio de vigencia',
            'Fecha fin de vigencia',
        ];
        $headers = $csv->readLine();

        if ($expected !== $headers) {
            throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
        }

        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable('cfdi_tipos_comprobantes', new DataFields([
            new TextDataField('id'),
            new TextDataField('texto'),
            new TextDataField('valor_maximo'),
            new TextDataField('dummy'),
            new DateDataField('vigencia_desde'),
            new DateDataField('vigencia_hasta'),
        ]));
    }

    protected function readLinesFromCsv(CsvFile $csv)
    {
        foreach ($csv->readLines() as $line) {
            if ('' === $line[0]) {
                continue;
            }
            if ('N' === $line[0]) {
                $line[2] = '999999999999999999.999999';
                $line[3] = '';
            }
            yield $line;
        }
    }
}
