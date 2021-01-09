<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Commands;

use PhpCfdi\SatCatalogosPopulate\Database\Repository;
use PhpCfdi\SatCatalogosPopulate\Importers\SourcesImporter;
use PhpCfdi\SatCatalogosPopulate\Origins\Origins;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginsIO;
use PhpCfdi\SatCatalogosPopulate\Origins\ResourcesGatewayInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\Reviewers;
use PhpCfdi\SatCatalogosPopulate\Origins\ReviewStatus;
use PhpCfdi\SatCatalogosPopulate\Origins\Upgrader;
use PhpCfdi\SatCatalogosPopulate\Origins\WebResourcesGateway;
use Psr\Log\LoggerInterface;
use RuntimeException;

class UpdateOrigins implements CommandInterface
{
    public const DEFAULT_ORIGINS_FILENAME = 'origins.xml';

    /** @var string */
    private $originsFile;

    /** @var string */
    private $workingFolder;

    /** @var bool */
    private $updateOrigins;

    /** @var bool */
    private $updateDatabase;

    /** @var string */
    private $databaseLocation;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        string $originsFile,
        bool $updateOrigins,
        string $databaseLocation,
        LoggerInterface $logger
    ) {
        if ('' === $originsFile) {
            throw new RuntimeException('Invalid origins: empty string received');
        }
        if (is_dir($originsFile)) {
            $originsFile = $originsFile . DIRECTORY_SEPARATOR . self::DEFAULT_ORIGINS_FILENAME;
        }
        if (! file_exists($originsFile) || ! is_readable($originsFile)) {
            throw new RuntimeException('Invalid origins: file does not exists');
        }

        $this->originsFile = $originsFile;
        $this->workingFolder = dirname($originsFile);
        $this->updateOrigins = $updateOrigins;
        $this->updateDatabase = ('' !== $databaseLocation);
        $this->databaseLocation = $databaseLocation;
        $this->setLogger($logger);
    }

    public function getOriginsFile(): string
    {
        return $this->originsFile;
    }

    public function getWorkingFolder(): string
    {
        return $this->workingFolder;
    }

    public function updateOrigins(): bool
    {
        return $this->updateOrigins;
    }

    public function updateDatabase(): bool
    {
        return $this->updateDatabase;
    }

    public function getDatabaseLocation(): string
    {
        return $this->databaseLocation;
    }

    protected function originsRestore(): Origins
    {
        return (new OriginsIO())->readFile($this->getOriginsFile());
    }

    protected function originsStore(Origins $origins): void
    {
        (new OriginsIO())->writeFile($this->getOriginsFile(), $origins);
    }

    public function createResourcesGateway(): ResourcesGatewayInterface
    {
        return new WebResourcesGateway();
    }

    public function run(): int
    {
        $origins = $this->originsRestore();
        $resourcesGateway = $this->createResourcesGateway();
        $reviewers = Reviewers::createWithDefaultReviewers($resourcesGateway);
        $reviews = $reviewers->review($origins);

        $notFoundReviews = $reviews->filterStatus(ReviewStatus::notFound());
        $notUpdatedReviews = $reviews->filterStatus(ReviewStatus::notUpdated());
        $upToDateReviews = $reviews->filterStatus(ReviewStatus::uptodate());

        foreach ($upToDateReviews as $review) {
            $this->logger->info(sprintf('El origen %s está actualizado', $review->origin()->downloadUrl()));
        }
        foreach ($notUpdatedReviews as $review) {
            if (! $review->origin()->hasLastVersion()) {
                $this->logger->info(sprintf(
                    'El origen %s no existe, se descargará',
                    $review->origin()->downloadUrl()
                ));
            } else {
                $this->logger->info(sprintf(
                    'El origen %s está desactualizado, la nueva versión tiene fecha %s',
                    $review->origin()->downloadUrl(),
                    $review->origin()->lastVersion()->format('c')
                ));
            }
        }
        foreach ($notFoundReviews as $review) {
            $this->logger->info(sprintf('El origen %s no fue encontrado', $review->origin()->url()));
        }
        if ($notFoundReviews->count() > 0) {
            $this->logger->error(sprintf('No se encontraron %d orígenes', $notFoundReviews->count()));
            return 1;
        }

        if ($upToDateReviews->count() === count($reviews)) {
            $this->logger->info(sprintf('No existen orígenes para actualizar'));
            return 0;
        }

        if (! $this->updateOrigins()) {
            $this->logger->info(sprintf('Existen %d orígenes para actualizar', $notUpdatedReviews->count()));
            return 0;
        }
        // have to perform upgrade
        $upgrader = new Upgrader($resourcesGateway, $this->getWorkingFolder(), $this->logger);
        $recentOrigins = $upgrader->upgradeReviews($reviews);
        $this->logger->info(sprintf('Se actualizaron todos los orígenes'));
        $this->originsStore($recentOrigins);
        $this->logger->info(sprintf('Se actualizó el archivo de orígenes'));

        if (! $this->updateDatabase()) {
            return 0;
        }

        $dbUpdateCommand = new UpdateDatabase($this->getWorkingFolder(), $this->getDatabaseLocation(), $this->logger);
        return $dbUpdateCommand->run();
    }

    protected function createRepository(): Repository
    {
        return new Repository($this->getDatabaseLocation());
    }

    protected function createImporter(): SourcesImporter
    {
        return new SourcesImporter();
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public static function help(string $commandName): string
    {
        return implode(PHP_EOL, [
            "Sintax: $commandName update-origins [--dry-run] [--update-database database] origins-file|origins-folder",
            '    --update-database|-w:  location to update database',
            '    --dry-run|-n:          do not update, just report checks',
            '    origins-file:          location where origins file is',
            '    origins-folder:        directory location where ' . static::DEFAULT_ORIGINS_FILENAME . ' is',
        ]);
    }

    public static function createFromArguments(array $arguments): CommandInterface
    {
        // update-origins --dry-run --update-database database origins-file-or-folder
        $count = count($arguments);
        $dryRun = false;
        $databaseFilename = '';
        $originsFile = '';
        for ($i = 0; $i < $count; $i++) {
            $current = $arguments[$i];
            if (in_array($current, ['--dry-run', '-n'], true)) {
                $dryRun = true;
                continue;
            }
            if (in_array($current, ['--update-database', '-w'], true)) {
                $databaseFilename = $arguments[$i + 1] ?? '';
                $i = $i + 1;
                continue;
            }
            if ('' === $originsFile) {
                $originsFile = $current;
                continue;
            }

            throw new RuntimeException(sprintf("Unexpected argument '%s'", $current));
        }

        return new self($originsFile, ! $dryRun, $databaseFilename, new TerminalLogger());
    }
}
