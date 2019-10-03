<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Database;

use LogicException;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PHPUnit\Framework\TestCase;

class DataTableTest extends TestCase
{
    public function testDataTableRequiereNotEmptyDataFields(): void
    {
        $dataFields = new DataFields([]);
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('The data fields map must not be empty');
        new DataTable('foo', $dataFields);
    }

    public function testDataTableHasDataFields(): void
    {
        $dataFields = new DataFields([
            new TextDataField('id'),
        ]);
        $dataTable = new DataTable('foo', $dataFields);
        $this->assertSame($dataFields, $dataTable->fields());
    }

    public function testPrimaryKeySet(): void
    {
        $dataFields = new DataFields([
            new TextDataField('foo'),
            new TextDataField('bar'),
            new TextDataField('baz'),
        ]);
        $dataTable = new DataTable('table', $dataFields, ['bar', 'baz']);
        $this->assertSame(['bar', 'baz'], $dataTable->primaryKey());
    }

    public function testDefaultPrimaryKey(): void
    {
        $dataFields = new DataFields([
            new TextDataField('foo'),
            new TextDataField('bar'),
            new TextDataField('baz'),
        ]);
        $dataTable = new DataTable('table', $dataFields);
        $this->assertSame(['foo'], $dataTable->primaryKey());
    }

    public function testNoPrimaryKey(): void
    {
        $dataFields = new DataFields([
            new TextDataField('foo'),
            new TextDataField('bar'),
            new TextDataField('baz'),
        ]);
        $dataTable = new DataTable('table', $dataFields, [], true);
        $this->assertSame([], $dataTable->primaryKey());
    }
}
