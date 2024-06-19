<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers;

use PhpCfdi\SatCatalogosPopulate\Importers\Ccp31\Injectors;
use PhpCfdi\SatCatalogosPopulate\Importers\Ccp31Catalogs;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class Ccp31CatalogsTest extends TestCase
{
    /**
     * @see Ccp31Catalogs::createInjectors()
     */
    public function testContainsAllAndOnlyThisImportersByDefault(): void
    {
        $expectedInjectorsClasses = [
            Injectors\AutorizacionesNaviero::class,
            Injectors\ClavesUnidades::class,
            Injectors\CodigosTransporteAereo::class,
            Injectors\Colonias::class,
            Injectors\CondicionesEspeciales::class,
            Injectors\ConfiguracionesAutotransporte::class,
            Injectors\ConfiguracionesMaritimas::class,
            Injectors\Contenedores::class,
            Injectors\ContenedoresMaritimos::class,
            Injectors\DerechosDePaso::class,
            Injectors\DocumentosAduaneros::class,
            Injectors\Estaciones::class,
            Injectors\FigurasTransporte::class,
            Injectors\FormasFarmaceuticas::class,
            Injectors\Localidades::class,
            Injectors\MaterialesPeligrosos::class,
            Injectors\Municipios::class,
            Injectors\PartesTransporte::class,
            Injectors\ProductosServicios::class,
            Injectors\RegimenesAduaneros::class,
            Injectors\RegistrosIstmo::class,
            Injectors\SectoresCofepris::class,
            Injectors\TiposCarga::class,
            Injectors\TiposCarro::class,
            Injectors\TiposEmbalaje::class,
            Injectors\TiposEstacion::class,
            Injectors\TiposMateria::class,
            Injectors\TiposPermiso::class,
            Injectors\TiposRemolque::class,
            Injectors\TiposServicio::class,
            Injectors\TiposTrafico::class,
            Injectors\Transportes::class,
        ];

        $importer = new Ccp31Catalogs();
        $ccpInjectors = $importer->createInjectors('');

        $injectorsClasses = array_map(fn ($item) => $item::class, $ccpInjectors->all());

        $this->assertEquals(array_replace_recursive($injectorsClasses, $expectedInjectorsClasses), $injectorsClasses);
        $this->assertCount(count($expectedInjectorsClasses), $injectorsClasses);
    }
}
