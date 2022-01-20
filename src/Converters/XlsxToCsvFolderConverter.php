<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Converters;

use PhpCfdi\SatCatalogosPopulate\Utils\ShellExec;
use PhpCfdi\SatCatalogosPopulate\Utils\WhichTrait;
use RuntimeException;

class XlsxToCsvFolderConverter
{
    use WhichTrait;

    /** @var string Location of xlsx2csvPath executable */
    private string $xlsx2csvPath;

    public function __construct(string $xlsx2csvPath = '')
    {
        if ('' === $xlsx2csvPath) {
            $xlsx2csvPath = $this->which('xlsx2csv');
        }
        $this->xlsx2csvPath = $xlsx2csvPath;
    }

    public function xlsx2csvPath(): string
    {
        return $this->xlsx2csvPath;
    }

    public function convert(string $source, string $destination): void
    {
        if ('' === $destination) {
            throw new RuntimeException('Destination is empty');
        }
        if (! is_dir($destination) || ! is_writable($destination)) {
            throw new RuntimeException("Destination directory $destination is not a directory or is not writable");
        }

        $command = escapeshellarg($this->xlsx2csvPath()) . ' ' . implode(' ', array_map('escapeshellarg', [
            '--ignoreempty',
            '--escape',
            '--all',
            '--dateformat',
            '%Y-%m-%d',
            $source,
            $destination,
        ]));

        $execution = ShellExec::run($command);
        if (0 !== $execution->exitStatus()) {
            throw new RuntimeException(
                "Execution of xlsx2csv convertion return a non zero status code [{$execution->exitStatus()}]"
            );
        }
    }
}
