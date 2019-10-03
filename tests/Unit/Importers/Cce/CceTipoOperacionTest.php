<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cce;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceTipoOperacion;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors\TiposOperacion;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CceTipoOperacionTest extends TestCase
{
    public function testImporterInstance(): void
    {
        // no need to test in depth, abstract class and injector is been tested
        $importer = new CceTipoOperacion();
        $this->assertInstanceOf(AbstractXlsOneSheetImporter::class, $importer);
        $this->assertInstanceOf(TiposOperacion::class, $importer->createInjector(''));
        $this->assertSame('c_TipoOperacion', $importer->sheetName());
    }
}
