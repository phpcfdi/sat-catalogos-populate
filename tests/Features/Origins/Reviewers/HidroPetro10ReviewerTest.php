<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features\Origins\Reviewers;

use PhpCfdi\SatCatalogosPopulate\Origins\ResourcesGatewayInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\Reviewers\HidroPetro10Reviewer;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;

#[AllowMockObjectsWithoutExpectations]
final class HidroPetro10ReviewerTest extends TestCase
{
    public function testReviewerCanObtainTheUrlToDownload(): void
    {
        $gateway = $this->createMock(ResourcesGatewayInterface::class);
        $reviewer = new HidroPetro10Reviewer($gateway);
        $url = $reviewer->obtainResourceUrl();
        $this->assertMatchesRegularExpression('#^https://.*/cat_Hidro_Y_Petro_10_.*xlsx$#', $url);
    }
}
