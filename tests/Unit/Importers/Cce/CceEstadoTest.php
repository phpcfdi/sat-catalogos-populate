<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cce;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceEstado;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors\Estados;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CceEstadoTest extends TestCase
{
    public function testImporterInstance(): void
    {
        // no need to test in depth, abstract class and injector is been tested
        $importer = new CceEstado();
        $this->assertInstanceOf(AbstractXlsOneSheetImporter::class, $importer);
        $this->assertInstanceOf(Estados::class, $importer->createInjector(''));
        $this->assertSame('c_Estado', $importer->sheetName());
    }
}
