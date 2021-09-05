<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers;

use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\Aduanas;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\ClavesUnidades;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\CodigosPostales;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\FormasDePago;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\Impuestos;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\MetodosDePago;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\Monedas;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\NumerosPedimentoAduana;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\Paises;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\PatentesAduanales;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\ProductosServicios;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\RegimenesFiscales;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\ReglasTasaCuota;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\TiposComprobantes;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\TiposFactores;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\TiposRelaciones;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\UsosCfdi;
use PhpCfdi\SatCatalogosPopulate\Importers\CfdiCatalogs;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CfdiCatalogsTest extends TestCase
{
    /**
     * @see CfdiCatalogs::createInjectors()
     */
    public function testContainsAllAndOnlyThisInjectorsByDefault(): void
    {
        $expectedInjectorsClasses = [
            Aduanas::class,
            ProductosServicios::class,
            ClavesUnidades::class,
            CodigosPostales::class,
            FormasDePago::class,
            Impuestos::class,
            MetodosDePago::class,
            Monedas::class,
            Paises::class,
            PatentesAduanales::class,
            RegimenesFiscales::class,
            TiposComprobantes::class,
            TiposFactores::class,
            TiposRelaciones::class,
            UsosCfdi::class,
            NumerosPedimentoAduana::class,
            ReglasTasaCuota::class,
        ];

        $importer = new CfdiCatalogs();
        $cfdiInjectors = $importer->createInjectors('');

        $injectorsClasses = array_map(fn ($item) => get_class($item), $cfdiInjectors->all());

        $this->assertEquals(array_replace_recursive($injectorsClasses, $expectedInjectorsClasses), $injectorsClasses);
        $this->assertCount(count($expectedInjectorsClasses), $injectorsClasses);
    }
}
