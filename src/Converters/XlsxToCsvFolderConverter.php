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
    private readonly string $xlsx2csvPath;

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

        $command = implode(' ', array_map('escapeshellarg', [
            $this->xlsx2csvPath(),
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
                "Execution of xlsx2csv conversion return a non zero status code [{$execution->exitStatus()}]"
            );
        }

        // remove spaces on exported file name
        $csvFiles = glob($destination . '/*.csv') ?: [];
        foreach ($csvFiles as $csvFile) {
            $this->removeTrailCommasOnFile($csvFile);

            $renamed = $destination . '/' . preg_replace('/\s*(.*?)\s*\.csv+/', '$1.csv', basename($csvFile));
            if (! file_exists($renamed) && $csvFile !== $renamed) {
                rename($csvFile, $renamed);
            }
        }
    }

    private function removeTrailCommasOnFile(string $csvFile): void
    {
        $command = implode(' ', array_map('escapeshellarg', [
            'sed',
            '--in-place',
            '--regexp-extended', 's/,+$//g',
            $csvFile,
        ]));

        $execution = ShellExec::run($command);
        if (0 !== $execution->exitStatus()) {
            throw new RuntimeException(
                "Remove trailing commas failed with code [{$execution->exitStatus()}] for file $csvFile"
            );
        }
    }
}
