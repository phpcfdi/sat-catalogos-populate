<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers\Cce;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceClavePedimento;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\Injectors\ClavesPedimentos;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CceClavePedimentoTest extends TestCase
{
    public function testImporterInstance(): void
    {
        // no need to test in depth, abstract class and injector is been tested
        $importer = new CceClavePedimento();
        $this->assertInstanceOf(AbstractXlsOneSheetImporter::class, $importer);
        $this->assertInstanceOf(ClavesPedimentos::class, $importer->createInjector(''));
        $this->assertSame('c_ClavePedimento', $importer->sheetName());
    }
}
