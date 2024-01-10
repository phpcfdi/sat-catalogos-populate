<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Converters;

use ArrayIterator;
use Iterator;
use PhpCfdi\SatCatalogosPopulate\Converters\CsvFolderJoinFiles;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

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
        $first = $this->utilFilePath('splitted/Foo_Parte_1.csv');
        $second = $this->utilFilePath('splitted/Foo_Parte_2.csv');

        $this->assertSame(2, $joiner->findLinesToSkip($first, $second));
    }

    /** @return array<string, array{Iterator<string>, Iterator<string>}> */
    public static function providerFindLinesToSkipFromIterators(): array
    {
        return [
            'normal' => [
                new ArrayIterator([
                    'This is a sample file',
                    'id,description',
                    '123,"foo"',
                ]),
                new ArrayIterator([
                    'This is a sample file',
                    'id,description',
                    '987,"bar"',                            // this line first line that is different
                ]),
            ],
            'cell with spaces' => [
                new ArrayIterator([
                    'This is a sample file',
                    'id,description',
                    '123,"foo"',
                ]),
                new ArrayIterator([
                    'This is a sample file',
                    ' id , description ',                   // this line have spaces
                    '987,"bar"',                            // this line first line that is different
                ]),
            ],
            'cell with double quotes and spaces' => [
                new ArrayIterator([
                    'This is a sample file',
                    'id,description',
                    '123,"foo"',
                ]),
                new ArrayIterator([
                    'This is a sample file',
                    '" id "," description "',               // this line have double quotes and spaces
                    '987,"bar"',                            // this line first line that is different
                ]),
            ],
            'row with empty cells at end' => [
                new ArrayIterator([
                    'This is a sample file',
                    'id,description',
                    '123,"foo"',
                ]),
                new ArrayIterator([
                    'This is a sample file',
                    'id,description, ," ",,,',              // this line have empty cells at end
                    '987,"bar"',                            // this line first line that is different
                ]),
            ],
        ];
    }

    /**
     * @param Iterator<string> $first
     * @param Iterator<string> $second
     */
    #[DataProvider('providerFindLinesToSkipFromIterators')]
    public function testFindLinesToSkipFromIterators(Iterator $first, Iterator $second): void
    {
        $joiner = new CsvFolderJoinFiles();
        $this->assertSame(2, $joiner->findLinesToSkipFromIterators($first, $second));
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
