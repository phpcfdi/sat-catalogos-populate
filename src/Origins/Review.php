<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

class Review
{
    /** @var OriginInterface */
    private $origin;

    /** @var ReviewStatus */
    private $status;

    public function __construct(OriginInterface $origin, ReviewStatus $status)
    {
        $this->origin = $origin;
        $this->status = $status;
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
