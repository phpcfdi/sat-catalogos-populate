<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Utils;

use RuntimeException;

function array_rtrim(array $input): array
{
    $count = count($input);
    while ($count > 0 && '' === (string) $input[$count - 1]) {
        array_pop($input);
        $count = $count - 1;
    }

    return $input;
}

/**
 * @param string $dir
 * @param string $prefix
 * @return string
 * @throws RuntimeException Cannot create a temporary file name
 */
function tempname($dir = '', $prefix = ''): string
{
    /** @noinspection PhpUsageOfSilenceOperatorInspection */
    $tempname = @tempnam($dir, $prefix);
    if (false === $tempname) {
        throw new RuntimeException('Cannot create a temporary file name');
    }
    return $tempname;
}

/**
 * @param string $dir
 * @param string $prefix
 * @return string
 * @throws RuntimeException Cannot create a temporary file name
 */
function tempdir(string $dir = '', string $prefix = ''): string
{
    $dirname = tempname($dir, $prefix);
    if (file_exists($dirname)) {
        unlink($dirname);
    }
    mkdir($dirname);
    return $dirname;
}

function preg_is_valid(string $input): bool
{
    /** @noinspection PhpUsageOfSilenceOperatorInspection */
    return (false !== @preg_match('/' . $input . '/', ''));
}
