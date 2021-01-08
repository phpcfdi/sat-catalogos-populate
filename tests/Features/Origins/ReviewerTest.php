<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features\Origins;

use DateTimeImmutable;
use PhpCfdi\SatCatalogosPopulate\Origins\Origin;
use PhpCfdi\SatCatalogosPopulate\Origins\Reviewer;
use PhpCfdi\SatCatalogosPopulate\Origins\UrlResponse;
use PhpCfdi\SatCatalogosPopulate\Tests\Fixtures\Origins\FakeGateway;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class ReviewerTest extends TestCase
{
    /** @var Reviewer */
    private $reviewer;

    /** @var FakeGateway */
    private $resourcesGateway;

    protected function setUp(): void
    {
        $this->resourcesGateway = new FakeGateway();
        $this->reviewer = new Reviewer($this->resourcesGateway);
    }

    public function testReviewOriginWithUptodateResponse(): void
    {
        $this->resourcesGateway->add(
            new UrlResponse('http://example.com/foo.txt', 200, new DateTimeImmutable('2017-01-02'))
        );
        $origin = new Origin('Foo', 'http://example.com/foo.txt', new DateTimeImmutable('2017-01-02'));

        $review = $this->reviewer->review($origin);

        $this->assertSame($origin, $review->origin());
        $this->assertTrue($review->status()->isUptodate());
    }

    public function testReviewOriginWithNotUpdatedResponse(): void
    {
        $this->resourcesGateway->add(
            new UrlResponse('http://example.com/foo.txt', 200, new DateTimeImmutable('2017-01-02'))
        );
        $origin = new Origin('Foo', 'http://example.com/foo.txt', new DateTimeImmutable('2017-01-01'));

        $review = $this->reviewer->review($origin);

        $this->assertSame($origin, $review->origin());
        $this->assertFalse($review->status()->isUptodate());
        $this->assertTrue($review->status()->isNotUpdated());
    }

    public function testReviewOriginWithNotFound(): void
    {
        $origin = new Origin('Xee', 'http://example.com/xee.txt', new DateTimeImmutable('2017-01-02'));

        $review = $this->reviewer->review($origin);

        $this->assertSame($origin, $review->origin());
        $this->assertFalse($review->status()->isUptodate());
        $this->assertTrue($review->status()->isNotFound());
    }
}
