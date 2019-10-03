<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cce;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceMunicipio;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors\Municipios;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CceMunicipioTest extends TestCase
{
    public function testImporterInstance(): void
    {
        // no need to test in depth, abstract class and injector is been tested
        $importer = new CceMunicipio();
        $this->assertInstanceOf(AbstractXlsOneSheetImporter::class, $importer);
        $this->assertInstanceOf(Municipios::class, $importer->createInjector(''));
        $this->assertSame('c_Municipio', $importer->sheetName());
    }
}
