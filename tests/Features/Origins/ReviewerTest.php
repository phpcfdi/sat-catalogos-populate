<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features\Origins;

use DateTimeImmutable;
use PhpCfdi\SatCatalogosPopulate\Origins\Origin;
use PhpCfdi\SatCatalogosPopulate\Origins\Origins;
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

    public function testMainComparison(): void
    {
        // given a list of origins
        $origins = new Origins([
            new Origin('Foo', 'http://example.com/foo.txt', new DateTimeImmutable('2017-01-02')),
            new Origin('Bar', 'http://example.com/bar.txt', new DateTimeImmutable('2017-01-03')),
            new Origin('Baz', 'http://example.com/baz.txt', new DateTimeImmutable('2017-01-04')),
        ]);

        // when check the list for updates
        $reviews = $this->reviewer->review($origins);

        // then a list of reviews is created and it contains the reviews of all states
        foreach ($reviews as $review) {
            $this->assertTrue($origins->contains($review->origin()));
        }
        $this->assertCount($origins->count(), $reviews);
    }

    public function testReviewOriginWithUptodateResponse(): void
    {
        $this->resourcesGateway->add(
            new UrlResponse('http://example.com/foo.txt', 200, new DateTimeImmutable('2017-01-02'))
        );
        $origin = new Origin('Foo', 'http://example.com/foo.txt', new DateTimeImmutable('2017-01-02'));

        $review = $this->reviewer->reviewOrigin($origin);

        $this->assertSame($origin, $review->origin());
        $this->assertTrue($review->status()->isUptodate());
    }

    public function testReviewOriginWithNotUpdatedResponse(): void
    {
        $this->resourcesGateway->add(
            new UrlResponse('http://example.com/foo.txt', 200, new DateTimeImmutable('2017-01-02'))
        );
        $origin = new Origin('Foo', 'http://example.com/foo.txt', new DateTimeImmutable('2017-01-01'));

        $review = $this->reviewer->reviewOrigin($origin);

        $this->assertSame($origin, $review->origin());
        $this->assertFalse($review->status()->isUptodate());
        $this->assertTrue($review->status()->isNotUpdated());
    }

    public function testReviewOriginWithNotFound(): void
    {
        $origin = new Origin('Xee', 'http://example.com/xee.txt', new DateTimeImmutable('2017-01-02'));

        $review = $this->reviewer->reviewOrigin($origin);

        $this->assertSame($origin, $review->origin());
        $this->assertFalse($review->status()->isUptodate());
        $this->assertTrue($review->status()->isNotFound());
    }
}
