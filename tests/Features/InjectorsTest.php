<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features;

use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\Importers\Cfdi\Injectors\Aduanas;
use PhpCfdi\SatCatalogosPopulate\Injectors;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use Psr\Log\NullLogger;

class InjectorsTest extends TestCase
{
    public function testInjectorCanInjectAWellKnownSourceFile(): void
    {
        $csvFolder = $this->utilFilePath('cfdi/');
        $repository = new Repository(':memory:');

        $injector = new Injectors([new Aduanas($csvFolder . '/c_Aduana.csv')]);
        $injector->validate();
        $injector->inject($repository, new NullLogger());

        $this->assertTrue($repository->hasTable('cfdi_aduanas'));
        $this->assertGreaterThan(0, $repository->getRecordCount('cfdi_aduanas'));
    }
}
