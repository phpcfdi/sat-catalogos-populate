<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests;

trait FilesToCleanUpTrait
{
    /** @var string[] */
    private $filesToCleanUp = [];

    public function cleanUpFiles(): void
    {
        $dirs = [];
        $files = [];

        foreach ($this->filesToCleanUp() as $path) {
            if (file_exists($path)) {
                if (is_dir($path)) {
                    $dirs[] = $path;
                } else {
                    $files[] = $path;
                }
            }
        }

        foreach ($files as $file) {
            unlink($file);
        }

        foreach ($dirs as $directory) {
            rmdir($directory);
        }
    }

    /**
     * @return string[]
     */
    public function filesToCleanUp(): array
    {
        return $this->filesToCleanUp;
    }

    /**
     * @param string ...$path
     */
    public function addFileToCleanUp(string ...$path): void
    {
        foreach ($path as $item) {
            $this->filesToCleanUp[] = rtrim($item, DIRECTORY_SEPARATOR);
        }
    }
}
