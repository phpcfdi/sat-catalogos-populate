<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Commands;

use Psr\Log\LoggerAwareInterface;

interface CommandInterface extends LoggerAwareInterface
{
    public function run(): int;

    /**
     * @param string[] $arguments
     * @return CommandInterface
     */
    public static function createFromArguments(array $arguments): self;

    public static function help(string $commandName): string;
}
