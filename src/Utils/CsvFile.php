<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Utils;

use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\ArrayProcessorInterface;
use PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\NullArrayProcessor;
use SeekableIterator;
use SplFileObject;
use Traversable;
use UnexpectedValueException;

class CsvFile implements SeekableIterator
{
    private \SplFileObject $file;

    private \PhpCfdi\SatCatalogosPopulate\Utils\ArrayProcessors\ArrayProcessorInterface $rowProcessor;

    public function __construct(string $filename, ArrayProcessorInterface $rowProcessor = null)
    {
        if ('' === $filename) {
            throw new UnexpectedValueException('The filename cannot be empty');
        }
        if (is_dir($filename)) {
            throw new UnexpectedValueException('The filename is a directory');
        }
        $this->file = new SplFileObject($filename, 'r');
        $this->rowProcessor = (null === $rowProcessor) ? new NullArrayProcessor() : $rowProcessor;
    }

    public function position(): int
    {
        return $this->file->key();
    }

    public function move(int $position): void
    {
        $position = max(0, $position);
        if (0 === $position) {
            $this->file->rewind();
            return;
        }

        if (1 === $position) {
            // this is a bugfix, otherwise it don't go to line 1
            $this->file->rewind();
            $this->current();
            $this->file->next();
            return;
        }

        $this->file->seek($position);
    }

    public function next(int $times = 1): void
    {
        if (1 === $times) {
            $this->file->next();
            return;
        }

        $this->move($this->position() + $times);
    }

    /**
     * @return Traversable<array>
     */
    public function readLines()
    {
        while (! $this->eof()) {
            yield $this->readLine();
            $this->next();
        }
    }

    public function previous(int $times = 1): void
    {
        $this->move($this->position() - $times);
    }

    public function eof(): bool
    {
        if (! $this->file->valid()) {
            return true;
        }
        if ('' !== $this->file->current()) {
            return false;
        }

        // am I at the last empty line?
        $this->file->next();
        if ($this->file->valid()) {
            $this->previous();
            return false;
        }

        return true;
    }

    public function readLine(): array
    {
        if ($this->eof()) {
            return [];
        }
        $contents = $this->file->current();
        $contents = (! is_string($contents)) ? '' : $contents;
        return $this->rowProcessor->execute(str_getcsv($contents));
    }

    public function current(): array
    {
        return $this->readLine();
    }

    public function key(): int
    {
        return $this->file->key();
    }

    public function valid(): bool
    {
        return ! $this->eof();
    }

    public function rewind(): void
    {
        $this->file->rewind();
    }

    /**
     * @param int $position
     */
    public function seek($position): void
    {
        $this->move($position);
    }
}
