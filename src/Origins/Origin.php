<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use DateTimeImmutable;
use LogicException;

class Origin
{
    /** @var string */
    private $name;

    /** @var string */
    private $url;

    /** @var DateTimeImmutable|null */
    private $lastVersion;

    public function __construct(string $name, string $url, DateTimeImmutable $lastVersion = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->lastVersion = $lastVersion;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function lastVersion(): DateTimeImmutable
    {
        if (! $this->lastVersion instanceof DateTimeImmutable) {
            throw new LogicException('There is no last version in the origin');
        }
        return $this->lastVersion;
    }

    public function hasLastVersion(): bool
    {
        return $this->lastVersion instanceof DateTimeImmutable;
    }
}
