<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers;

use PhpCfdi\SatCatalogosPopulate\Importers\CcpCatalogs;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class CcpCatalogsTest extends TestCase
{
    /**
     * @see CcpCatalogs::createInjectors()
     */
    public function testContainsAllAndOnlyThisImportersByDefault(): void
    {
        $expectedInjectorsClasses = [
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\AutorizacionesNaviero::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\ClavesUnidades::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\CodigosTransporteAereo::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\Colonias::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\ConfiguracionesAutotransporte::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\ConfiguracionesMaritimas::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\ContenedoresMaritimos::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\Estaciones::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\FigurasTransporte::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\Localidades::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\MaterialesPeligrosos::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\Municipios::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\PartesTransporte::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\ProductosServicios::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\TiposCarga::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\TiposEmbalaje::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\TiposEstacion::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\TiposPermiso::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\TiposRemolque::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\Transportes::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\TiposTrafico::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\TiposServicio::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\TiposCarro::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\DerechosDePaso::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp\Injectors\Contenedores::class,
        ];

        $importer = new CcpCatalogs();
        $ccpInjectors = $importer->createInjectors('');

        $injectorsClasses = array_map(fn ($item) => $item::class, $ccpInjectors->all());

        $this->assertEquals(array_replace_recursive($injectorsClasses, $expectedInjectorsClasses), $injectorsClasses);
        $this->assertCount(count($expectedInjectorsClasses), $injectorsClasses);
    }
}
