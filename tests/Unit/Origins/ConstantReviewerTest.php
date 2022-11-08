<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Unit\Origins;

use LogicException;
use PhpCfdi\SatCatalogosPopulate\Origins\ConstantOrigin;
use PhpCfdi\SatCatalogosPopulate\Origins\ConstantReviewer;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\ResourcesGatewayInterface;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class ConstantReviewerTest extends TestCase
{
    private ConstantReviewer $reviewer;

    protected function setUp(): void
    {
        parent::setUp();
        $gateway = $this->createMock(ResourcesGatewayInterface::class);
        $this->reviewer = new ConstantReviewer($gateway);
    }

    public function testAcceptsWithValidObject(): void
    {
        $origin = new ConstantOrigin('Foo', 'https://foo/foo');
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
        $this->expectExceptionMessage('This reviewer can only handle ConstantOrigin objects');
        $this->reviewer->review($origin);
    }
}
