<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Origins;

use LogicException;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\ResourcesGatewayInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\ScrapingOrigin;
use PhpCfdi\SatCatalogosPopulate\Origins\ScrapingReviewer;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class ScrapingReviewerTest extends TestCase
{
    private ScrapingReviewer $reviewer;

    protected function setUp(): void
    {
        parent::setUp();
        $gateway = $this->createMock(ResourcesGatewayInterface::class);
        $this->reviewer = new ScrapingReviewer($gateway);
    }

    public function testAcceptsWithValidObject(): void
    {
        $origin = new ScrapingOrigin('Foo', 'https://foo/', 'foo.txt', 'foo');
        $this->assertTrue($this->reviewer->accepts($origin));
    }

    public function testAcceptsWithInvalidObject(): void
    {
        $origin = $this->createMock(OriginInterface::class);
        $this->assertFalse($this->reviewer->accepts($origin));
    }

    public function testReviewWithInvalidOrigin(): void
    {
        $origin = $this->createMock(OriginInterface::class);
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('This reviewer can only handle ScrapingOrigin objects');
        $this->reviewer->review($origin);
    }
}
