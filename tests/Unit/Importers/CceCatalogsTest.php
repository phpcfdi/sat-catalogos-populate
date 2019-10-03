<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers;

use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceClavePedimento;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceColonia;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceEstado;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceFraccionArancelaria;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceIncoterm;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceLocalidad;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceMotivoTraslado;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceMunicipio;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceTipoOperacion;
use PhpCfdi\SatCatalogosPopulate\Importers\Cce\CceUnidadAduana;
use PhpCfdi\SatCatalogosPopulate\Importers\CceCatalogs;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CceCatalogsTest extends TestCase
{
    /**
     * @see CceCatalogs::createImporters()
     */
    public function testContainsAllAndOnlyThisImportersByDefault(): void
    {
        $expectedInjectorsClasses = [
            CceClavePedimento::class,
            CceColonia::class,
            CceEstado::class,
            CceFraccionArancelaria::class,
            CceIncoterm::class,
            CceLocalidad::class,
            CceMotivoTraslado::class,
            CceMunicipio::class,
            CceTipoOperacion::class,
            CceUnidadAduana::class,
        ];

        $importer = new CceCatalogs();
        $importers = array_values($importer->createImporters());

        $importersClasses = array_map(function ($item) {
            return get_class($item);
        }, $importers);

        $this->assertEquals(array_replace_recursive($importersClasses, $expectedInjectorsClasses), $importersClasses);
        $this->assertCount(count($expectedInjectorsClasses), $importersClasses);
    }
}
