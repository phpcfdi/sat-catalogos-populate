<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cce;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceIncoterm;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors\Incoterms;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CceIncotermTest extends TestCase
{
    public function testImporterInstance(): void
    {
        // no need to test in depth, abstract class and injector has been tested
        $importer = new CceIncoterm();
        $this->assertInstanceOf(AbstractXlsOneSheetImporter::class, $importer);
        $this->assertInstanceOf(Incoterms::class, $importer->createInjector(''));
        $this->assertSame('c_INCOTERM', $importer->sheetName());
    }
}
