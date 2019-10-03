<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Database;

use PhpCfdi\SatCatalogosPopulate\Database\DateDataField;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class DateDataFieldTest extends TestCase
{
    public function testTransformWithInvalidFormatThrowsException(): void
    {
        $field = new DateDataField('foo');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Para el campo foo la fecha now no pudo ser interpretada');
        $field->transform('now');
    }

    public function testTransformEmptyString(): void
    {
        $field = new DateDataField('foo');
        $this->assertSame('', $field->transform(''));
    }

    public function testTransformYearMonthDay(): void
    {
        $field = new DateDataField('foo');
        $this->assertSame('2017-02-01', $field->transform('2017-02-01'));
    }

    public function testTransformDayMonthYear(): void
    {
        $field = new DateDataField('foo');
        $this->assertSame('2017-02-01', $field->transform('1/2/2017'));
    }
}
