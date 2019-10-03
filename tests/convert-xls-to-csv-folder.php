<?php

declare(strict_types=1);

use PhpCfdi\SatCatalogosPopulate\Converters\XlsToCsvFolderConverter;
use function PhpCfdi\SatCatalogosPopulate\Utils\tempdir;

require __DIR__ . '/bootstrap.php';

exit(call_user_func(
    function (string $source, string $destination): int {
        try {
            if ('' === $source || is_dir($source) || ! is_readable($source)) {
                throw new RuntimeException("Source file not found $source");
            }
            $source = realpath($source) ?: '';
            if ('' === $destination || ! is_dir($destination) || ! is_writable($destination)) {
                throw new RuntimeException("Destination directory not found $destination");
            }
            $destination = realpath($destination) ?: '';
            echo "Converting XLS $source to $destination ... ";
            $converter = new XlsToCsvFolderConverter();
            $converter->convert($source, $destination);
            echo "done\n";
            return 0;
        } catch (Throwable $exception) {
            file_put_contents('php://stderr', $exception->getMessage() . PHP_EOL, FILE_APPEND);
            return 1;
        }
    },
    $argv[1] ?? '',
    $argv[2] ?? tempdir()
));
