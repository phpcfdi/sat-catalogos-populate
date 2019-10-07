<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cfdi\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\Impuestos;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class ImpuestosTest extends TestCase
{
    /** @var string */
    private $sourceFile;

    /** @var Impuestos */
    private $injector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sourceFile = $this->utilFilePath('cfdi/c_Impuesto.csv');
        $this->injector = new Impuestos($this->sourceFile);
    }

    public function testImpuestosExtendsAbstractCsvInjector(): void
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
        $this->assertSame('cfdi_impuestos', $dataTable->name());
        $expectedKeys = [
            'id',
            'texto',
            'retencion',
            'traslado',
            'ambito',
            'entidad',
        ];
        $this->assertSame($expectedKeys, $dataTable->fields()->keys());
    }

    /**
     * @param string $value
     * @param string $expected
     * @testWith ["ABCD", "ABCD"]
     *           ["", "000"]
     *           ["9", "009"]
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
     * @param string $value
     * @param bool $expected
     * @testWith ["Si", true]
     *           ["No", false]
     *           ["", false]
     */
    public function testTransformRetencion(string $value, bool $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [2 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['retencion']);
    }

    /**
     * @param string $value
     * @param bool $expected
     * @testWith ["Si", true]
     *           ["No", false]
     *           ["", false]
     */
    public function testTransformTraslado(string $value, bool $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [3 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['traslado']);
    }
}
