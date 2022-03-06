<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers;

use PhpCfdi\SatCatalogosPopulate\Importers\Ccp20Catalogs;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class Ccp20CatalogsTest extends TestCase
{
    /**
     * @see Ccp20Catalogs::createInjectors()
     */
    public function testContainsAllAndOnlyThisImportersByDefault(): void
    {
        $expectedInjectorsClasses = [
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\AutorizacionesNaviero::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\ClavesUnidades::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\CodigosTransporteAereo::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\Colonias::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\ConfiguracionesAutotransporte::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\ConfiguracionesMaritimas::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\ContenedoresMaritimos::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\Estaciones::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\FigurasTransporte::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\Localidades::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\MaterialesPeligrosos::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\Municipios::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\PartesTransporte::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\ProductosServicios::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\TiposCarga::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\TiposEmbalaje::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\TiposEstacion::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\TiposPermiso::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\TiposRemolque::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\Transportes::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\TiposTrafico::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\TiposServicio::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\TiposCarro::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\DerechosDePaso::class,
            \PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors\Contenedores::class,
        ];

        $importer = new Ccp20Catalogs();
        $ccpInjectors = $importer->createInjectors('');

        $injectorsClasses = array_map(fn ($item) => $item::class, $ccpInjectors->all());

        $this->assertEquals(array_replace_recursive($injectorsClasses, $expectedInjectorsClasses), $injectorsClasses);
        $this->assertCount(count($expectedInjectorsClasses), $injectorsClasses);
    }
}
