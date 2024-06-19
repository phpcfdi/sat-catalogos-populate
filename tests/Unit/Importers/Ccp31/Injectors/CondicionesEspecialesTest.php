<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Ccp31\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\PaddingDataField;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Importers\Ccp31\Injectors\CondicionesEspeciales;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\CheckDataTableTrait;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\RightTrim;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class CondicionesEspecialesTest extends TestCase
{
    use CheckDataTableTrait;

    private string $sourceFile;

    private CondicionesEspeciales $injector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sourceFile = $this->utilFilePath('ccp31/c_CondicionesEspeciales.csv');
        $this->injector = new CondicionesEspeciales($this->sourceFile);
    }

    public function testConfiguracionesEspecialesExtendsAbstractCsvInjector(): void
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

    public function testDataTable(): void
    {
        $this->checkDataTable(
            $this->injector->dataTable(),
            'ccp_31_condiciones_especiales',
            [
                'id' => PaddingDataField::class,
                'texto' => TextDataField::class,
                'vigencia_desde' => DateDataField::class,
                'vigencia_hasta' => DateDataField::class,
            ],
            ['id']
        );
    }
}
