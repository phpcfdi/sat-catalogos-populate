<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cce;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceMotivoTraslado;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors\MotivosTraslado;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CceMotivoTrasladoTest extends TestCase
{
    public function testImporterInstance(): void
    {
        // no need to test in depth, abstract class and injector has been tested
        $importer = new CceMotivoTraslado();
        $this->assertInstanceOf(AbstractXlsOneSheetImporter::class, $importer);
        $this->assertInstanceOf(MotivosTraslado::class, $importer->createInjector(''));
        $this->assertSame('c_MotivoTraslado', $importer->sheetName());
    }
}
