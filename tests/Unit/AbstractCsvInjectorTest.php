<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit;

use PhpCfdi\SatCatalogosPopulate\AbstractCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\InjectorInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\Fixtures\FakeCsvInjector;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use Psr\Log\NullLogger;
use RuntimeException;

class AbstractCsvInjectorTest extends TestCase
{
    public function testCreateFakeCsvInjector(): void
    {
        $injector = new FakeCsvInjector('');
        $this->assertInstanceOf(AbstractCsvInjector::class, $injector);
        $this->assertInstanceOf(InjectorInterface::class, $injector);
    }

    public function testPropertySourceFile(): void
    {
        $sourceFile = $this->utilFilePath('sample.csv');
        $injector = new FakeCsvInjector($sourceFile);

        $this->assertEquals($sourceFile, $injector->sourceFile());
    }

    public function testValidateWithValidSourcefile(): void
    {
        $injector = new FakeCsvInjector(__FILE__);
        $injector->validate();
        $this->assertTrue(true, 'The validate method did not create any exception');
    }

    public function providerInvalidSourcefiles()
    {
        return [
            'empty' => [''],
            'directory' => [__DIR__],
            'non existent' => ['non-existent'],
        ];
    }

    /**
     * @param string $sourceFile
     * @dataProvider providerInvalidSourcefiles
     */
    public function testValidateWithInvalidSourcefile(string $sourceFile): void
    {
        $injector = new FakeCsvInjector($sourceFile);
        $this->expectException(RuntimeException::class);
        $injector->validate();
    }

    public function testInject(): void
    {
        $repository = new Repository(':memory:');
        $injector = new FakeCsvInjector($this->utilFilePath('sample.csv'));
        $injected = $injector->inject($repository, new NullLogger());

        $first = [
            'id' => '1001',
            'name' => 'foo 1',
            'description' => 'same "data", see?',
            'date' => '2018-01-01',
        ];
        $retrieved = $repository->queryRow('select * from sample limit 1;');
        $this->assertSame($first, $retrieved);

        $expected = [
            0 => ['id' => '1001', 'name' => 'foo 1', 'description' => 'same "data", see?', 'date' => '2018-01-01'],
            2 => ['id' => '1003', 'name' => 'foo 3', 'description' => 'same "data", see?', 'date' => ''],
            5 => ['id' => '1006', 'name' => 'foo 6', 'description' => 'same "data", see?', 'date' => '2018-01-06'],
        ];

        $retrieved = $repository->queryArray('select * from sample;');
        $this->assertSame(
            array_replace_recursive($retrieved, $expected),
            $retrieved,
            'All expected elements are in the injected data'
        );
        $this->assertSame($expected[0], current($retrieved), 'The first element did match');
        $this->assertSame($expected[5], end($retrieved), 'The last element did match');
        $this->assertSame(6, $injected);
        $this->assertCount(6, $retrieved);
    }
}
