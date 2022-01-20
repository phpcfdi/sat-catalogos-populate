<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features\Converters;

use PhpCfdi\SatCatalogosPopulate\Converters\XlsToCsvFolderConverter;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

use function PhpCfdi\SatCatalogosPopulate\Utils\tempdir;

class XlsToCsvFolderConverterTest extends TestCase
{
    public function testConvertWithSampleFiles(): void
    {
        // given a known xls file
        $source = $this->utilFilePath('FooSample.xls');
        $destination = tempdir($this->utilFilePath('tmp'));

        // when convert to csv files in a destination
        $converter = new XlsToCsvFolderConverter();
        $converter->convert($source, $destination);

        // then the expected files exist
        $this->assertFileEquals($this->utilFilePath('splitted/Foo_Parte_1.csv'), $destination . '/Foo_Parte_1.csv');
        $this->assertFileEquals($this->utilFilePath('splitted/Foo_Parte_2.csv'), $destination . '/Foo_Parte_2.csv');
        $this->assertFileEquals($this->utilFilePath('splitted/ExpectedFoo.csv'), $destination . '/Foo.csv');

        // cleanup the temp folder
        $this->addFileToCleanUp(...(glob($destination . '/*.csv') ?: []));
        $this->addFileToCleanUp($destination);
    }
}
