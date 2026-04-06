<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins\Reviewers;

use Exception;
use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Dom\Selector\XPathSelector;
use LogicException;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\ResourcesGatewayInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\Review;
use PhpCfdi\SatCatalogosPopulate\Origins\Types\ConstantOrigin;
use PhpCfdi\SatCatalogosPopulate\Origins\Types\HidroPetro10Origin;
use RuntimeException;

final class HidroPetro10Reviewer implements ReviewerInterface
{
    private const string ENTRY_URL = 'https://www.sat.gob.mx/portal/public/tramites/complementos-de-factura';

    public function __construct(
        private readonly ResourcesGatewayInterface $gateway,
    ) {
    }

    public function accepts(OriginInterface $origin): bool
    {
        return $origin instanceof HidroPetro10Origin;
    }

    public function review(OriginInterface $origin): Review
    {
        if (! $this->accepts($origin)) {
            throw new LogicException('This reviewer can only handle HidroPetro10Origin objects');
        }

        try {
            $resourceUrl = $this->obtainResourceUrl();
        } catch (Exception $exception) {
            throw new RuntimeException('Unable to obtain resource URL for Nómina 1.2E', previous: $exception);
        }

        $origin = new ConstantOrigin(
            $origin->name(),
            $resourceUrl,
            ($origin->hasLastVersion()) ? $origin->lastVersion() : null,
            $origin->destinationFilename(),
        );
        $reviewer = new ConstantReviewer($this->gateway);
        return $reviewer->review($origin);
    }

    /** @throws Exception when something goes wrong */
    public function obtainResourceUrl(): string
    {
        $chromeBinary = $this->obtainChromeBinary();
        $browserFactory = new BrowserFactory($chromeBinary);
        $browserFactory->addOptions(['noSandbox' => $this->obtainChromeNoSandbox()]);
        $browser = $browserFactory->createBrowser();
        try {
            // creates a new page and navigate to a URL
            $page = $browser->createPage();
            $page->navigate(self::ENTRY_URL)->waitForNavigation(timeout: 10_000);

            // wait until there is a div.tab-container div.tab-label with text "Complementos concepto"
            $tabSelector = new XPathSelector(implode('', [
                '//div[contains(@class, "tab-container")]',
                '//div[contains(@class, "tab-label")]',
                '//span[contains(text(), "Complementos concepto")]',
            ]));
            $page->waitUntilContainsElement($tabSelector);
            // click on the element
            $page->mouse()->findElement($tabSelector)->click();

            // wait until there is a div.tab-content section.section-cards div.card-body button with text
            // "Hidrocarburos y petrolíferos"
            $buttonSelector = new XPathSelector(implode('', [
                '//div[contains(@class, "tab-content")]',
                '//section[contains(@class, "section-cards")]',
                '//div[contains(@class, "card-body")]',
                '//button[',
                './/h4[contains(text(), "Hidrocarburos y petrolíferos")]',
                ']',
            ]));
            $page->waitUntilContainsElement($buttonSelector);
            // click on the element
            $page->mouse()->findElement($buttonSelector)->click();

            // wait for the loaded content
            $page->waitUntilContainsElement(
                new XPathSelector('//dialog[@open]'),
            );
            // search for every div.container-modal div.info-modal a that contains "Catálogos"
            $contentElements = $page->dom()->search(implode('', ['',
                '//div[contains(@class, "container-modal")]',
                '//div[contains(@class, "info-modal")]',
                '//a[contains(text(), "Catálogos")]',
            ]));
            if ([] === $contentElements) {
                throw new RuntimeException('Unable to find links matching "Catálogos"');
            }

            // return href from element that contains href
            foreach ($contentElements as $contentElement) {
                $href = $contentElement->getAttribute('href');
                if (null !== $href) {
                    return $href;
                }
            }
            throw new RuntimeException('Unable to find URL on links matching "Catálogos"');
        } finally {
            $browser->close();
        }
    }

    private function obtainChromeBinary(): string|null
    {
        $chromeBinary = $_SERVER['CHROME_BINARY'] ?? null;
        if (! is_scalar($chromeBinary) && ! is_null($chromeBinary)) {
            return null;
        }

        return is_scalar($chromeBinary) ? (string) $chromeBinary : null;
    }

    private function obtainChromeNoSandbox(): bool
    {
        $chromeNoSandbox = $_SERVER['CHROME_NOSANDBOX'] ?? null;
        if (is_string($chromeNoSandbox)) {
            return in_array(strtolower($chromeNoSandbox), ['yes', 'true'], true);
        }
        return false;
    }
}
