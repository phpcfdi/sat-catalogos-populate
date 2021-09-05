<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

use function PhpCfdi\SatCatalogosPopulate\Utils\preg_is_valid;

class Paises extends AbstractCsvInjector implements InjectorInterface
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'c_Pais',
            'Descripción',
            'Formato de código postal',
            'Formato de Registro de Identidad Tributaria',
            'Validación del Registro de Identidad Tributaria',
            'Agrupaciones',
        ];
        $headers = $csv->readLine();

        if ($expected !== $headers) {
            throw new RuntimeException("The headers did not match on file {$this->sourceFile()}");
        }

        $csv->next();
    }

    public function dataTable(): DataTable
    {
        $optionalPattern = function (string $input) {
            if ('' === $input) {
                return '';
            }
            if (! preg_is_valid($input)) {
                throw new RuntimeException("Se ha encontrado un valor que no es un patrón: '$input'");
            }

            return $input;
        };

        return new DataTable('cfdi_paises', new DataFields([
            new TextDataField('id'),
            new TextDataField('texto'),
            new TextDataField('patron_codigo_postal', $optionalPattern),
            new TextDataField('patron_identidad_tributaria', $optionalPattern),
            new TextDataField('validacion_identidad_tributaria'),
            new TextDataField('agrupaciones'),
        ]));
    }
}
