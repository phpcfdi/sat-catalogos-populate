<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

class ReviewStatus
{
    protected const UP_TO_DATE = 'UP-TO-DATE';

    protected const NOT_FOUND = 'NOT-FOUND';

    protected const NOT_UPDATED = 'NOT-UPDATED';

    /** @var string */
    private $status;

    private function __construct(string $status)
    {
        $this->status = $status;
    }

    private static function staticObjects(string $type): self
    {
        static $objects = [];
        if (! array_key_exists($type, $objects)) {
            $objects[$type] = new self($type);
        }

        return $objects[$type];
    }

    public static function uptodate(): self
    {
        return static::staticObjects(self::UP_TO_DATE);
    }

    public static function notFound(): self
    {
        return static::staticObjects(self::NOT_FOUND);
    }

    public static function notUpdated(): self
    {
        return static::staticObjects(self::NOT_UPDATED);
    }

    public function isUptodate(): bool
    {
        return self::UP_TO_DATE === $this->status;
    }

    public function isNotFound(): bool
    {
        return self::NOT_FOUND === $this->status;
    }

    public function isNotUpdated(): bool
    {
        return self::NOT_UPDATED === $this->status;
    }
}
