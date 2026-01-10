<?php

declare(strict_types=1);

namespace PhpCfdi\SatCatalogosPopulate\Origins\Reviewers;

use Exception;
use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Dom\Selector\XPathSelector;
use LogicException;
use PhpCfdi\SatCatalogosPopulate\Origins\ConstantOrigin;
use PhpCfdi\SatCatalogosPopulate\Origins\Nomina12eOrigin;
use PhpCfdi\SatCatalogosPopulate\Origins\OriginInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\ResourcesGatewayInterface;
use PhpCfdi\SatCatalogosPopulate\Origins\Review;
use RuntimeException;

final class Nomina12eReviewer implements ReviewerInterface
{
    private const string NOMINA_12E_URL = 'https://www.sat.gob.mx/portal/public/tramites/complemento-de-nomina';

    public function __construct(
        private readonly ResourcesGatewayInterface $gateway,
    ) {
    }

    public function accepts(OriginInterface $origin): bool
    {
        return $origin instanceof Nomina12eOrigin;
    }

    public function review(OriginInterface $origin): Review
    {
        if (! $this->accepts($origin)) {
            throw new LogicException('This reviewer can only handle Nomina12eOrigin objects');
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
            $page->navigate(self::NOMINA_12E_URL)->waitForNavigation(timeout: 10_000);

            // wait until there is a div.tab-container div.tab-label with text Información especializada
            $tabSelector = new XPathSelector(implode('', [
                '//div[contains(@class, "tab-container")]',
                '//div[contains(@class, "tab-label")]',
                '//span[contains(text(), "Información especializada")]',
            ]));
            $page->waitUntilContainsElement($tabSelector);
            // click on the element
            $page->mouse()->findElement($tabSelector)->click();

            // wait for the loaded content
            $page->waitUntilContainsElement(
                new XPathSelector('//div[contains(@class, "tab-content")]'),
            );
            // search for every tab-content a that contains Catálogos del complemento
            $contentElements = $page->dom()->search(implode('', ['',
                '//div[contains(@class, "tab-content")]',
                '//a[contains(text(), "Catálogos del complemento")]',
            ]));
            if ([] === $contentElements) {
                throw new RuntimeException('Unable to find links');
            }

            // return href from element that contains href
            foreach ($contentElements as $contentElement) {
                $href = $contentElement->getAttribute('href');
                if (null !== $href) {
                    return $href;
                }
            }
            throw new RuntimeException('Unable to find URL on elements matching "Catálogos del complemento"');
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
