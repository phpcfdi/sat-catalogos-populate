<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Utils;

use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\RightTrim;
use PhpCfdi\SatCatalogosPopulate\Utils\CsvFile;
use RuntimeException;

class CsvFileTest extends TestCase
{
    public function testConstructor(): void
    {
        $csvFile = new CsvFile($this->utilFilePath('sample.csv'));
        $this->assertSame(0, $csvFile->position());
    }

    public function testConstructorWithNonExistentFilename(): void
    {
        $this->expectException(RuntimeException::class);
        new CsvFile($this->utilFilePath('non-existent.csv'));
    }

    public function testConstructorWithEmptyFilename(): void
    {
        $this->expectException(RuntimeException::class);
        new CsvFile($this->utilFilePath(''));
    }

    public function testConstructorWithDirectoryAsFilename(): void
    {
        $this->expectException(RuntimeException::class);
        new CsvFile('');
    }

    public function testOpenAndMoveToOne(): void
    {
        $csv = new CsvFile($this->utilFilePath('sample.csv'));
        $csv->move(1);

        $this->assertSame('1001', $csv->readLine()[0]);
    }

    public function testMoveNextOneByOne(): void
    {
        $csv = new CsvFile($this->utilFilePath('sample.csv'));
        $csv->next();
        $this->assertSame(1, $csv->position());
        $csv->next();
        $this->assertSame(2, $csv->position());
        $csv->next();
        $this->assertSame(3, $csv->position());
    }

    public function testMoveForwardFive(): void
    {
        $csv = new CsvFile($this->utilFilePath('sample.csv'));
        $csv->next(5);
        $this->assertSame(5, $csv->position());
    }

    public function testMovePreviousOneByOne(): void
    {
        $csv = new CsvFile($this->utilFilePath('sample.csv'));
        $csv->next(5);
        $csv->previous();
        $this->assertSame(4, $csv->position());
        $csv->previous();
        $this->assertSame(3, $csv->position());
        $csv->previous();
        $this->assertSame(2, $csv->position());
    }

    public function testMoveBackwardFive(): void
    {
        $csv = new CsvFile($this->utilFilePath('sample.csv'));
        $csv->next(5);
        $this->assertSame(5, $csv->position());
        $csv->previous(3);
        $this->assertSame(2, $csv->position());
    }

    public function testMoveBeyondEndOfFile(): void
    {
        $csv = new CsvFile($this->utilFilePath('sample.csv'));
        $csv->next(50);
        $this->assertTrue($csv->eof());
    }

    public function testMoveBeyondBeginOfFile(): void
    {
        $csv = new CsvFile($this->utilFilePath('sample.csv'));
        $csv->next(5);
        $csv->previous(50);
        $this->assertFalse($csv->eof());
        $this->assertSame(0, $csv->position());
    }

    public function testReadLine(): void
    {
        $expected = ['id', 'name', 'description', 'date'];
        $csv = new CsvFile($this->utilFilePath('sample.csv'), new RightTrim());

        $contents = $csv->readLine();
        $this->assertEquals($expected, $contents);
        $this->assertSame(0, $csv->position());

        $this->assertEquals($expected, $csv->readLine());
    }

    public function testIterator(): void
    {
        $expectedFirst = ['id', 'name', 'description', 'date'];
        $expectedLast = ['1006', 'foo 6', 'same "data", see?', '2018-01-06'];
        $csv = new CsvFile($this->utilFilePath('sample.csv'), new RightTrim());

        $count = 0;
        $first = [];
        $last = [];
        foreach ($csv as $line) {
            if (0 === $count) {
                $first = $line;
            }
            $count = $count + 1;
            $last = $line;
        }

        $this->assertSame(7, $count);
        $this->assertEquals($expectedFirst, $first);
        $this->assertEquals($expectedLast, $last);
    }
}
