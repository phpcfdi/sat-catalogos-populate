<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Converters;

use PhpCfdi\SatCatalogosPopulate\Converters\CsvFolderJoinFiles;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use function PhpCfdi\SatCatalogosPopulate\Utils\tempname;

class CsvFolderJoinFilesTest extends TestCase
{
    public function testObtainFilesThatAreSplitted(): void
    {
        $joiner = new CsvFolderJoinFiles();
        $csvFolder = $this->utilFilePath('splitted');

        $expected = [
            $csvFolder . '/Bar.csv' => [
                $csvFolder . '/Bar (Parte 1).csv',
                $csvFolder . '/Bar (Parte 2).csv',
            ],
            $csvFolder . '/Foo.csv' => [
                $csvFolder . '/Foo_Parte_1.csv',
                $csvFolder . '/Foo_Parte_2.csv',
            ],
            $csvFolder . '/Only_One_File.csv' => [
                $csvFolder . '/Only_One_File_1.csv',
            ],
            $csvFolder . '/Untrimmed.csv' => [
                $csvFolder . '/Untrimmed_1 .csv',
                $csvFolder . '/ Untrimmed_2.csv',
                $csvFolder . '/ Untrimmed_3 .csv',
            ],
            $csvFolder . '/Xee.csv' => [
                $csvFolder . '/Xee_1.csv',
                $csvFolder . '/Xee_2.csv',
            ],
        ];

        $files = $joiner->obtainFilesThatAreSplitted($csvFolder);

        $this->assertSame($expected, $files);
    }

    public function testFindLinesToSkip(): void
    {
        $joiner = new CsvFolderJoinFiles();
        $csvFolder = $this->utilFilePath('splitted');
        $first = $csvFolder . '/Foo_Parte_1.csv';
        $second = $csvFolder . '/Foo_Parte_2.csv';

        $this->assertSame(2, $joiner->findLinesToSkip($first, $second));
    }

    public function testJoinFilesToDestination(): void
    {
        $joiner = new CsvFolderJoinFiles();
        $csvFolder = $this->utilFilePath('splitted');
        $expectedFile = $this->utilFilePath('splitted/ExpectedFoo.csv');

        $files = $joiner->obtainFilesThatAreSplitted($csvFolder);
        $fooFiles = $files[$csvFolder . '/Foo.csv'];
        if (! is_array($fooFiles)) {
            $this->fail('Unexpected response from method obtainFilesThatAreSplitted');
            return;
        }

        $destination = tempname();
        $this->addFileToCleanUp($destination);
        $joiner->joinFilesToDestination($fooFiles, $destination);

        $this->assertFileEquals($expectedFile, $destination);
    }

    public function testJoinFilesInFolder(): void
    {
        $joiner = new CsvFolderJoinFiles();
        $csvFolder = $this->utilFilePath('splitted');
        $expectedFile = $this->utilFilePath('splitted/ExpectedFoo.csv');
        $createdFooFile = $this->utilFilePath('splitted/Foo.csv');
        $createdFiles = [
            $createdFooFile,
            $this->utilFilePath('splitted/Bar.csv'),
            $this->utilFilePath('splitted/Xee.csv'),
            $this->utilFilePath('splitted/Only_One_File.csv'),
        ];
        $this->addFileToCleanUp(...$createdFiles);

        $joiner->joinFilesInFolder($csvFolder);
        $this->assertFileEquals($expectedFile, $createdFooFile);

        // run a second time does not append to existing file
        $joiner->joinFilesInFolder($csvFolder);
        $this->assertFileEquals($expectedFile, $createdFooFile);
    }
}
