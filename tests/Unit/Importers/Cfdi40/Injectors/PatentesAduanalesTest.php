<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cfdi40\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\PatentesAduanales;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class PatentesAduanalesTest extends TestCase
{
    private string $sourceFile;

    private PatentesAduanales $injector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sourceFile = $this->utilFilePath('cfdi40/c_PatenteAduanal.csv');
        $this->injector = new PatentesAduanales($this->sourceFile);
    }

    public function testPatentesAduanalesExtendsAbstractCsvInjector(): void
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

    public function testDataTableFields(): void
    {
        $dataTable = $this->injector->dataTable();
        $this->assertSame('cfdi_40_patentes_aduanales', $dataTable->name());
        $expectedClasses = [
            'id' => TextDataField::class,
            'vigencia_desde' => DateDataField::class,
            'vigencia_hasta' => DateDataField::class,
        ];
        $this->assertSame(array_keys($expectedClasses), $dataTable->fields()->keys());
        foreach ($expectedClasses as $key => $classname) {
            $this->assertInstanceOf($classname, $dataTable->fields()->get($key));
        }
    }

    /**
     * @testWith ["ABCDE", "ABCDE"]
     *           ["", "0000"]
     *           ["9", "0009"]
     */
    public function testTransformId(string $value, string $expected): void
    {
        $dataTable = $this->injector->dataTable();
        $input = [0 => $value];
        $transform = $dataTable->fields()->transform($input);
        $this->assertSame($expected, $transform['id']);
    }
}
