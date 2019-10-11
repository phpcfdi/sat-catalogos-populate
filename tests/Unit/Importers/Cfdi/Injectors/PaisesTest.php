<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cfdi\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\Paises;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\RightTrim;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class PaisesTest extends TestCase
{
    /** @var string */
    private $sourceFile;

    /** @var Paises */
    private $injector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sourceFile = $this->utilFilePath('cfdi/c_Pais.csv');
        $this->injector = new Paises($this->sourceFile);
    }

    public function testPaisesExtendsAbstractCsvInjector(): void
    {
        $this->assertInstanceOf(AbstractCsvInjector::class, $this->injector);
        $this->assertInstanceOf(InjectorInterface::class, $this->injector);
    }

    public function testCheckHeadersOnValidSource(): void
    {
        $csv = new CsvFile($this->sourceFile, new RightTrim());
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

    public function testDataTableFields(): void
    {
        $dataTable = $this->injector->dataTable();
        $this->assertSame('cfdi_paises', $dataTable->name());
        $expectedClasses = [
            'id' => TextDataField::class,
            'texto' => TextDataField::class,
            'patron_codigo_postal' => TextDataField::class,
            'patron_identidad_tributaria' => TextDataField::class,
            'validacion_identidad_tributaria' => TextDataField::class,
            'agrupaciones' => TextDataField::class,
        ];
        $this->assertSame(array_keys($expectedClasses), $dataTable->fields()->keys());
        foreach ($expectedClasses as $key => $classname) {
            $this->assertInstanceOf($classname, $dataTable->fields()->get($key));
        }
    }

    /**
     * @param string $value
     * @testWith [""]
     *           ["[0-9]+"]
     */
    public function testPatronCodigoPostalValido(string $value): void
    {
        $dataTable = $this->injector->dataTable();
        $transformed = $dataTable->fields()->transform(['foo', 'foo', $value, '', '', '']);
        $this->assertSame($value, $transformed['patron_codigo_postal']);
    }

    public function testPatronCodigoPostalInvalidPattern(): void
    {
        $dataTable = $this->injector->dataTable();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Se ha encontrado un valor que no es un patrón');
        $dataTable->fields()->transform(['foo', 'foo', ') invalid (', '', '', '']);
    }

    /**
     * @param string $value
     * @testWith [""]
     *           ["[0-9]+"]
     */
    public function testPatronIdentidadTributariaValido(string $value): void
    {
        $dataTable = $this->injector->dataTable();
        $transformed = $dataTable->fields()->transform(['foo', 'foo', '', $value, '', '']);
        $this->assertSame($value, $transformed['patron_identidad_tributaria']);
    }

    public function testPatronIdentidadTributariaInvalidPattern(): void
    {
        $dataTable = $this->injector->dataTable();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Se ha encontrado un valor que no es un patrón');
        $dataTable->fields()->transform(['foo', 'foo', '', ') invalid (', '', '']);
    }
}
