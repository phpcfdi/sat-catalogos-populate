<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cfdi\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\CodigosPostales;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\RightTrim;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use Psr\Log\NullLogger;
use RuntimeException;

class CodigosPostalesTest extends TestCase
{
    /** @var string */
    private $sourceFile;

    /** @var CodigosPostales */
    private $injector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sourceFile = $this->utilFilePath('cfdi/c_CodigoPostal.csv');
        $this->injector = new CodigosPostales($this->sourceFile);
    }

    public function testCodigosPostalesExtendsAbstractCsvInjector(): void
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

    public function testDataTable(): void
    {
        $dataTable = $this->injector->dataTable();
        $this->assertSame('cfdi_codigos_postales', $dataTable->name());
        $expectedKeys = [
            'id',
            'estado',
            'municipio',
            'localidad',
            'estimulo_frontera',
            'estimulo_vigencia_desde',
            'estimulo_vigencia_hasta',
            'huso_descripcion',
            'huso_verano_mes_inicio',
            'huso_verano_dia_inicio',
            'huso_verano_hora_inicio',
            'huso_verano_diferencia',
            'huso_invierno_mes_inicio',
            'huso_invierno_dia_inicio',
            'huso_invierno_hora_inicio',
            'huso_invierno_diferencia',
        ];
        $this->assertSame($expectedKeys, $dataTable->fields()->keys());
    }

    public function testInject(): void
    {
        $repository = new Repository(':memory:');
        $this->injector->inject($repository, new NullLogger());

        $sql = 'select count(*) from ' . $this->injector->dataTable()->name() . ' where (id = :id);';
        $count = (int) $repository->queryOne($sql);

        $this->assertSame(0, $count, 'The id "00000" must not exists in the catalog');
    }
}
