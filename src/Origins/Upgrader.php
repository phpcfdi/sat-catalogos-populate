<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use Psr\Log\LoggerInterface;

// use function PhpCfdi\SatCatalogosPopulate\Utils\file_extension;

class Upgrader
{
    public const DEFAULT_ORIGINS_FILENAME = 'origins.xml';

    private ResourcesGatewayInterface $gateway;

    private string $destinationPath;

    private LoggerInterface $logger;

    public function __construct(ResourcesGatewayInterface $gateway, string $destinationPath, LoggerInterface $logger)
    {
        // TODO: validate destination path
        $this->gateway = $gateway;
        $this->destinationPath = $destinationPath;
        $this->logger = $logger;
    }

    public function destinationPath(): string
    {
        return $this->destinationPath;
    }

    public function gateway(): ResourcesGatewayInterface
    {
        return $this->gateway;
    }

    protected function buildPath(string $filename): string
    {
        return $this->destinationPath . '/' . basename($filename);
    }

    protected function createReader(): OriginsIO
    {
        return new OriginsIO();
    }

    protected function createReviewers(): Reviewers
    {
        return Reviewers::createWithDefaultReviewers($this->gateway());
    }

    public function upgrade(string $filename = ''): Origins
    {
        if ('' === $filename) {
            $filename = $this->buildPath(self::DEFAULT_ORIGINS_FILENAME);
        }

        $reader = $this->createReader();
        $origins = $reader->readFile($filename);
        return $this->upgradeOrigins($origins);
    }

    public function upgradeOrigins(Origins $origins): Origins
    {
        $reviewers = $this->createReviewers();
        $reviews = $reviewers->review($origins);

        return $this->upgradeReviews($reviews);
    }

    public function upgradeReviews(Reviews $reviews): Origins
    {
        $origins = [];
        foreach ($reviews as $review) {
            $origins[] = $this->upgradeReview($review);
        }

        return new Origins($origins);
    }

    public function upgradeReview(Review $review): OriginInterface
    {
        $origin = $review->origin();
        $destination = $this->buildPath($origin->destinationFilename());
        if (! $review->status()->isNotUpdated()) {
            return $origin;
        }

        // $this->createBackup($destination);
        $this->logger->info(sprintf('Actualizando %s en %s', $origin->downloadUrl(), $destination));
        $urlResponse = $this->gateway->get($origin->downloadUrl(), $destination);
        return $origin->withLastModified($urlResponse->lastModified());
    }

    /*
    protected function createBackup(string $currentFile)
    {
        if (! file_exists($currentFile)) {
            return;
        }
        $extension = file_extension($currentFile);
        $currentDate = (new \DateTimeImmutable())->setTimestamp(filectime($currentFile));
        $backupFile = sprintf(
            '%s-%s.%s',
            substr($currentFile, 0, - 1 - strlen($extension)), // current name without extension
            $currentDate->format('Ymd-HisO'),                  // date
            $extension                                         // extension
        );
        if (! file_exists($backupFile)) {
            $this->logger->info(sprintf('Respaldando %s en %s', $currentFile, $backupFile));
            copy($currentFile, $backupFile);
        }
    }
    */
}
