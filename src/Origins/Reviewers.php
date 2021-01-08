<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use LogicException;

class Reviewers
{
    /** @var ReviewerInterface[] */
    private $reviewers;

    public function __construct(ReviewerInterface ...$reviewers)
    {
        $this->reviewers = $reviewers;
    }

    public static function createWithDefaultReviewers(ResourcesGatewayInterface $gateway): self
    {
        return new self(...[
            new ConstantReviewer($gateway),
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
            if ($reviewer->accept($origin)) {
                return $reviewer;
            }
        }
        throw new LogicException(sprintf('Unable to review an ConstantOrigin of class %s', get_class($origin)));
    }
}
