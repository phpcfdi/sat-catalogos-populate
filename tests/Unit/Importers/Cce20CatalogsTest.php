<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers;

use PhpCfdi\SatCatalogosPopulate\Importers\Cce20\CceClavePedimento;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce20\CceColonia;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce20\CceEstado;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce20\CceFraccionArancelaria;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce20\CceIncoterm;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce20\CceLocalidad;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce20\CceMotivoTraslado;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce20\CceMunicipio;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce20\CceTipoOperacion;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce20\CceUnidadAduana;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce20Catalogs;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class Cce20CatalogsTest extends TestCase
{
    /**
     * @see Cce20Catalogs::createImporters()
     */
    public function testContainsAllAndOnlyThisImportersByDefault(): void
    {
        $expectedInjectorsClasses = [
            CceClavePedimento::class,
            CceColonia::class,
            CceEstado::class,
            CceFraccionArancelaria::class, // Fracciones Arancelarias 20221212
            CceIncoterm::class,
            CceLocalidad::class,
            CceMotivoTraslado::class,
            CceMunicipio::class,
            CceTipoOperacion::class,
            CceUnidadAduana::class,
        ];

        $importer = new Cce20Catalogs();
        $importers = array_values($importer->createImporters());

        $importersClasses = array_map(fn ($item) => $item::class, $importers);

        $this->assertEquals(array_replace_recursive($importersClasses, $expectedInjectorsClasses), $importersClasses);
        $this->assertCount(count($expectedInjectorsClasses), $importersClasses);
    }
}
