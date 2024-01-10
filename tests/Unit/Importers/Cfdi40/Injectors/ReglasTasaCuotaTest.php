<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cfdi40\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\BoolDataField;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\NumberFormatDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\ReglasTasaCuota;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\RightTrim;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use PHPUnit\Framework\Attributes\TestWith;
use RuntimeException;

class ReglasTasaCuotaTest extends TestCase
{
    private string $sourceFile;

    private ReglasTasaCuota $injector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sourceFile = $this->utilFilePath('cfdi40/c_TasaOCuota.csv');
        $this->injector = new ReglasTasaCuota($this->sourceFile);
    }

    public function testReglasTasaCuotaExtendsAbstractCsvInjector(): void
    {
        $this->assertInstanceOf(AbstractCsvInjector::class, $this->injector);
        $this->assertInstanceOf(InjectorInterface::class, $this->injector);
    }

    public function testCheckHeadersOnValidSource(): void
    {
        $csv = new CsvFile($this->sourceFile, new RightTrim());
        $this->injector->checkHeaders($csv);

        $this->assertSame(5, $csv->position(), 'The csv position is on the first content line');
    }

    public function testCheckHeadersOnInvalidSource(): void
    {
        $csv = new CsvFile($this->utilFilePath('sample.csv'));

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The headers did not match on file');
        $this->injector->checkHeaders($csv);
    }

    public function testDataTableFields(): void
    {
        $dataTable = $this->injector->dataTable();
        $this->assertSame('cfdi_40_reglas_tasa_cuota', $dataTable->name());
        $expectedClasses = [
            'tipo' => TextDataField::class,
            'minimo' => NumberFormatDataField::class,
            'valor' => NumberFormatDataField::class,
            'impuesto' => TextDataField::class,
            'factor' => TextDataField::class,
            'traslado' => BoolDataField::class,
            'retencion' => BoolDataField::class,
            'vigencia_desde' => DateDataField::class,
            'vigencia_hasta' => DateDataField::class,
        ];
        $this->assertSame(array_keys($expectedClasses), $dataTable->fields()->keys());
        foreach ($expectedClasses as $key => $classname) {
            $this->assertInstanceOf($classname, $dataTable->fields()->get($key));
        }
        $this->assertSame([], $dataTable->primaryKey());
    }

    #[TestWith(['0', '0.000000'])]
    #[TestWith(['1.234', '1.234000'])]
    #[TestWith(['', ''])]
    public function testTransformMinimo(string $value, string $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [1 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['minimo']);
    }

    #[TestWith(['0', '0.000000'])]
    #[TestWith(['1.234', '1.234000'])]
    #[TestWith(['', ''])]
    public function testTransformValor(string $value, string $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [2 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['valor']);
    }

    #[TestWith(['Sí', true])]
    #[TestWith(['No', false])]
    #[TestWith(['', false])]
    public function testTransformTraslado(string $value, bool $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [5 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['traslado']);
    }

    #[TestWith(['Sí', true])]
    #[TestWith(['No', false])]
    #[TestWith(['', false])]
    public function testTransformRetencion(string $value, bool $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [6 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['retencion']);
    }
}
