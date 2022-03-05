<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers;

use PhpCfdi\SatCatalogosPopulate\Importers\Nomina\Injectors\Estados;
use PhpCfdi\SatCatalogosPopulate\Importers\NominaEstadosCatalogs;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class NominaEstadosCatalogsTest extends TestCase
{
    /**
     * @see NominaCatalogs::createInjectors()
     */
    public function testContainsAllAndOnlyThisInjectorsByDefault(): void
    {
        $expectedInjectorsClasses = [
            Estados::class,
        ];

        $importer = new NominaEstadosCatalogs();
        $injectors = $importer->createInjectors('');

        $injectorsClasses = array_map(fn ($item) => $item::class, $injectors->all());

        $this->assertEquals(array_replace_recursive($injectorsClasses, $expectedInjectorsClasses), $injectorsClasses);
        $this->assertCount(count($expectedInjectorsClasses), $injectorsClasses);
    }
}
