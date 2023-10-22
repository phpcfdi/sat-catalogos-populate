<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Importers;

use PhpCfdi\SatCatalogosPopulate\Database\DataTable;
use PhpCfdi\SatCatalogosPopulate\Database\PreprocessDataField;
use PHPUnit\Framework\TestCase;

trait CheckDataTableTrait
{
    /**
     * @param DataTable $dataTable
     * @param string $tableName
     * @param array<string, class-string> $expectedClasses
     * @param string[] $ids
     * @return void
     */
    private function checkDataTable(DataTable $dataTable, string $tableName, array $expectedClasses, array $ids): void
    {
        /**
         * @var TestCase $this
         */
        // check expected table name
        $this->assertSame($tableName, $dataTable->name());

        // check expected fields
        $this->assertSame(array_keys($expectedClasses), $dataTable->fields()->keys());

        // check expected types
        foreach ($expectedClasses as $key => $classname) {
            $finalObject = $dataTable->fields()->get($key);
            while ($finalObject instanceof PreprocessDataField) {
                $finalObject = $finalObject->getNextDataField();
            }
            $this->assertInstanceOf($classname, $finalObject);
        }

        // check primary key
        $this->assertSame($ids, $dataTable->primaryKey());
    }
}
