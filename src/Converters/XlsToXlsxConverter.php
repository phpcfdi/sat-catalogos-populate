<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Converters;

use LogicException;
use PhpCfdi\SatCatalogosPopulate\Utils\ShellExec;
use RuntimeException;
use function PhpCfdi\SatCatalogosPopulate\Utils\tempdir;
use PhpCfdi\SatCatalogosPopulate\Utils\WhichTrait;

class XlsToXlsxConverter
{
    use WhichTrait;

    /** @var string Location of soffice executable */
    private $sofficePath;

    public function __construct(string $sofficePath = '')
    {
        if ('' === $sofficePath) {
            $sofficePath = $this->which('soffice');
        }
        $this->sofficePath = $sofficePath;
    }

    public function sofficePath(): string
    {
        return $this->sofficePath;
    }

    public function convert(string $source, string $destination): void
    {
        if (! file_exists($source) || is_dir($source) || ! is_readable($source)) {
            throw new RuntimeException("File $source does not exists");
        }

        $destinationDir = dirname($destination);
        $this->checkDirectory($destinationDir);

        $tempdir = tempdir();
        $this->checkDirectory($tempdir);
        $outfile = $tempdir . DIRECTORY_SEPARATOR . basename($source) . 'x';
        if (file_exists($outfile)) {
            throw new RuntimeException("File $destination must not exists");
        }

        $command = escapeshellarg($this->sofficePath()) . ' ' . implode(' ', array_map('escapeshellarg', [
            '--headless',
            '--nolockcheck',
            '--convert-to',
            'xlsx',
            '--outdir',
            $tempdir,
            $source,
        ]));

        $execution = ShellExec::run($command);
        if (0 !== $execution->exitStatus()) {
            throw new RuntimeException(
                "Execution of soffice convertion return a non zero status code [{$execution->exitStatus()}]"
            );
        }

        if (! file_exists($outfile)) {
            throw new RuntimeException("File $outfile was not created, are other soffice instances running?");
        }

        rename($outfile, $destination);
        rmdir($tempdir);
    }

    private function checkDirectory(string $directory): void
    {
        if ('' === $directory) {
            throw new LogicException('Directory path is empty');
        }
        if (! is_dir($directory)) {
            throw new RuntimeException("Path $directory is not a directory");
        }
        if (! is_writable($directory)) {
            throw new RuntimeException("Path $directory is not writable");
        }
    }
}
