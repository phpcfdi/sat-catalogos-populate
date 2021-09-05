<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features\Origins;

use PhpCfdi\SatCatalogosPopulate\Origins\OriginInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginsIO;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginsTranslator;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class OriginsReaderTest extends TestCase
{
    public function testReadOriginsFromFile(): void
    {
        $sourcefile = $this->utilFilePath('origins/custom-origins.xml');
        $this->assertFileExists($sourcefile, "The file $sourcefile does not exists and is required for testing");

        $reader = new OriginsIO();
        $origins = $reader->readFile($sourcefile);

        $translator = new OriginsTranslator();
        $originsData = array_map(
            fn (OriginInterface $origin): array => $translator->originToArray($origin),
            $origins->all()
        );

        $expectedOrigins = [
            [
                'name' => 'Foo',
                'href' => 'http://example.com/foo.txt',
                'destination-file' => 'foo.txt',
                'last-update' => '2018-01-13T19:58:59+00:00',
            ],
            [
                'name' => 'Bar',
                'type' => 'scrap',
                'href' => 'http://example.com/bar',
                'link-text' => 'bar file',
                'destination-file' => 'bar.xls',
                'last-update' => '2017-12-31T18:00:00-06:00',
            ],
        ];

        $this->assertEquals(array_replace_recursive($originsData, $expectedOrigins), $originsData);
        $this->assertCount(2, $originsData);

        $exported = $reader->originsToString($origins);
        $this->assertStringEqualsFile($sourcefile, $exported);
    }
}
