<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Fixtures;

use PhpCfdi\SatCatalogosPopulate\AbstractXlsOneSheetImporter;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;

class FakeXlsOneSheetImporter extends AbstractXlsOneSheetImporter
{
    public function sheetName(): string
    {
        return 'Foo';
    }

    public function createInjector(string $csvFile): InjectorInterface
    {
        return new FakeXlsOneSheetInjector($csvFile);
    }
}
