<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cfdi40\Injectors;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PhpCfdi\SatCatalogosPopulate\Database\IntegerDataField;
use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\CodigosPostales;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\RightTrim;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use Psr\Log\NullLogger;
use RuntimeException;

class CodigosPostalesTest extends TestCase
{
    private string $sourceFile;

    private CodigosPostales $injector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sourceFile = $this->utilFilePath('cfdi40/c_CodigoPostal.csv');
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
        $this->assertSame('cfdi_40_codigos_postales', $dataTable->name());
        $expectedClasses = [
            'id' => TextDataField::class,
            'estado' => TextDataField::class,
            'municipio' => TextDataField::class,
            'localidad' => TextDataField::class,
            'estimulo_frontera' => IntegerDataField::class,
            'vigencia_desde' => DateDataField::class,
            'vigencia_hasta' => DateDataField::class,
            'huso_descripcion' => TextDataField::class,
            'huso_verano_mes_inicio' => TextDataField::class,
            'huso_verano_dia_inicio' => TextDataField::class,
            'huso_verano_hora_inicio' => TextDataField::class,
            'huso_verano_diferencia' => TextDataField::class,
            'huso_invierno_mes_inicio' => TextDataField::class,
            'huso_invierno_dia_inicio' => TextDataField::class,
            'huso_invierno_hora_inicio' => TextDataField::class,
            'huso_invierno_diferencia' => TextDataField::class,
        ];
        $this->assertSame(array_keys($expectedClasses), $dataTable->fields()->keys());
        foreach ($expectedClasses as $key => $classname) {
            $this->assertInstanceOf($classname, $dataTable->fields()->get($key));
        }
        $this->assertSame(['id'], $dataTable->primaryKey());
    }

    public function testInject(): void
    {
        $repository = new Repository(':memory:');
        $this->injector->inject($repository, new NullLogger());

        $sql = 'select count(*) from ' . $this->injector->dataTable()->name() . ' where (id = :id);';
        $count = (int) $repository->queryOne($sql, ['id' => '00000']);

        $this->assertSame(0, $count, 'The id "00000" must not exists in the catalog');
    }

    /** @return array<string, array{int}> */
    public static function providerInjectedFieldEstimuloFrontera(): array
    {
        return [
            'Sin estímulo' => [0],
            'Estímulo frontera norte' => [1],
            'Estímulo frontera sur' => [2],
        ];
    }

    /** @dataProvider providerInjectedFieldEstimuloFrontera */
    public function testInjectedFieldEstimuloFrontera(int $estimuloFrontera): void
    {
        $repository = new Repository(':memory:');
        $this->injector->inject($repository, new NullLogger());

        $sql = 'select count(*) from ' . $this->injector->dataTable()->name()
            . ' where (estimulo_frontera = :estimulo_frontera);';
        $count = (int) $repository->queryOne($sql, ['estimulo_frontera' => $estimuloFrontera]);

        $this->assertGreaterThan(
            0,
            $count,
            sprintf('Cannot find records with estimulo_frontera = %s', $estimuloFrontera)
        );
    }
}
