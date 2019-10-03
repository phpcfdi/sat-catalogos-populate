<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Database;

use InvalidArgumentException;
use PhpCfdi\SatCatalogosPopulate\Database\DataFieldInterface;
use PhpCfdi\SatCatalogosPopulate\Database\DataFields;
use PhpCfdi\SatCatalogosPopulate\Database\TextDataField;
use PHPUnit\Framework\TestCase;
use stdClass;
use UnexpectedValueException;

class DataFieldsTest extends TestCase
{
    public function testCreateObjectWithAnArrayOfDataFields(): void
    {
        $dataFields = new DataFields([
            $fieldA = new TextDataField('id'),
            $fieldB = new TextDataField('description'),
        ]);

        $this->assertCount(2, $dataFields);
        $this->assertSame($fieldA, $dataFields->get('id'));
        $this->assertSame($fieldB, $dataFields->get('description'));
    }

    public function testCreateWithoutElements(): void
    {
        $dataFields = new DataFields([]);
        $this->assertCount(0, $dataFields);
    }

    public function testCreateWithNonDataFieldElements(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('There is a datafield with invalid type');
        /** @var DataFieldInterface&stdClass $fake Override declaration to force phpstan pass */
        $fake = new stdClass();
        new DataFields([$fake]);
    }

    public function testGetWithNonExistentElement(): void
    {
        $dataFields = new DataFields([]);

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The data field with name foo does not exists');
        $dataFields->get('foo');
    }

    public function testInputTransformation(): void
    {
        $input = [
            9,
            'foo bar',
            10000,
            '2018-05-04',
        ];
        $expected = [
            'id' => '09',
            'title' => 'foo bar',
            'amount' => '10000',
            'created_at' => '2018-05-04',
            'updated_at' => '',
        ];

        $dataFields = new DataFields([
            new TextDataField('id', function ($input) {
                return str_pad((string) $input, 2, '0', STR_PAD_LEFT);
            }),
            new TextDataField('title'),
            new TextDataField('amount'),
            new TextDataField('created_at'),
            new TextDataField('updated_at'),
        ]);

        $output = $dataFields->transform($input);

        foreach ($dataFields as $dataField) {
            $name = $dataField->name();
            $this->assertSame($expected[$name], $output[$name], "The output $name is not the expected");
        }
    }
}
