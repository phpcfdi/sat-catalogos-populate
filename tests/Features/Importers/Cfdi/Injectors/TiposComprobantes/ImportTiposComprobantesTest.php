<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features\Importers\Cfdi\Injectors\TiposComprobantes;

use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\TiposComprobantes;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use Psr\Log\NullLogger;

class ImportTiposComprobantesTest extends TestCase
{
    /** @var Repository */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $source = $this->utilFilePath('cfdi/c_TipoDeComprobante.csv');
        $this->repository = new Repository(':memory:');
        $importer = new TiposComprobantes($source);
        $importer->validate();
        $importer->inject($this->repository, new NullLogger());
    }

    public function testImportRetrieveCorrectCount(): void
    {
        $sql = 'select count(*) from cfdi_tipos_comprobantes;';
        $this->assertEquals(5, $this->repository->queryOne($sql));
    }

    public function testImportIngreso(): void
    {
        $expected = [
            'id' => 'I',
            'texto' => 'Ingreso',
            'valor_maximo' => '999999999999999999.999999',
        ];

        $sql = 'SELECT * FROM cfdi_tipos_comprobantes WHERE (id = :id)';
        $retrieved = $this->repository->queryRow($sql, ['id' => 'I']);
        $this->assertEquals(array_replace_recursive($retrieved, $expected), $retrieved);
    }

    public function testImportNomina(): void
    {
        $expected = [
            'id' => 'N',
            'texto' => 'Nómina',
            'valor_maximo' => '999999999999999999.999999',
        ];

        $sql = 'SELECT * FROM cfdi_tipos_comprobantes WHERE (id = :id)';
        $retrieved = $this->repository->queryRow($sql, ['id' => 'N']);
        $this->assertEquals(array_replace_recursive($retrieved, $expected), $retrieved);
    }
}
