<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Database;

use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Database\UsePreviousIfEmptyDataField;
use PHPUnit\Framework\TestCase;

final class UsePreviousIfEmptyDataFieldTest extends TestCase
{
    public function testUsePreviousIfEmptyDataField(): void
    {
        $dataField = new UsePreviousIfEmptyDataField(new TextDataField('foo'));

        $inputs = [
            'first',
            '',
            '',
            'second',
            'third',
            '',
        ];
        $expected = [
            'first',
            'first',
            'first',
            'second',
            'third',
            'third',
        ];

        $result = array_map(
            static fn (mixed $input): string => (string) $dataField->transform($input),
            $inputs,
        );

        $this->assertSame($expected, $result);
    }
}
