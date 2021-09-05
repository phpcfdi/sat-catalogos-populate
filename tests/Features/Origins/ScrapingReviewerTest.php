<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Tests\Features\Origins;

use DateTimeImmutable;
use PhpCfdi\SatCatalogosPopulate\Origins\ScrapingOrigin;
use PhpCfdi\SatCatalogosPopulate\Origins\ScrapingReviewer;
use PhpCfdi\SatCatalogosPopulate\Origins\UrlResponse;
use PhpCfdi\SatCatalogosPopulate\Tests\Fixtures\Origins\FakeGateway;
use PhpCfdi\SatCatalogosPopulate\Tests\TestCase;

class ScrapingReviewerTest extends TestCase
{
    /** @var ScrapingReviewer */
    private $reviewer;

    /** @var string */
    private $urlFooFile;

    /** @var string */
    private $urlPageToScrap;

    protected function setUp(): void
    {
        $fakeGateway = new FakeGateway();
        $this->reviewer = new ScrapingReviewer($fakeGateway);
        /** @noinspection HtmlUnknownTarget */
        $webpage = <<<HTML
                <html lang="en">
                <body><h1>sample</h1>
                <li><a href="files/foo.txt">foo</a></li>
                <li><a href="files/bar.txt">bar</a></li>
                </body>
                </html>
            HTML;
        $this->urlFooFile = 'http://example.com/files/foo.txt';
        $this->urlPageToScrap = 'http://example.com/index.html';
        $fakeGateway->add( // web page to scrap
            new UrlResponse($this->urlPageToScrap, 200, new DateTimeImmutable('2021-01-02'), $webpage)
        );
        $fakeGateway->add( // web page to scrap
            new UrlResponse($this->urlFooFile, 200, new DateTimeImmutable('2021-01-05'), $webpage)
        );
    }

    public function testReviewOriginWithUpToDateResponse(): void
    {
        $lastVersion = new DateTimeImmutable('2021-01-05');
        $origin = new ScrapingOrigin('Foo', $this->urlPageToScrap, 'foo.txt', 'foo', $lastVersion);

        $review = $this->reviewer->review($origin);

        $this->assertTrue($review->status()->isUptodate(), 'The review status should be up-to-date');

        // the reviewed origin has the correct url to download (even, when it was not set as a full url)
        /** @var ScrapingOrigin $reviewedOrigin */
        $reviewedOrigin = $review->origin();
        $this->assertInstanceOf(ScrapingOrigin::class, $reviewedOrigin);
        $this->assertTrue($reviewedOrigin->hasDownloadUrl(), 'The reviewed origin should be resolved');
        $this->assertSame(
            $this->urlFooFile,
            $reviewedOrigin->downloadUrl(),
            'The reviewed origin should be expected url'
        );
    }

    public function testReviewOriginOutdatedResponse(): void
    {
        $origin = new ScrapingOrigin('Foo', $this->urlPageToScrap, 'foo.txt', 'foo');

        $review = $this->reviewer->review($origin);

        $this->assertTrue($review->status()->isNotUpdated(), 'The review status should be outdated');
    }

    public function testReviewOriginNotFoundResponse(): void
    {
        $origin = new ScrapingOrigin('Bar', $this->urlPageToScrap, 'bar.txt', 'bar');

        $review = $this->reviewer->review($origin);

        $this->assertTrue($review->status()->isNotFound(), 'The review status should be outdated');
    }

    public function testReviewOriginNotFoundScrapPage(): void
    {
        $origin = new ScrapingOrigin('Xee', 'http://notfound/', 'xee.txt', 'xee');

        $review = $this->reviewer->review($origin);

        $this->assertTrue($review->status()->isNotFound(), 'The review status should be outdated');
    }
}
