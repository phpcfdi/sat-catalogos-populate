<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Converters;

use InvalidArgumentException;
use PhpCfdi\SatCatalogosPopulate\Utils\ShellExec;
use PhpCfdi\SatCatalogosPopulate\Utils\WhichTrait;
use RuntimeException;

final readonly class XlsxToCsvFolderConverter implements ConverterInterface
{
    use WhichTrait;

    /** @param string $xlsx2csvPath Location of xlsx2csvPath executable */
    public function __construct(private string $xlsx2csvPath)
    {
        if ('' === $this->xlsx2csvPath) {
            throw new InvalidArgumentException('xlsx2csv path must not be empty.');
        }
    }

    public static function create(): self
    {
        $xlsx2csvPath = self::which('xlsx2csv');
        return new self($xlsx2csvPath);
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
                "Execution of xlsx2csv conversion return a non zero status code [{$execution->exitStatus()}]",
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
                "Remove trailing commas failed with code [{$execution->exitStatus()}] for file $csvFile",
            );
        }
    }
}
