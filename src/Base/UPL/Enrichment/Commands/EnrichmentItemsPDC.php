<?php

namespace OWC\PDC\Base\UPL\Enrichment\Commands;

use OWC\PDC\Base\Settings\SettingsPageOptions;
use OWC\PDC\Base\UPL\Enrichment\Controllers\Request as RequestControlller;
use OWC\PDC\Base\UPL\Enrichment\Models\EnrichmentProduct;
use OWC\PDC\Base\UPL\Enrichment\Services\LocalEnrichmentSaver;
use WP_CLI;

class EnrichmentItemsPDC
{
    protected RequestControlller $requestController;
    protected SettingsPageOptions $settings;

    public function __construct()
    {
        $this->requestController = new RequestControlller();
        $this->settings = SettingsPageOptions::make();
    }

    public function execute(): void
    {
        try {
            $products = $this->getEnrichmentProducts($this->settings->getEnrichmentURL()); // Fetch products of municipality.
            $defaultProducts = $this->getEnrichmentProducts($this->settings->getDefaultEnrichmentURL()); // Fetch products provided by the VNG.
        } catch(\Exception $e) {
            WP_CLI::error(sprintf('%s Stopping execution of this command.', $e->getMessage()));
        }

        if (empty($products['results'])) {
            WP_CLI::error('No enrichment products found, stopping execution of this command.'); // Stops execution of command.
        }

        if (empty($defaultProducts['results'])) {
            WP_CLI::warning('No default enrichment products found, stopping execution of this command.');
        }

        $combinedProducts = $this->combineProducts($products['results'], $defaultProducts['results'] ?? []);

        foreach ($this->convertToModels($combinedProducts) as $enrichmentProduct) {
            // Get posts by product and handle.
            $this->addEnrichmentsToLocalProducts($this->getLocalProductsByUPL($enrichmentProduct->getLabel()), $enrichmentProduct);
        }
    }

    protected function combineProducts(array $products, array $defaultProducts)
    {
        $combined = [];

        foreach ($products as $index => $product) {
            $product['vertalingen'] = $this->combineTranslations($product['vertalingen'], $defaultProducts[$index]['vertalingen']);
            $combined[] = $product;
        }

        return $combined;
    }

    protected function combineTranslations(array $productTranslations, array $defaultProductTranslations): array
    {
        $combined = [];

        foreach ($productTranslations as $index => $productTranslation) {
            $productTranslation['procedureBeschrijving_default'] = $defaultProductTranslations[$index]['procedureBeschrijving'] ?? '';
            $productTranslation['bewijs_default'] = $defaultProductTranslations[$index]['bewijs'] ?? '';
            $productTranslation['vereisten_default'] = $defaultProductTranslations[$index]['vereisten'] ?? '';
            $productTranslation['bezwaarEnBeroep_default'] = $defaultProductTranslations[$index]['bezwaarEnBeroep'] ?? '';
            $productTranslation['kostenEnBetaalmethoden_default'] = $defaultProductTranslations[$index]['kostenEnBetaalmethoden'] ?? '';
            $productTranslation['uitersteTermijn_default'] = $defaultProductTranslations[$index]['uitersteTermijn'] ?? '';
            $productTranslation['wtdBijGeenReactie_default'] = $defaultProductTranslations[$index]['wtdBijGeenReactie'] ?? '';

            $combined[] = $productTranslation;
        }

        return $combined;
    }

    protected function getEnrichmentProducts(string $url = ''): array
    {
        if (empty($url)) {
            throw new \Exception('Unable to fetch enrichment products, $url parameter is empty!');
        }

        $this->requestController->setURL($url);
        $this->requestController->setArgs($this->getArgs());

        try {
            $currentProducts = $this->requestController->get();
        } catch (\Exception $e) {
            WP_CLI::warning($e->getMessage());

            return [];
        }

        $nextPage = $currentProducts['next'] ?? '';

        if (empty($nextPage)) {
            return $currentProducts;
        }

        // Recursive, method calls itself so it handles paginated results.
        $nextProducts = $this->getEnrichmentProducts($nextPage);

        // Merge results from the next iteration in to the current one.
        $nextProducts['results'] = $this->combinePaginated($currentProducts, $nextProducts);

        return $nextProducts;
    }

    protected function getArgs(): array
    {
        $args = [
            'method' => 'GET'
        ];

        if (! empty($_ENV['SDG_API_TOKEN'])) { // Enrichment endpoint is temporary protected therefore API token is required.
            $args['headers'] = ['Authorization' => sprintf('Bearer %s', $_ENV['SDG_API_TOKEN'])];
        }

        return $args;
    }

    protected function combinePaginated($currentProducts, $nextProducts): array
    {
        $initialResults = $currentProducts['results'] ?? [];
        $pagedResults = $nextProducts['results'] ?? [];

        return array_merge($initialResults, $pagedResults);
    }

    protected function convertToModels($products): array
    {
        return array_map(function ($product) {
            return new EnrichmentProduct($product);
        }, $products);
    }

    protected function addEnrichmentsToLocalProducts(array $localProducts, EnrichmentProduct $enrichmentProduct)
    {
        foreach ($localProducts as $localProduct) {
            $saver = new LocalEnrichmentSaver($localProduct, $enrichmentProduct);
            $saver->save();
        }
    }

    protected function getLocalProductsByUPL($value): array
    {
        $args = [
            'post_type' => 'pdc-item',
            'post_status' => ['publish', 'draft'],
            'meta_query' => [
                [
                    'key'     => '_owc_pdc_upl_naam',
                    'value'   => $value,
                    'compare' => '=',
                ]
            ]
        ];

        $query = new \WP_Query($args);

        if (empty($query->posts)) {
            return [];
        }

        return $query->posts;
    }
}
