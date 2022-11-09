<?php

namespace OWC\PDC\Base\UPL\Enrichment\Controllers;

use OWC\PDC\Base\UPL\Enrichment\Models\EnrichmentProduct;
use OWC\PDC\Base\Settings\SettingsPageOptions;
use OWC\PDC\Base\UPL\Enrichment\Controllers\Request as RequestControlller;
use OWC\PDC\Base\UPL\Enrichment\Services\EnrichmentProductResolver;
use WP_Post;

class Push
{
    protected RequestControlller $requestController;
    protected SettingsPageOptions $settings;

    public function __construct()
    {
        $this->requestController = new RequestControlller();
        $this->settings = SettingsPageOptions::make();
    }

    public function handlePush(int $postID, WP_Post $post, bool $update, $post_before)
    {
        // $error = new \WP_Error(500, 'test', ['status' => 500]);
        // wp_send_json_error($error, 500);
        // wp_ajax_send_link_to_editor();
        // return;

        if (! $this->settings->enableInputFacility()) {
            return;
        }

        if ($post->post_type !== 'pdc-item' || ! $this->shouldPush($post)) {
            return;
        }

        $enrichedProduct = (new EnrichmentProductResolver($post))->resolve();

        try {
            $result = $this->makeRequest($enrichedProduct);
        } catch(\Exception $e) {
            // send error to pdc-item editor.
        }
    }

    protected function shouldPush(WP_Post $post): bool
    {
        $value = get_post_meta($post->ID, '_owc_enrichment_send_data_to_sdg', true);

        return $value === '1' ? true : false;
    }

    protected function makeRequest(EnrichmentProduct $enrichedProduct): array
    {
        $this->requestController->setURL($this->makeURL('producten'));
        $this->requestController->setArgs($this->makeArgs($enrichedProduct));

        return $this->requestController->post();
    }

    protected function makeURL(string $endpoint): string
    {
        $baseURL = $this->settings->getInputFacilityBaseApiURL();

        return sprintf('%s/%s', untrailingslashit($baseURL), $endpoint);
    }

    protected function makeArgs(EnrichmentProduct $enrichedProduct): array
    {
        return [
            'method' => 'POST',
            'headers' => [
                'Authorization' => 'Token ' . $this->settings->getInputFacilityApiToken(),
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($enrichedProduct->jsonSerialize())
        ];
    }
}
