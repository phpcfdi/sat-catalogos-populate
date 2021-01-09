<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

interface ReviewerInterface
{
    public function accepts(OriginInterface $origin): bool;

    public function review(OriginInterface $origin): Review;
}
