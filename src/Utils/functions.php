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

function file_extension(string $filename): string
{
    return substr(strrchr(basename($filename), '.') ?: '', 1) ?: '';
}

function file_extension_replace(string $filename, string $extension): string
{
    $current = file_extension($filename);
    if ('' === $current) {
        $dot = '.';
        if ('.' === substr($filename, -1)) {
            $dot = '';
        }
        return $filename . $dot . $extension;
    }
    return substr($filename, 0, - (strlen($current) + 1)) . '.' . $extension;
}
