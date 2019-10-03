<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Utils;

use function PhpCfdi\SatCatalogosPopulate\Utils\file_extension_replace;
use PHPUnit\Framework\TestCase;

class FileExtensionReplaceTest extends TestCase
{
    /**
     * @param string $filename
     * @param string $extension
     * @param string $expected
     * @testWith ["foo.bar", "baz", "foo.baz"]
     *           ["/a/b/c/foo.bar", "baz", "/a/b/c/foo.baz"]
     *           ["dir/foo.bar", "baz", "dir/foo.baz"]
     *           [".foo", "baz", ".baz"]
     *           ["foo", "baz", "foo.baz"]
     *           ["gee.foo.bar", "baz", "gee.foo.baz"]
     *           ["foo.", "baz", "foo.baz"]
     *           ["foo..xxx", "baz", "foo..baz"]
     *           ["foo..", "baz", "foo..baz"]
     *           ["", "baz", ".baz"]
     *           [".", "baz", ".baz"]
     *           ["dir/foo.bar", "xee.baz", "dir/foo.xee.baz"]
     */
    public function testFileExtensionReplace(string $filename, string $extension, string $expected): void
    {
        $this->assertSame($expected, file_extension_replace($filename, $extension));
    }
}
