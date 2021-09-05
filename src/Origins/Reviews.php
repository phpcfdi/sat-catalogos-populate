<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use PhpCfdi\SatCatalogosPopulate\AbstractCollection;

/**
 * @method Review[] all(): array
 * @method Review get(int $index): Review
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
