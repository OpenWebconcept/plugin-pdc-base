<?php

namespace OWC\PDC\Base\UPL\Enrichment\Commands;

use WP_Post;
use OWC\PDC\Base\Models\EnrichmentProduct;
use OWC\PDC\Base\Settings\SettingsPageOptions;
use OWC\PDC\Base\UPL\Enrichment\Controllers\Request;
use OWC\PDC\Base\UPL\Enrichment\Services\LocalEnrichmentSaver;

class EnrichmentItemsPDC
{
    public function execute(): void
    {
        $enrichmentProducts = $this->getEnrichmentProducts((SettingsPageOptions::make())->getEnrichmentURL());

        if (empty($enrichmentProducts['results'])) {
            \WP_CLI::error('No enrichment products found, stopping execution of this command.');
        }

        foreach ($this->convertToModels($enrichmentProducts['results']) as $enrichmentProduct) {
            // Get posts by product and handle.
            $this->addEnrichmentsToLocalProducts($this->getLocalProductsByUPL($enrichmentProduct->getLabel()), $enrichmentProduct);
        }
    }

    protected function getEnrichmentProducts(string $url): array
    {
        try {
            $currentProducts = (new Request($url))->get();
        } catch (\Exception $e) {
            \WP_CLI::warning($e->getMessage());

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
