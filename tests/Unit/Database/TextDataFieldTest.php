<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Database;

use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PHPUnit\Framework\TestCase;

class TextDataFieldTest extends TestCase
{
    /** @return array<string, array{string, string}> */
    public function providerTransformPerformTrim(): array
    {
        return [
            'simple text' => ['foo', 'foo'],
            'trim stpaces' => ['  foo  ', 'foo'],
            'trim tab' => ["\tfoo\t", 'foo'],
            'trim LF' => ["\nfoo\n", 'foo'],
            'trim CR' => ["\rfoo\r", 'foo'],
            'trim CR LF' => ["\r\nfoo\r\n", 'foo'],
            'trim NBSP' => [html_entity_decode('&nbsp;') . 'foo' . html_entity_decode('&nbsp;'), 'foo'],
        ];
    }

    /**
     * @param string $input
     * @param string $expected
     * @dataProvider providerTransformPerformTrim
     */
    public function testTransformPerformTrim(string $input, string $expected): void
    {
        $field = new TextDataField('foo');
        $this->assertSame($expected, $field->transform($input));
    }
}
