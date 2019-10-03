<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate;

use InvalidArgumentException;
use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use Psr\Log\LoggerInterface;

/**
 * @method InjectorInterface[] all(): array
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

    public function isValidMember($member): bool
    {
        return ($member instanceof InjectorInterface);
    }

    public function validate(): void
    {
        foreach ($this->all() as $injector) {
            $injector->validate();
        }
    }

    public function inject(Repository $repository, LoggerInterface $logger): int
    {
        $inserted = 0;
        foreach ($this->all() as $injector) {
            $inserted = $inserted + $injector->inject($repository, $logger);
        }
        return $inserted;
    }

    public function getByClassname(string $classname): InjectorInterface
    {
        foreach ($this->all() as $injector) {
            if ($injector instanceof $classname) {
                return $injector;
            }
        }
        throw new InvalidArgumentException(
            "The collection does not contain a class with name $classname"
        );
    }
}
