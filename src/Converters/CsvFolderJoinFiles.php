<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Converters;

use Iterator;
use SplFileObject;

class CsvFolderJoinFiles
{
    public function joinFilesInFolder(string $csvFolder): void
    {
        $destinations = $this->obtainFilesThatAreSplitted($csvFolder);

        foreach ($destinations as $destination => $files) {
            $this->joinFilesToDestination(array_values($files), $destination);
        }
    }

    /**
     * @param array<int, string> $files
     */
    public function joinFilesToDestination(array $files, string $destination): void
    {
        $skipFirstLines = 0;
        $firstSource = $files[0];
        file_put_contents($destination, ''); // clear the file contents
        foreach ($files as $i => $source) {
            if ($i > 0 && 0 === $skipFirstLines) {
                $skipFirstLines = $this->findLinesToSkip($firstSource, $source);
            }
            $skipLastLines = 0;
            if ($this->lastLineContains($source, ['Continúa en'])) {
                $skipLastLines = 1;
            }
            $this->writeLines($source, $destination, $skipFirstLines, $skipLastLines);
        }
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function obtainFilesThatAreSplitted(string $csvFolder): array
    {
        $files = array_filter(
            array_map(
                function ($path): array {
                    $file = basename($path);
                    $matches = [];
                    if (
                        ! preg_match('/^ *(.+)_Parte_([0-9]+) *\.csv$/', $file, $matches)
                        && ! preg_match('/^ *(.+) \(Parte ([0-9]+)\) *\.csv$/', $file, $matches)
                        && ! preg_match('/^ *(.+)_([0-9]+) *\.csv$/', $file, $matches)
                    ) {
                        return [];
                    }
                    return [
                        'destination' => dirname($path) . '/' . trim($matches[1]) . '.csv',
                        'index' => (int) $matches[2],
                        'source' => $path,
                    ];
                },
                glob($csvFolder . '/*.csv') ?: []
            )
        );

        uasort($files, $this->compareFiles(...));

        $destinations = [];
        foreach ($files as $file) {
            $destinations[strval($file['destination'])][] = strval($file['source']);
        }

        return $destinations;
    }

    /**
     * @param array{destination: string, index: int} $first
     * @param array{destination: string, index: int} $second
     */
    private function compareFiles(array $first, array $second): int
    {
        return ($first['destination'] <=> $second['destination']) ?: $first['index'] <=> $second['index'];
    }

    public function writeLines(string $source, string $destination, int $skipFirstLines, int $skipLastLines): void
    {
        $command = implode(' ', [
            'cat ' . escapeshellarg($source),                   // send the file to the pipes
            sprintf('| tail -n +%d', $skipFirstLines + 1),      // without firsts n lines
            sprintf('| head -n -%d', $skipLastLines),           // without last n lines
            '>> ' . escapeshellarg($destination),                // create/append to destination
        ]);
        shell_exec($command);
    }

    public function findLinesToSkip(string $firstPath, string $secondPath): int
    {
        $first = new SplFileObject($firstPath, 'r');
        $second = new SplFileObject($secondPath, 'r');

        $firstTenLines = $this->splReadTenLines($first);
        $secondTenLines = $this->splReadTenLines($second);

        for ($i = 9; $i > 0; $i--) {
            $firstValue = $firstTenLines[$i] ?? null;
            $secondValue = $secondTenLines[$i] ?? null;
            if (null !== $firstValue && null !== $secondValue && $firstValue === $secondValue) {
                return $i + 1;
            }
        }
        return 0;
    }

    /**
     * @param Iterator<string> $iterator
     * @return array<int, string>
     */
    private function splReadTenLines(Iterator $iterator): array
    {
        $result = [];
        $counter = 0;
        foreach ($iterator as $line) {
            $result[] = $this->splCurrentLinesNormalizeValue($line);
            $counter = $counter + 1;
            if (10 === $counter) {
                break;
            }
        }
        return $result;
    }

    private function splCurrentLinesNormalizeValue(string $current): string
    {
        return trim(implode(',', array_map('trim', explode(',', rtrim($current, ',')))));
    }

    /** @param string[] $searchterms */
    public function lastLineContains(string $filename, array $searchterms): bool
    {
        $lastline = $this->obtainFileLastLine($filename);
        foreach ($searchterms as $search) {
            if (str_contains($lastline, $search)) {
                return true;
            }
        }

        return false;
    }

    public function obtainFileLastLine(string $filename): string
    {
        $command = sprintf("tail -n 5 %s | grep -v '/^$/' | tail -n 1", escapeshellarg($filename));
        return shell_exec($command) ?: '';
    }
}
