<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features\Origins;

use PhpCfdi\SatCatalogosPopulate\Origins\OriginInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginsIO;
use PhpCfdi\SatCatalogosPopulate\Origins\Translator;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

final class OriginsReaderTest extends TestCase
{
    public function testReadOriginsFromFile(): void
    {
        /** @see tests/_files/origins/custom-origins.xml */
        $sourcefile = $this->utilFilePath('origins/custom-origins.xml');
        $this->assertFileExists($sourcefile, "The file $sourcefile does not exists and is required for testing");

        $reader = new OriginsIO();
        $origins = $reader->readFile($sourcefile);

        $translator = Translator::create();
        $originsData = array_map(
            fn (OriginInterface $origin): array => $translator->originToArray($origin),
            $origins->all(),
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
                'link-position' => 1,
            ],
            [
                'type' => 'nomina12e',
                'destination-file' => 'nomina.xls',
                'last-update' => '2026-01-01T01:00:00-06:00',
            ],
            [
                'type' => 'hidropetro10',
                'destination-file' => 'hidropetro10.xls',
                'last-update' => '2026-01-01T02:00:00-06:00',
            ],
        ];

        $this->assertEquals(array_replace_recursive($originsData, $expectedOrigins), $originsData);
        $this->assertCount(4, $originsData);

        $exported = $reader->originsToString($origins);
        $this->assertStringEqualsFile($sourcefile, $exported);
    }
}
