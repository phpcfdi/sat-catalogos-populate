<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

class ReviewStatus
{
    protected const UP_TO_DATE = 'UP-TO-DATE';

    protected const NOT_FOUND = 'NOT-FOUND';

    protected const NOT_UPDATED = 'NOT-UPDATED';

    private function __construct(private readonly string $status)
    {
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
        return self::staticObjects(self::UP_TO_DATE);
    }

    public static function notFound(): self
    {
        return self::staticObjects(self::NOT_FOUND);
    }

    public static function notUpdated(): self
    {
        return self::staticObjects(self::NOT_UPDATED);
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
