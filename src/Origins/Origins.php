<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use PhpCfdi\SatCatalogosPopulate\AbstractCollection;

/**
 * @method Origin[] all(): array
 */
class Origins extends AbstractCollection
{
    public function isValidMember($member): bool
    {
        return ($member instanceof Origin);
    }
}
