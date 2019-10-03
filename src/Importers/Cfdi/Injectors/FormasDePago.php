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

class FormasDePago extends AbstractCsvInjector implements InjectorInterface
{
    public function checkHeaders(CsvFile $csv): void
    {
        $csv->move(3);
        $expected = [
            'c_FormaPago',
            'Descripción',
            'Bancarizado',
            'Número de operación',
            'RFC del Emisor de la cuenta ordenante',
            'Cuenta Ordenante',
            'Patrón para cuenta ordenante',
            'RFC del Emisor Cuenta de Beneficiario',
            'Cuenta de Benenficiario',
            'Patrón para cuenta Beneficiaria',
            'Tipo Cadena Pago',
            'Nombre del Banco emisor de la cuenta ordenante en caso de extranjero',
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
        $pattern = function (string $input): string {
            if ('No' === $input) {
                return '';
            }
            if ('Opcional' === $input) {
                return '\V*';
            }
            return $input;
        };
        return new DataTable('cfdi_formas_pago', new DataFields([
            new PaddingDataField('id', '0', 2),
            new TextDataField('texto'),
            new BoolDataField('es_bancarizado', ['Sí']),
            new BoolDataField('requiere_numero_operacion', [], ['Opcional'], true),
            new BoolDataField('permite_banco_ordenante_rfc', [], ['No'], true),
            new BoolDataField('permite_cuenta_ordenante', [], ['No'], true),
            new TextDataField('patron_cuenta_ordenante', $pattern),
            new BoolDataField('permite_banco_beneficiario_rfc', [], ['No'], true),
            new BoolDataField('permite_cuenta_beneficiario', [], ['No'], true),
            new TextDataField('patron_cuenta_beneficiario', $pattern),
            new BoolDataField('permite_tipo_cadena_pago', [], ['No'], true),
            new BoolDataField('requiere_banco_ordenante_nombre_ext', [], ['No'], true),
            new DateDataField('vigencia_desde'),
            new DateDataField('vigencia_hasta'),
        ]));
    }
}
