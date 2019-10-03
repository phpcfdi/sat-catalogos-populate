<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Database;

use PDOException;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\DataTableGateway;
use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PHPUnit\Framework\TestCase;

class DataTableGatewayTest extends TestCase
{
    /** @var Repository */
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new Repository(':memory:');
    }

    public function testDataTableRecreate(): void
    {
        $dataFields = new DataFields([
            new TextDataField('id'),
        ]);
        $dataTable = new DataTable('unique', $dataFields);

        $gateway = new DataTableGateway($dataTable, $this->repository);
        $gateway->recreate();
        $this->assertTrue($this->repository->hasTable('unique'));
    }

    public function testDataTableInsertRecord(): void
    {
        $dataFields = new DataFields([
            new TextDataField('id'),
            new TextDataField('description'),
        ]);
        $dataTable = new DataTable('records', $dataFields);

        $gateway = new DataTableGateway($dataTable, $this->repository);
        $gateway->create();
        $this->assertTrue($this->repository->hasTable('records'));

        $input = ['foo', 'This is foo!'];
        $record = $dataFields->transform($input);
        $gateway->insert($record);
        $this->assertSame(1, $this->repository->getRecordCount('records'));

        foreach (range(1, 9) as $i) {
            $gateway->insert($dataFields->transform(["X$i", "This is bar $i"]));
        }
        $this->assertSame(10, $this->repository->getRecordCount('records'));

        $sql = 'select * from records where (id = :id);';
        $retrieved = $this->repository->queryRow($sql, ['id' => 'X5']);
        $this->assertEquals(['id' => 'X5', 'description' => 'This is bar 5'], $retrieved);
    }

    public function testPrimaryKeyIsHonored(): void
    {
        $dataFields = new DataFields([
            new TextDataField('id'),
            new TextDataField('description'),
        ]);
        $dataTable = new DataTable('records', $dataFields);
        $gateway = new DataTableGateway($dataTable, $this->repository);
        $gateway->create();

        $record = $dataFields->transform(['A', 'This is a record']);
        $gateway->insert($record);

        $this->expectException(PDOException::class);
        $gateway->insert($record);
    }

    public function testNoPrimaryKeyIsHonored(): void
    {
        $dataFields = new DataFields([
            new TextDataField('id'),
            new TextDataField('description'),
        ]);
        $dataTable = new DataTable('records', $dataFields, [], true);
        $gateway = new DataTableGateway($dataTable, $this->repository);
        $gateway->create();

        $record = $dataFields->transform(['A', 'This is a record']);
        $gateway->insert($record);
        $gateway->insert($record);

        $sql = 'SELECT COUNT(*) FROM records;';
        $this->assertEquals(2, $this->repository->queryOne($sql));
    }
}
