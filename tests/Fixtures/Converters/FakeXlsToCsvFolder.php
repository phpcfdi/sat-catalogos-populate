<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Fixtures\Converters;

use PhpCfdi\SatCatalogosPopulate\Converters\XlsToCsvFolderConverter;

/**
 * This is a fake class that copy the testing files instead of performing a real convert
 */
class FakeXlsToCsvFolder extends XlsToCsvFolderConverter
{
    private $baseCsvFolder;

    public function __construct($baseCsvFolder)
    {
        $this->baseCsvFolder = $baseCsvFolder;
    }

    public function convert(string $source, string $destination): void
    {
        $baseCsvFiles = glob($this->baseCsvFolder . '/*.csv') ?: [];
        foreach ($baseCsvFiles as $baseCsvFile) {
            copy($baseCsvFile, $destination . '/' . basename($baseCsvFile));
        }
    }
}
