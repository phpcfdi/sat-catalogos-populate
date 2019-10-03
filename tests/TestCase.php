<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests;

use finfo;
use function PhpCfdi\SatCatalogosPopulate\Utils\tempname;

class TestCase extends \PHPUnit\Framework\TestCase
{
    use FilesToCleanUpTrait;

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->cleanUpFiles();
    }

    public function utilFilePath(string $append)
    {
        return __DIR__ . '/_files/' . ltrim($append, '/');
    }

    public function utilTempname(): string
    {
        $name = tempname($this->utilFilePath(''), '');
        unlink($name);
        return $name;
    }

    public function utilMimeType(string $filename)
    {
        return (new finfo())->file($filename, FILEINFO_MIME_TYPE);
    }
}
