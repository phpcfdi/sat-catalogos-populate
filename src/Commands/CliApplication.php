<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Commands;

use RuntimeException;

class CliApplication
{
    /** @var array<string, array{class: class-string, description: string}> */
    private array $commands;

    private string $executableName = '';

    public function getExecutableName(): string
    {
        return $this->executableName;
    }

    public function setExecutableName(string $executableName): void
    {
        $this->executableName = $executableName;
    }

    public function __construct()
    {
        $this->commands = [
            'dump-origins' => [
                'class' => DumpOrigins::class,
                'description' => 'Hace un volcado del archivo de orígenes esperado',
            ],
            'update-origins' => [
                'class' => UpdateOrigins::class,
                'description' => 'Actualiza el archivo de orígenes desde un archivo o directorio',
            ],
            'update-database' => [
                'class' => UpdateDatabase::class,
                'description' => 'Actualiza la base de datos de catálogos desde un directorio',
            ],
        ];
    }

    public function run(string ...$arguments): int
    {
        $this->setExecutableName((string) array_shift($arguments));

        $command = (string) array_shift($arguments);

        if ('' === $command || 'list' === $command) {
            $this->listCommands();
            return 0;
        }

        if (in_array($command, ['help', '-h', '--help'], true)) {
            $this->showHelp($arguments[0] ?? '');
            return 0;
        }

        if ([] !== array_intersect(['-h', '--help'], $arguments)) {
            $this->showHelp($command);
            return 0;
        }

        return $this->runCommand($command, ...$arguments);
    }

    /** @return class-string */
    public function getCommandClass(string $commandName): string
    {
        if (! isset($this->commands[$commandName])) {
            throw new RuntimeException("Command $commandName is not registered");
        }
        return $this->commands[$commandName]['class'];
    }

    public function runCommand(string $commandName, string ...$arguments): int
    {
        $commandClass = $this->getCommandClass($commandName);
        /** @phpstan-var callable $staticCallable phpstan work around*/
        $staticCallable = [$commandClass, 'createFromArguments'];
        /** @var CommandInterface $command */
        $command = call_user_func($staticCallable, $arguments);
        return $command->run();
    }

    public function listCommands(): void
    {
        $commandList = [];
        foreach ($this->commands as $name => $commandInfo) {
            $commandList[$name] = $commandInfo['description'];
        }
        $internalCommandList = [
            'list' => 'show the list of commands',
            'help' => 'show general help of command help',
        ];

        $commandList = array_merge($internalCommandList, array_diff($commandList, $internalCommandList));

        echo $this->getExecutableName() . ' command options' . PHP_EOL . PHP_EOL;
        foreach ($commandList as $name => $description) {
            echo '    ' . $name . ': ' . $description . PHP_EOL;
        }
        echo PHP_EOL;
    }

    public function showHelp(string $commandName): void
    {
        if ('' === $commandName) {
            $this->listCommands();
            return;
        }

        $commandClassName = $this->getCommandClass($commandName);
        $description = $this->commands[$commandName]['description'];
        echo $commandName, ': ', $description, PHP_EOL;
        /** @var callable $staticCallable phpstan work around */
        $staticCallable = $commandClassName . '::help';
        /** @var string $helpOutput */
        $helpOutput = call_user_func($staticCallable, $commandName);
        echo $helpOutput, PHP_EOL, PHP_EOL;
    }
}
