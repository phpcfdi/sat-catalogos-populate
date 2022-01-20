<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Utils;

use RuntimeException;

/**
 * @param array<int, scalar> $input
 * @return array<int, scalar>
 */
function array_rtrim(array $input): array
{
    $count = count($input);
    while ($count > 0 && '' === strval($input[$count - 1])) {
        array_pop($input);
        $count = $count - 1;
    }

    return $input;
}

/**
 * @throws RuntimeException Cannot create a temporary file name
 */
function tempname(string $dir = '', string $prefix = ''): string
{
    /** @noinspection PhpUsageOfSilenceOperatorInspection */
    $tempname = @tempnam($dir, $prefix);
    if (false === $tempname) {
        throw new RuntimeException('Cannot create a temporary file name');
    }
    return $tempname;
}

/**
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
