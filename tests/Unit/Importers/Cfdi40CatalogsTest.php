<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers;

use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\Aduanas;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\ClavesUnidades;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\CodigosPostales;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\Colonias;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\Estados;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\Exportaciones;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\FormasDePago;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\Impuestos;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\Localidades;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\Meses;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\MetodosDePago;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\Monedas;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\Municipios;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\NumerosPedimentoAduana;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\ObjetosDeImpuestos;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\Paises;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\PatentesAduanales;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\Periodicidades;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\ProductosServicios;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\RegimenesFiscales;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\ReglasTasaCuota;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\TiposComprobantes;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\TiposFactores;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\TiposRelaciones;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40\Injectors\UsosCfdi;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi40Catalogs;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class Cfdi40CatalogsTest extends TestCase
{
    /**
     * @see CfdiCatalogs::createInjectors()
     */
    public function testContainsAllAndOnlyThisInjectorsByDefault(): void
    {
        $expectedInjectorsClasses = [
            Aduanas::class,
            ClavesUnidades::class,
            CodigosPostales::class,
            Colonias::class,
            Estados::class,
            Exportaciones::class,
            FormasDePago::class,
            Impuestos::class,
            Localidades::class,
            Meses::class,
            MetodosDePago::class,
            Monedas::class,
            Municipios::class,
            NumerosPedimentoAduana::class,
            ObjetosDeImpuestos::class,
            Paises::class,
            PatentesAduanales::class,
            Periodicidades::class,
            ProductosServicios::class,
            RegimenesFiscales::class,
            ReglasTasaCuota::class,
            TiposComprobantes::class,
            TiposFactores::class,
            TiposRelaciones::class,
            UsosCfdi::class,
        ];

        $importer = new Cfdi40Catalogs();
        $cfdiInjectors = $importer->createInjectors('');

        $injectorsClasses = array_map(fn ($item) => $item::class, $cfdiInjectors->all());

        $this->assertEquals(array_replace_recursive($injectorsClasses, $expectedInjectorsClasses), $injectorsClasses);
        $this->assertCount(count($expectedInjectorsClasses), $injectorsClasses);
    }
}
