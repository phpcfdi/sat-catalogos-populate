<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers;

use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\Bancos;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\Estados;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\OrigenesRecursos;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\PeriodicidadesPagos;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\RiesgosPuestos;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\TiposContratos;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\TiposDeducciones;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\TiposHoras;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\TiposIncapacidades;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\TiposJornadas;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\TiposNominas;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\TiposOtrosPagos;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\TiposPercepciones;
use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\TiposRegimenes;
use PhpCfdi\SatCatalogosPopulate\Importers\NominaCatalogs;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class NominaCatalogsTest extends TestCase
{
    /**
     * @see NominaCatalogs::createInjectors()
     */
    public function testContainsAllAndOnlyThisInjectorsByDefault(): void
    {
        $expectedInjectorsClasses = [
            Bancos::class,
            Estados::class,
            OrigenesRecursos::class,
            PeriodicidadesPagos::class,
            TiposContratos::class,
            TiposDeducciones::class,
            TiposHoras::class,
            TiposIncapacidades::class,
            TiposJornadas::class,
            TiposNominas::class,
            TiposOtrosPagos::class,
            TiposPercepciones::class,
            TiposRegimenes::class,
            RiesgosPuestos::class,
        ];

        $importer = new NominaCatalogs();
        $injectors = $importer->createInjectors('');

        $injectorsClasses = array_map(fn ($item) => $item::class, $injectors->all());

        $this->assertEquals(array_replace_recursive($injectorsClasses, $expectedInjectorsClasses), $injectorsClasses);
        $this->assertCount(count($expectedInjectorsClasses), $injectorsClasses);
    }
}
