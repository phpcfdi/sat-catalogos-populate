<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features\Origins;

use PhpCfdi\SatCatalogosPopulate\Origins\ConstantOrigin;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginsIO;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class OriginsReaderTest extends TestCase
{
    public function testReadOriginsFromFile(): void
    {
        $sourcefile = $this->utilFilePath('origins/origins.xml');
        $this->assertFileExists($sourcefile, "The file $sourcefile does not exists and is required for testing");

        $reader = new OriginsIO();
        $origins = $reader->readFile($sourcefile);

        $origins = array_map(function (ConstantOrigin $origin) {
            return [
                'name' => $origin->name(),
                'url' => $origin->url(),
                'lastVersion' => $origin->lastVersion()->format('c'),
            ];
        }, $origins->all());

        $expectedOrigins = [
            ['name' => 'Foo', 'url' => 'http://example.com/foo.txt', 'lastVersion' => '2018-01-13T19:58:59+00:00'],
        ];

        $this->assertEquals(array_replace_recursive($origins, $expectedOrigins), $origins);
        $this->assertCount(3, $origins);
    }
}
