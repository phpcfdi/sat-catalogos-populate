<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Utils;

use RuntimeException;

trait WhichTrait
{
    public function which(string $executable): string
    {
        $wichPath = '/usr/bin/which';
        if (! is_file($wichPath) || ! is_executable($wichPath)) {
            throw new RuntimeException('Cannot find which command');
        }
        return trim((string) shell_exec(implode(' ', [
            escapeshellarg($wichPath),
            escapeshellarg($executable),
        ])));
    }
}
