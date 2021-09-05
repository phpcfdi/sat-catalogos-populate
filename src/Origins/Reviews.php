<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use PhpCfdi\SatCatalogosPopulate\AbstractCollection;

/**
 * @extends AbstractCollection<Review>
 */
class Reviews extends AbstractCollection
{
    public function isValidMember($member): bool
    {
        return ($member instanceof Review);
    }

    public function filterStatus(ReviewStatus $status): self
    {
        return new self(array_filter($this->all(), fn (Review $review) => $status === $review->status()));
    }
}
