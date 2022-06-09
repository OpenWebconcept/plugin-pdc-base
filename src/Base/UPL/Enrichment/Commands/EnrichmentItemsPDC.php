<?php

namespace OWC\PDC\Base\UPL\Enrichment\Commands;

use OWC\PDC\Base\Models\EnrichmentProduct;
use OWC\PDC\Base\Settings\SettingsPageOptions;
use OWC\PDC\Base\UPL\Enrichment\Controllers\Request;

class EnrichmentItemsPDC
{
    public function execute(): void
    {
        $products = $this->getEnrichmentProducts((SettingsPageOptions::make())->getEnrichmentURL());

        if (empty($products['results'])) {
            \WP_CLI::error('No enrichment products found, stopping execution of this command.');
        }

        foreach ($this->convertToModels($products['results']) as $product) {
            // Get posts by product and handle.
            $this->handlePosts($this->getPosts($product->getLabel()), $product);
        }
    }

    protected function getEnrichmentProducts(string $url): array
    {
        try {
            $currentProducts = (new Request($url))->get();
        } catch(\Exception $e) {
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

    protected function handlePosts(array $posts, $product)
    {
        foreach ($posts as $post) {
            $currentVersion = (int) \get_post_meta($post->ID, '_owc_enrichment_version', true);
            $newVersion = (int) $product->getVersion();

            if ($newVersion <= $currentVersion) {
                continue;
            }

            $result = \update_post_meta($post->ID, '_owc_enrichment-group', $this->getTranslationByLanguage($post, $product->getTranslations()));

            if (! $result) {
                continue;
            }

            \update_post_meta($post->ID, '_owc_enrichment_version', $product->getVersion());
            \update_post_meta($post->ID, '_owc_enrichment_version_date', date('Y-m-d H:i:s'));
        }
    }

    protected function getTranslationByLanguage($post, $translations): array
    {
        $language = \get_post_meta($post->ID, '_owc_pdc-item-language', true) ?: 'nl';

        $filtered = array_filter($translations, function ($translation) use ($language) {
            return $translation->getLanguage() === $language;
        });

        $mapped = array_map(function ($translation) {
            return [
                'enrichment_language' => $translation->getLanguage(),
                'enrichment_specific_text' => $translation->getSpecificText(),
                'enrichment_procedure_description' => $translation->getProcedureDescription()
            ];
        }, $filtered);

        return array_values($mapped)[0] ?? [];
    }

    protected function getPosts($value): array
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
