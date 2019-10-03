<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;

abstract class AbstractCollection implements Countable, IteratorAggregate
{
    /** @var array */
    private $members;

    /** @var int */
    private $count;

    abstract public function isValidMember($member): bool;

    public function __construct(array $members)
    {
        foreach ($members as $index => $member) {
            if (! $this->isValidMember($member)) {
                throw new InvalidArgumentException(
                    "The member $index contains an object that is not valid for this collection"
                );
            }
        }

        $this->members = array_values($members);
        $this->count = count($members);
    }

    public function contains($member): bool
    {
        return in_array($member, $this->members, true);
    }

    public function get(int $index)
    {
        if (! isset($this->members[$index])) {
            throw new InvalidArgumentException(
                "The collection does not contain the index $index"
            );
        }

        return $this->members[$index];
    }

    public function all(): array
    {
        return $this->members;
    }

    public function first()
    {
        return $this->members[0];
    }

    public function last()
    {
        return $this->members[$this->count - 1];
    }

    public function getIterator()
    {
        return new ArrayIterator($this->members);
    }

    public function count(): int
    {
        return $this->count;
    }
}
