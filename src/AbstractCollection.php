<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;

/**
 * @template T
 * @implements IteratorAggregate<T>
 */
abstract class AbstractCollection implements Countable, IteratorAggregate
{
    /** @var array<int, T> */
    private array $members;

    private int $count;

    /**
     * @param mixed $member
     * @return bool
     */
    abstract public function isValidMember($member): bool;

    /**
     * @param array<T> $members
     */
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

    /**
     * @param T $member
     * @return bool
     */
    public function contains($member): bool
    {
        return in_array($member, $this->members, true);
    }

    /**
     * @param int $index
     * @return T
     */
    public function get(int $index)
    {
        if (! isset($this->members[$index])) {
            throw new InvalidArgumentException(
                "The collection does not contain the index $index"
            );
        }

        return $this->members[$index];
    }

    /**
     * @return T[]
     */
    public function all(): array
    {
        return $this->members;
    }

    /** @return T */
    public function first()
    {
        return $this->members[0];
    }

    /** @return T */
    public function last()
    {
        return $this->members[$this->count - 1];
    }

    /** @return ArrayIterator<int, T> */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->members);
    }

    public function count(): int
    {
        return $this->count;
    }
}
