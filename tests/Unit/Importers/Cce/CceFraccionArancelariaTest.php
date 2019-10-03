<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cce;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceFraccionArancelaria;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors\FraccionesArancelarias;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CceFraccionArancelariaTest extends TestCase
{
    public function testImporterInstance(): void
    {
        // no need to test in depth, abstract class and injector is been tested
        $importer = new CceFraccionArancelaria();
        $this->assertInstanceOf(AbstractXlsOneSheetImporter::class, $importer);
        $this->assertInstanceOf(FraccionesArancelarias::class, $importer->createInjector(''));
        $this->assertSame('c_FraccionArancelaria', $importer->sheetName());
    }
}
