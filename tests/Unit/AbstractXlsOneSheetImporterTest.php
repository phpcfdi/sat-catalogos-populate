<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\Tests\Fixtures\FakeXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use Psr\Log\NullLogger;

class AbstractXlsOneSheetImporterTest extends TestCase
{
    public function testImplementation(): void
    {
        $importer = new FakeXlsOneSheetImporter();
        $this->assertInstanceOf(AbstractXlsOneSheetImporter::class, $importer);
    }

    public function testImport(): void
    {
        $repository = new Repository(':memory:');
        $importer = new FakeXlsOneSheetImporter();

        $importer->import($this->utilFilePath('FooSample.xls'), $repository, new NullLogger());

        $this->assertTrue($repository->hasTable('foo'));
    }
}
