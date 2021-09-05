<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features\Origins;

use DateTimeImmutable;
use PhpCfdi\SatCatalogosPopulate\Origins\ConstantOrigin;
use PhpCfdi\SatCatalogosPopulate\Origins\Origins;
use PhpCfdi\SatCatalogosPopulate\Origins\Reviewers;
use PhpCfdi\SatCatalogosPopulate\Tests\Fixtures\Origins\FakeGateway;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class ReviewersTest extends TestCase
{
    private Reviewers $reviewers;

    protected function setUp(): void
    {
        $this->reviewers = Reviewers::createWithDefaultReviewers(new FakeGateway());
    }

    public function testMainComparison(): void
    {
        // given a list of origins
        $origins = new Origins([
            new ConstantOrigin('Foo', 'http://example.com/foo.txt', new DateTimeImmutable('2017-01-02')),
            new ConstantOrigin('Bar', 'http://example.com/bar.txt', new DateTimeImmutable('2017-01-03')),
            new ConstantOrigin('Baz', 'http://example.com/baz.txt', new DateTimeImmutable('2017-01-04')),
        ]);

        // when check the list for updates
        $reviews = $this->reviewers->review($origins);

        // then a list of reviews is created, and it contains the reviews of all states
        foreach ($reviews as $review) {
            $this->assertTrue($origins->contains($review->origin()));
        }
        $this->assertCount($origins->count(), $reviews);
    }
}
