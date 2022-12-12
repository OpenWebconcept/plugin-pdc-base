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
        if (! $this->settings->useEnrichment() || ! $this->settings->enableInputFacility()) {
            return;
        }

        // First delete so the notification is not unnecessary thrown.
        \delete_post_meta($postID, '_owc_pdc_sdg_push_notification');

        if ($post->post_type !== 'pdc-item' || ! $this->shouldPush($post)) {
            return;
        }

        $enrichedProduct = (new EnrichmentProductResolver($post))->resolve();

        try {
            $result = $this->makeRequest($enrichedProduct);
        } catch(\Exception $e) {
            $response = [
                'code' => 'error',
                'message' => implode(' ', [
                    __('Something went wrong with sending data to the SDG.', 'pdc-base'),
                    sprintf('Error: %s', $e->getMessage())
                ])
            ];
        }

        if (empty($response)) {
            $response = [
                'code' => 'success',
                'message' => __('Sending data to the SDG succeeded!', 'pdc-base')
            ];
        }

        \update_post_meta($postID, '_owc_pdc_sdg_push_notification', wp_json_encode($response));
    }

    protected function shouldPush(WP_Post $post): bool
    {
        $sendToSDG = get_post_meta($post->ID, '_owc_enrichment_send_data_to_sdg', true);
        $isEnriched = get_post_meta($post->ID, '_owc_enrichment_version', true);

        return $sendToSDG === '1' && ! empty($isEnriched) ? true : false;
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
