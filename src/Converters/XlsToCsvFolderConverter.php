<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Converters;

use function PhpCfdi\SatCatalogosPopulate\Utils\tempname;

class XlsToCsvFolderConverter
{
    public function convert(string $source, string $destination): void
    {
        $xlsxDestination = tempname();

        try {
            // convert from XLS to XLSX
            $xlsToXlsxConverter = new XlsToXlsxConverter();
            $xlsToXlsxConverter->convert($source, $xlsxDestination);

            // convert from XLSX to CSV
            $xlsxToCsvFolder = new XlsxToCsvFolderConverter();
            $xlsxToCsvFolder->convert($xlsxDestination, $destination);

            // join files that are in two or more files
            $joiner = new CsvFolderJoinFiles();
            $joiner->joinFilesInFolder($destination);
        } finally {
            unlink($xlsxDestination);
        }
    }
}
