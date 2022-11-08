<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Utils;

class ShellExec
{
    /** @param string[] $output */
    public function __construct(
        private readonly string $command,
        private array $output = [],
        private int $exitStatus = -1,
        private string $lastLine = ''
    ) {
    }

    public function command(): string
    {
        return $this->command;
    }

    /** @return string[] */
    public function output(): array
    {
        return $this->output;
    }

    public function lastLine(): string
    {
        return $this->lastLine;
    }

    public function exitStatus(): int
    {
        return $this->exitStatus;
    }

    public function exec(): void
    {
        $output = [];
        $exitStatus = -1;

        $lastline = (string) exec($this->command(), $output, $exitStatus);

        $this->output = $output;
        $this->exitStatus = $exitStatus;
        $this->lastLine = $lastline;
    }

    public static function run(string $command): self
    {
        $shellExec = new self($command);
        $shellExec->exec();
        return $shellExec;
    }
}
