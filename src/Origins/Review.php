<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

class Review
{
    /** @var Origin */
    private $origin;

    /** @var ReviewStatus */
    private $status;

    public function __construct(Origin $origin, ReviewStatus $status)
    {
        $this->origin = $origin;
        $this->status = $status;
    }

    public function origin(): Origin
    {
        return $this->origin;
    }

    public function status(): ReviewStatus
    {
        return $this->status;
    }
}
