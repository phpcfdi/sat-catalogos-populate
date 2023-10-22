<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Database;

use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PhpCfdi\SatCatalogosPopulate\Database\ToBeDefinedDataField;
use PHPUnit\Framework\TestCase;

final class ToBeDefinedDataFieldTest extends TestCase
{
    public function testToBeDefined(): void
    {
        $input = 'por definir'; // do not match exact case
        $dataFiel = new ToBeDefinedDataField(new TextDataField('foo'));
        $this->assertTrue($dataFiel->matchToBeDefined($input));
        $this->assertFalse($dataFiel->matchToBeDefined(''));
        $this->assertSame('', $dataFiel->transform($input));
        $this->assertSame('xee', $dataFiel->transform('xee'));
    }
}
