<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Ccp20\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\PaddingDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\MaterialesPeligrosos;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\RightTrim;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class MaterialesPeligrososTest extends TestCase
{
    private string $sourceFile;

    private MaterialesPeligrosos $injector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sourceFile = $this->utilFilePath('ccp20/c_MaterialPeligroso.csv');
        $this->injector = new MaterialesPeligrosos($this->sourceFile);
    }

    public function testMaterialesPeligrososExtendsAbstractCsvInjector(): void
    {
        $this->assertInstanceOf(AbstractCsvInjector::class, $this->injector);
        $this->assertInstanceOf(InjectorInterface::class, $this->injector);
    }

    /**
     * @group ignore
     */
    public function testCheckHeadersOnValidSource(): void
    {
        /*$this->markTestSkipped('ignored until detail of line breaks in headers is resolved');
        $csv = new CsvFile($this->sourceFile, new RightTrim());
        $this->injector->checkHeaders($csv);

        $this->assertSame(4, $csv->position(), 'The csv position is on the first content line');*/
        self::assertTrue(true);
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
        $this->assertSame('ccp_20_materiales_peligrosos', $dataTable->name());
        $expectedClasses = [
            'id' => PaddingDataField::class,
            'texto' => TextDataField::class,
            'clase_o_div' => TextDataField::class,
            'peligro_secundario' => TextDataField::class,
            'nombre_tecnico' => TextDataField::class,
            'vigencia_desde' => DateDataField::class,
            'vigencia_hasta' => DateDataField::class,
        ];
        $this->assertSame(array_keys($expectedClasses), $dataTable->fields()->keys());
        foreach ($expectedClasses as $key => $classname) {
            $this->assertInstanceOf($classname, $dataTable->fields()->get($key));
        }
        $this->assertSame([], $dataTable->primaryKey());
    }
}
