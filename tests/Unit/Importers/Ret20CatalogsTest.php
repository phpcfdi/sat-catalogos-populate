<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers;

use PhpCfdi\SatCatalogosPopulate\Importers\Ret20\Injectors;
use PhpCfdi\SatCatalogosPopulate\Importers\Ret20Catalogs;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class Ret20CatalogsTest extends TestCase
{
    /**
     * @see Ret20Catalogs::createInjectors()
     */
    public function testContainsAllAndOnlyThisImportersByDefault(): void
    {
        $expectedInjectorsClasses = [
            Injectors\ClavesRetencion::class,
            Injectors\Ejercicios::class,
            Injectors\EntidadesFederativas::class,
            Injectors\Paises::class,
            Injectors\Periodicidades::class,
            Injectors\Periodos::class,
            Injectors\TiposContribuyentes::class,
            Injectors\TiposDividendosUtilidades::class,
            Injectors\TiposImpuestos::class,
            Injectors\TiposPagoRetencion::class,
        ];

        $importer = new Ret20Catalogs();
        $retInjectors = $importer->createInjectors('');

        $injectorsClasses = array_map(fn ($item) => $item::class, $retInjectors->all());

        $this->assertEquals(array_replace_recursive($injectorsClasses, $expectedInjectorsClasses), $injectorsClasses);
        $this->assertCount(count($expectedInjectorsClasses), $injectorsClasses);
    }
}
