<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features\Origins;

use DateTimeImmutable;
use PhpCfdi\SatCatalogosPopulate\Origins\Origin;
use PhpCfdi\SatCatalogosPopulate\Origins\Review;
use PhpCfdi\SatCatalogosPopulate\Origins\ReviewStatus;
use PhpCfdi\SatCatalogosPopulate\Origins\Upgrader;
use PhpCfdi\SatCatalogosPopulate\Origins\UrlResponse;
use PhpCfdi\SatCatalogosPopulate\Tests\Fixtures\Origins\FakeGateway;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;
use Psr\Log\NullLogger;

class UpgraderTest extends TestCase
{
    /** @var Upgrader */
    private $upgrader;

    /** @var DateTimeImmutable */
    private $lastModified;

    public function setUp(): void
    {
        parent::setUp();
        $gateway = new FakeGateway();
        $lastModified = new DateTimeImmutable('2017-06-06');
        $gateway->add(new UrlResponse('http://example.com/foo.txt', 200, $lastModified));
        $gateway->add(new UrlResponse('http://example.com/bar.txt', 200, $lastModified));
        $gateway->add(new UrlResponse('http://example.com/baz.txt', 200, $lastModified));
        $upgrader = new Upgrader($gateway, $this->utilFilePath('origins'), new NullLogger());

        $this->lastModified = $lastModified;
        $this->upgrader = $upgrader;
    }

    public function testUpgradeReviewNotUpdated(): void
    {
        $origin = new Origin('Foo', 'http://example.com/foo.txt', $this->lastModified->modify('-1 month'));
        $review = new Review($origin, ReviewStatus::notUpdated());

        $newOrigin = $this->upgrader->upgradeReview($review);

        $this->assertEquals($newOrigin->name(), $origin->name());
        $this->assertEquals($newOrigin->url(), $origin->url());
        $this->assertEquals($newOrigin->lastVersion(), $this->lastModified);
    }

    public function testUpgradeReviewUptodate(): void
    {
        $origin = new Origin('Foo', 'http://example.com/foo.txt', $this->lastModified->modify('-1 month'));
        $review = new Review($origin, ReviewStatus::uptodate());

        $newOrigin = $this->upgrader->upgradeReview($review);

        $this->assertEquals($newOrigin, $origin);
    }

    public function testUpgradeReviewNotFound(): void
    {
        $origin = new Origin('Foo', 'http://example.com/foo.txt', $this->lastModified->modify('-1 month'));
        $review = new Review($origin, ReviewStatus::notFound());

        $newOrigin = $this->upgrader->upgradeReview($review);

        $this->assertEquals($newOrigin, $origin);
    }

    public function testUpgrade(): void
    {
        $origins = $this->upgrader->upgrade();

        // it must contains the 3 origins
        $this->assertCount(3, $origins);

        // all 3 must be set to this test last modified value
        /** @var Origin $origin */
        foreach ($origins as $origin) {
            $this->assertEquals($this->lastModified, $origin->lastVersion());
        }
    }
}
