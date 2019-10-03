<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cce;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceLocalidad;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors\Localidades;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CceLocalidadTest extends TestCase
{
    public function testImporterInstance(): void
    {
        // no need to test in depth, abstract class and injector is been tested
        $importer = new CceLocalidad();
        $this->assertInstanceOf(AbstractXlsOneSheetImporter::class, $importer);
        $this->assertInstanceOf(Localidades::class, $importer->createInjector(''));
        $this->assertSame('c_Localidad', $importer->sheetName());
    }
}
