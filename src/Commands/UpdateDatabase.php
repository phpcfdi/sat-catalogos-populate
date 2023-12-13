<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Commands;

use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\Importers\SourcesImporter;
use Psr\Log\LoggerInterface;
use RuntimeException;

final class UpdateDatabase implements CommandInterface
{
    private string $sourceFolder;

    private string $destinationDatabase;

    private LoggerInterface $logger;

    public function __construct(string $sourceCatalog, string $destinationDatabase, LoggerInterface $logger)
    {
        // TODO: check if we can move these setters to this constructors
        $this->setSourceCatalog($sourceCatalog);
        $this->setDestinationDatabase($destinationDatabase);
        $this->setLogger($logger);
    }

    private function setSourceCatalog(string $sourceCatalog): void
    {
        if ('' === $sourceCatalog) {
            throw new RuntimeException('Invalid source catalog: empty string received');
        }
        if (! is_dir($sourceCatalog)) {
            throw new RuntimeException('Invalid source catalog: is not a directory');
        }

        $this->sourceFolder = $sourceCatalog;
    }

    private function setDestinationDatabase(string $destinationDatabase): void
    {
        // TODO: why is needed an absolute path ?
        if (! str_starts_with($destinationDatabase, DIRECTORY_SEPARATOR)) {
            $destinationDatabase = getcwd() . DIRECTORY_SEPARATOR . $destinationDatabase;
        }

        $this->destinationDatabase = $destinationDatabase;
    }

    public function getSourceFolder(): string
    {
        return $this->sourceFolder;
    }

    public function getDestinationDatabase(): string
    {
        return $this->destinationDatabase;
    }

    public function run(): int
    {
        $repository = $this->createRepository();
        $importer = $this->createImporter();
        $repository->pdo()->beginTransaction();
        $importer->import($this->getSourceFolder(), $repository, $this->logger);
        $repository->pdo()->commit();
        $this->logger->info('Se terminó correctamente con la actualización de la base de datos');
        return 0;
    }

    protected function createRepository(): Repository
    {
        // TODO: validate destination
        return new Repository($this->getDestinationDatabase());
    }

    protected function createImporter(): SourcesImporter
    {
        return new SourcesImporter();
    }

    public static function help(string $commandName): string
    {
        return implode(PHP_EOL, [
            "Sintax: $commandName folder database",
            '    folder:    location where all source catalogs exists',
            '    database:  database location (if not found it will be created)',
        ]);
    }

    public static function createFromArguments(array $arguments): self
    {
        return new self($arguments[0] ?? '', $arguments[1] ?? '', new TerminalLogger());
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }
}
