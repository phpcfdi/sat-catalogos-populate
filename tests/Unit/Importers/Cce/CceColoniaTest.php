<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cce;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceColonia;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors\Colonias;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CceColoniaTest extends TestCase
{
    public function testImporterInstance(): void
    {
        // no need to test in depth, abstract class and injector has been tested
        $importer = new CceColonia();
        $this->assertInstanceOf(AbstractXlsOneSheetImporter::class, $importer);
        $this->assertInstanceOf(Colonias::class, $importer->createInjector(''));
        $this->assertSame('c_Colonia', $importer->sheetName());
    }
}
