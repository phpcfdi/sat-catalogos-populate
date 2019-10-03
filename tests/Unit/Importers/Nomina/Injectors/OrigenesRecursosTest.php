<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Nomina\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\OrigenesRecursos;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\RightTrim;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class OrigenesRecursosTest extends TestCase
{
    /** @var string */
    private $sourceFile;

    /** @var OrigenesRecursos */
    private $injector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sourceFile = $this->utilFilePath('nomina/c_OrigenRecurso.csv');
        $this->injector = new OrigenesRecursos($this->sourceFile);
    }

    public function testOrigenesRecursosExtendsAbstractCsvInjector(): void
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
        $this->assertSame('nomina_origenes_recursos', $dataTable->name());
        $expectedClasses = [
            'id' => TextDataField::class,
            'texto' => TextDataField::class,
        ];
        $this->assertSame(array_keys($expectedClasses), $dataTable->fields()->keys());
        foreach ($expectedClasses as $key => $classname) {
            $this->assertInstanceOf($classname, $dataTable->fields()->get($key));
        }
        $this->assertSame(['id'], $dataTable->primaryKey());
    }
}
