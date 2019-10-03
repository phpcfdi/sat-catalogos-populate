<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\BoolDataField;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\PaddingDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class ProductosServicios extends AbstractCsvInjector implements InjectorInterface
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(2);
        $expected = [
            'c_ClaveProdServ',
            'Descripción',
            'Incluir IVA trasladado',
            'Incluir IEPS trasladado',
            'Complemento que debe incluir',
            'FechaInicioVigencia',
            'FechaFinVigencia',
            'Estímulo Franja Fronteriza',
            'Palabras similares',
        ];
        $headers = $csv->readLine();

        if ($expected !== $headers) {
            throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
        }

        $csv->next();
    }

    public function dataTable(): DataTable
    {
        return new DataTable('cfdi_productos_servicios', new DataFields([
            new PaddingDataField('id', '0', 8),
            new TextDataField('texto'),
            new BoolDataField('iva_trasladado', ['Sí']),
            new BoolDataField('ieps_trasladado', ['Sí']),
            new TextDataField('complemento'),
            new DateDataField('vigencia_desde'),
            new DateDataField('vigencia_hasta'),
            new BoolDataField('estimulo_frontera', ['1']),
            new TextDataField('similares'),
        ]));
    }
}
