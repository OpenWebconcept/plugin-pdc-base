<?php

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;

class EnrichmentField extends CreatesFields
{
    /**
     * The condition for the creator.
     *
     * @return callable
     */
    protected function condition(): callable
    {
        return function () {
            return $this->plugin->settings->useEnrichment();
        };
    }

    /**
     * Create the enrichment field for a given post.
     */
    public function create(WP_Post $post): array
    {
        $enrichment = get_post_meta($post->ID, '_owc_enrichment_language', true);

        if (! is_array($enrichment) || empty($enrichment)) {
            return [];
        }

        $enrichtmentInfo = [
            'enrichtment_date' => get_post_meta($post->ID, '_owc_enrichment_version_date', true),
            'enrichtment_version' => get_post_meta($post->ID, '_owc_enrichment_version', true)
        ];

        return array_merge($enrichtmentInfo, $enrichment);
    }
}
