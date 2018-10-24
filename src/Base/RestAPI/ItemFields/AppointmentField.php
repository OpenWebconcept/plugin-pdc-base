<?php
/**
 * Adds download fields to the output.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;

/**
 * Adds download fields to the output.
 */
class AppointmentField extends CreatesFields
{

    /**
     * Create the appointment field for a given post.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        $active = get_post_meta($post->ID, '_owc_pdc_afspraak_active', true);

        if (! $active) {
            return [
                'active' => false
            ];
        }

        return [
            'active' => true,
            'title'  => esc_attr(strip_tags(get_post_meta($post->ID, '_owc_pdc_afspraak_title', true) ?: '')),
            'url'    => esc_url(get_post_meta($post->ID, '_owc_pdc_afspraak_url', true) ?: ''),
            'meta'   => esc_attr(get_post_meta($post->ID, '_owc_pdc_afspraak_meta', true) ?: ''),
        ];
    }
}
