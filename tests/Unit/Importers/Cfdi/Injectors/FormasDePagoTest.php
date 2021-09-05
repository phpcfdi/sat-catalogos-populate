<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cfdi\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\FormasDePago;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class FormasDePagoTest extends TestCase
{
    private string $sourceFile;

    private FormasDePago $injector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sourceFile = $this->utilFilePath('cfdi/c_FormaPago.csv');
        $this->injector = new FormasDePago($this->sourceFile);
    }

    public function testFormasDePagoExtendsAbstractCsvInjector(): void
    {
        $this->assertInstanceOf(AbstractCsvInjector::class, $this->injector);
        $this->assertInstanceOf(InjectorInterface::class, $this->injector);
    }

    public function testCheckHeadersOnValidSource(): void
    {
        $csv = new CsvFile($this->sourceFile);
        $this->injector->checkHeaders($csv);

        $this->assertSame(4, $csv->position(), 'The csv position is on the first content line');
    }

    public function testCheckHeadersOnInvalidSource(): void
    {
        $csv = new CsvFile($this->utilFilePath('sample.csv'));

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The headers did not match on file');
        $this->injector->checkHeaders($csv);
    }

    public function testDataTable(): void
    {
        $dataTable = $this->injector->dataTable();
        $this->assertSame('cfdi_formas_pago', $dataTable->name());
        $expectedKeys = [
            'id',
            'texto',
            'es_bancarizado',
            'requiere_numero_operacion',
            'permite_banco_ordenante_rfc',
            'permite_cuenta_ordenante',
            'patron_cuenta_ordenante',
            'permite_banco_beneficiario_rfc',
            'permite_cuenta_beneficiario',
            'patron_cuenta_beneficiario',
            'permite_tipo_cadena_pago',
            'requiere_banco_ordenante_nombre_ext',
            'vigencia_desde',
            'vigencia_hasta',
        ];
        $this->assertSame($expectedKeys, $dataTable->fields()->keys());
    }

    /**
     * @testWith ["ABC", "ABC"]
     *           ["", "00"]
     *           ["9", "09"]
     */
    public function testTransformId(string $value, string $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [0 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['id']);
    }

    public function testContainsTexto(): void
    {
        $dataTable = $this->injector->dataTable();
        $this->assertInstanceOf(TextDataField::class, $dataTable->fields()->get('texto'));
    }

    /**
     * @testWith ["Sí", true]
     *           ["No", false]
     *           ["", false]
     */
    public function testTransformEsBancarizado(string $value, bool $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [2 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['es_bancarizado']);
    }

    /**
     * @testWith ["Opcional", false]
     *           ["", true]
     */
    public function testTransformNumeroOperacion(string $value, bool $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [3 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['requiere_numero_operacion']);
    }

    /**
     * @testWith ["No", false]
     *           ["", true]
     */
    public function testTransformPermiteBancoOrdenanteRfc(string $value, bool $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [4 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['permite_banco_ordenante_rfc']);
    }

    /**
     * @testWith ["No", false]
     *           ["", true]
     */
    public function testTransformPermiteCuentaOrdenante(string $value, bool $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [5 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['permite_cuenta_ordenante']);
    }

    /**
     * @testWith ["[0-9]{10}", "[0-9]{10}"]
     *           ["Opcional", "\\V*"]
     *           ["No", ""]
     */
    public function testTransformPatronCuentaOrdenante(string $value, string $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [6 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['patron_cuenta_ordenante']);
    }

    /**
     * @testWith ["No", false]
     *           ["", true]
     */
    public function testTransformPermiteBancoBeneficiarioRfc(string $value, bool $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [7 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['permite_banco_beneficiario_rfc']);
    }

    /**
     * @testWith ["No", false]
     *           ["", true]
     */
    public function testTransformPermiteCuentaBeneficiario(string $value, bool $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [8 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['permite_cuenta_beneficiario']);
    }

    /**
     * @testWith ["[0-9]{10}", "[0-9]{10}"]
     *           ["Opcional", "\\V*"]
     *           ["No", ""]
     */
    public function testTransformPatronCuentaBeneficiario(string $value, string $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [9 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['patron_cuenta_beneficiario']);
    }

    /**
     * @testWith ["No", false]
     *           ["", true]
     */
    public function testTransformPermiteTipoCadenaPago(string $value, bool $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [10 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['permite_tipo_cadena_pago']);
    }

    /**
     * @testWith ["No", false]
     *           ["", true]
     */
    public function testTransformRequiereBancoOrdenanteNombreExt(string $value, bool $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [11 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['requiere_banco_ordenante_nombre_ext']);
    }

    public function testContainsVigenciaDesde(): void
    {
        $dataTable = $this->injector->dataTable();
        $this->assertInstanceOf(DateDataField::class, $dataTable->fields()->get('vigencia_desde'));
    }

    public function testContainsVigenciaHasta(): void
    {
        $dataTable = $this->injector->dataTable();
        $this->assertInstanceOf(DateDataField::class, $dataTable->fields()->get('vigencia_hasta'));
    }
}
