<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cce;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceUnidadAduana;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors\UnidadesAduana;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CceUnidadAduanaTest extends TestCase
{
    public function testImporterInstance(): void
    {
        // no need to test in depth, abstract class and injector has been tested
        $importer = new CceUnidadAduana();
        $this->assertInstanceOf(AbstractXlsOneSheetImporter::class, $importer);
        $this->assertInstanceOf(UnidadesAduana::class, $importer->createInjector(''));
        $this->assertSame('c_UnidadAduana', $importer->sheetName());
    }
}
