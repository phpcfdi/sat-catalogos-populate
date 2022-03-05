<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cfdi40\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\ProductosServicios;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class ProductosServiciosTest extends TestCase
{
    private string $sourceFile;

    private ProductosServicios $injector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sourceFile = $this->utilFilePath('cfdi40/c_ClaveProdServ.csv');
        $this->injector = new ProductosServicios($this->sourceFile);
    }

    public function testProductosServiciosExtendsAbstractCsvInjector(): void
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
        $this->assertSame('cfdi_40_productos_servicios', $dataTable->name());
        $expectedKeys = [
            'id',
            'texto',
            'iva_trasladado',
            'ieps_trasladado',
            'complemento',
            'vigencia_desde',
            'vigencia_hasta',
            'estimulo_frontera',
            'similares',
        ];
        $this->assertSame($expectedKeys, $dataTable->fields()->keys());
    }
}
