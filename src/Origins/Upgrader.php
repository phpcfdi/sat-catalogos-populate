<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins;

use Psr\Log\LoggerInterface;

// use function PhpCfdi\SatCatalogosPopulate\Utils\file_extension;

class Upgrader
{
    public const DEFAULT_ORIGINS_FILENAME = 'origins.xml';

    /** @var ResourcesGatewayInterface */
    private $gateway;

    /** @var string */
    private $destinationPath;

    /** @var LoggerInterface */
    private $logger;

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

    public function buildOriginPath(Origin $origin): string
    {
        $path = (string) parse_url($origin->url(), PHP_URL_PATH);
        // TODO: Validate if url does not have a path
        //if ('' === $path) {
        //    throw new \RuntimeException('The review does not have a path');
        //}

        return $this->buildPath($path);
    }

    protected function buildPath(string $filename): string
    {
        return $this->destinationPath . '/' . basename($filename);
    }

    protected function createReader(): OriginsIO
    {
        return new OriginsIO();
    }

    protected function createReviewer(): Reviewer
    {
        return new Reviewer($this->gateway());
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
        $reviewer = $this->createReviewer();
        $reviews = $reviewer->review($origins);

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

    public function upgradeReview(Review $review): Origin
    {
        $origin = $review->origin();
        $destination = $this->buildOriginPath($origin);
        if (! $review->status()->isNotUpdated()) {
            return $origin;
        }

        // $this->createBackup($destination);
        $this->logger->info(sprintf('Actualizando %s en %s', $origin->url(), $destination));
        $urlResponse = $this->gateway->get($origin->url(), $destination);
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
