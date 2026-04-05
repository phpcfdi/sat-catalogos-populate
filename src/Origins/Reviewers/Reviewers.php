<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins\Reviewers;

use LogicException;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\Origins;
use PhpCfdi\SatCatalogosPopulate\Origins\ResourcesGatewayInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\Reviews;

final readonly class Reviewers
{
    /** @var ReviewerInterface[] */
    private array $reviewers;

    public function __construct(ReviewerInterface ...$reviewers)
    {
        $this->reviewers = $reviewers;
    }

    public static function createWithDefaultReviewers(ResourcesGatewayInterface $gateway): self
    {
        return new self(...[
            new ConstantReviewer($gateway),
            new ScrapingReviewer($gateway),
            new Nomina12eReviewer($gateway),
            new HidroPetro10Reviewer($gateway),
        ]);
    }

    public function review(Origins $origins): Reviews
    {
        $reviews = [];
        foreach ($origins as $origin) {
            $reviewer = $this->findReviewerByOrigin($origin);
            $reviews[] = $reviewer->review($origin);
        }
        return new Reviews($reviews);
    }

    public function findReviewerByOrigin(OriginInterface $origin): ReviewerInterface
    {
        foreach ($this->reviewers as $reviewer) {
            if ($reviewer->accepts($origin)) {
                return $reviewer;
            }
        }
        throw new LogicException(sprintf('Unable to review an origin of class %s', $origin::class));
    }
}
