<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

class Review
{
    public function __construct(private OriginInterface $origin, private ReviewStatus $status)
    {
    }

    public function origin(): OriginInterface
    {
        return $this->origin;
    }

    public function status(): ReviewStatus
    {
        return $this->status;
    }
}
