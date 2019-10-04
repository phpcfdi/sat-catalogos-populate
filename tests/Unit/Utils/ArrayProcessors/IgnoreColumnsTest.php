<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Utils\ArrayProcessors;

use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\IgnoreColumns;

class IgnoreColumnsTest extends TestCase
{
    public function testProcessorIgnoreColumns(): void
    {
        $specimen = [0, 1, 2, 3, 4, 5];
        $expected = [1, 2, 4];
        $processor = new IgnoreColumns(null, 0, 3, 5);
        $this->assertSame($expected, $processor->execute($specimen));
    }
}
