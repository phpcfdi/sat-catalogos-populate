<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers;

use PhpCfdi\SatCatalogosPopulate\Importers\Ccp20Catalogs;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Importers\Ccp20\Injectors;

class Ccp20CatalogsTest extends TestCase
{
    /**
     * @see Ccp20Catalogs::createInjectors()
     */
    public function testContainsAllAndOnlyThisImportersByDefault(): void
    {
        $expectedInjectorsClasses = [
            Injectors\AutorizacionesNaviero::class,
            Injectors\ClavesUnidades::class,
            Injectors\CodigosTransporteAereo::class,
            Injectors\Colonias::class,
            Injectors\ConfiguracionesAutotransporte::class,
            Injectors\ConfiguracionesMaritimas::class,
            Injectors\ContenedoresMaritimos::class,
            Injectors\Estaciones::class,
            Injectors\FigurasTransporte::class,
            Injectors\Localidades::class,
            Injectors\MaterialesPeligrosos::class,
            Injectors\Municipios::class,
            Injectors\PartesTransporte::class,
            Injectors\ProductosServicios::class,
            Injectors\TiposCarga::class,
            Injectors\TiposEmbalaje::class,
            Injectors\TiposEstacion::class,
            Injectors\TiposPermiso::class,
            Injectors\TiposRemolque::class,
            Injectors\Transportes::class,
            Injectors\TiposTrafico::class,
            Injectors\TiposServicio::class,
            Injectors\TiposCarro::class,
            Injectors\DerechosDePaso::class,
            Injectors\Contenedores::class,
        ];

        $importer = new Ccp20Catalogs();
        $ccpInjectors = $importer->createInjectors('');

        $injectorsClasses = array_map(fn ($item) => $item::class, $ccpInjectors->all());

        $this->assertEquals(array_replace_recursive($injectorsClasses, $expectedInjectorsClasses), $injectorsClasses);
        $this->assertCount(count($expectedInjectorsClasses), $injectorsClasses);
    }
}
