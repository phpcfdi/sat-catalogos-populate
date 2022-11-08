<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features;

use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\Importers\CfdiCatalogs;
use PhpCfdi\SatCatalogosPopulate\Tests\Fixtures\Converters\FakeXlsToCsvFolder;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\NullLogger;

class ImportTest extends TestCase
{
    public function testImportCfdi(): void
    {
        // given a known source file
        $source = $this->utilFilePath('cfdi/catCFDI.xls');
        $csvFolder = $this->utilFilePath('cfdi/');

        // when inject to database
        $repository = new Repository(':memory:');

        /* mock this object to avoid expensive converter operation from a real file */
        /** @var CfdiCatalogs&MockObject $importer */
        $importer = $this->getMockBuilder(CfdiCatalogs::class)
            ->onlyMethods(['createConverter'])
            ->getMock();
        $importer->method('createConverter')->willReturn(new FakeXlsToCsvFolder($csvFolder));

        $repository->pdo()->beginTransaction();
        $importer->import($source, $repository, new NullLogger());
        $repository->pdo()->commit();

        // then the repository has a know table with contents
        $this->assertTrue($repository->hasTable('cfdi_aduanas'));
        $this->assertGreaterThan(0, $repository->getRecordCount('cfdi_aduanas'));
    }
}
