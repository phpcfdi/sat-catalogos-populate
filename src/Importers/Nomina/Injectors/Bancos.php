<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\PaddingDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class Bancos extends AbstractCsvInjector implements InjectorInterface
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'c_Banco',
            'Descripción',
            'Nombre o razón social',
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
        return new DataTable('nomina_bancos', new DataFields([
            new PaddingDataField('id', '0', 3),
            new TextDataField('texto'),
            new TextDataField('razon_social'),
            new DateDataField('vigencia_desde'),
            new DateDataField('vigencia_hasta'),
        ]));
    }
}
