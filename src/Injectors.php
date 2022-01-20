<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate;

use InvalidArgumentException;
use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use Psr\Log\LoggerInterface;

/**
 * @extends AbstractCollection<InjectorInterface>
 */
class Injectors extends AbstractCollection implements InjectorInterface
{
    public function __construct(array $members)
    {
        parent::__construct($members);
        if (0 === $this->count()) {
            throw new InvalidArgumentException('There are no injectors in the collection');
        }
    }

    public function isValidMember(mixed $member): bool
    {
        return ($member instanceof InjectorInterface);
    }

    public function validate(): void
    {
        foreach ($this->getIterator() as $injector) {
            $injector->validate();
        }
    }

    public function inject(Repository $repository, LoggerInterface $logger): int
    {
        $inserted = 0;
        foreach ($this->getIterator() as $injector) {
            $inserted = $inserted + $injector->inject($repository, $logger);
        }
        return $inserted;
    }
}
