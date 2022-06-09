<?php

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;

class EnrichmentField extends CreatesFields
{
    /**
     * Create the enrichment field for a given post.
     */
    public function create(WP_Post $post): array
    {
        $enrichment = get_post_meta($post->ID, '_owc_enrichment-group', true);

        if(! is_array($enrichment) || empty($enrichment)){
            return [];
        }

        $enrichtmentInfo = [
            'enrichtment_date' => get_post_meta($post->ID, '_owc_enrichment_version_date', true),
            'enrichtment_version' => get_post_meta($post->ID, '_owc_enrichment_version', true)
        ];

        return array_merge($enrichtmentInfo, $enrichment);
    }
}