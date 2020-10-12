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
class IdentificationsField extends CreatesFields
{

    /**
     * The condition for the creator.
     *
     * @return callable
     */
    protected function condition(): callable
    {
        return function () {
            return $this->plugin->settings->useIdentifications();
        };
    }

    /**
     * Create the appointment field for a given post.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        $identifications = [];

        $identifications['digid']       = $this->createDigiD($post);
        $identifications['eherkenning'] = $this->createEherkenning($post);
        $identifications['eidas']       = $this->createEidas($post);

        return $identifications;
    }

    private function createDigiD(WP_Post $post): array
    {
        $digidActive = get_post_meta($post->ID, '_owc_digid_active', true);

        if (!$digidActive) {
            return [
                'active' => false
            ];
        }

        return [
            'active' => true,
            'title'  => esc_attr(strip_tags(get_post_meta($post->ID, '_owc_digid_button_title', true) ?: '')),
            'url'    => esc_url(get_post_meta($post->ID, '_owc_digid_button_url', true) ?: ''),
            'meta'   => esc_attr(get_post_meta($post->ID, '_owc_digid_descriptive_text', true) ?: ''),
        ];
    }

    private function createEherkenning(WP_Post $post): array
    {
        $eherkenningActive = get_post_meta($post->ID, '_owc_eherkenning_active', true);

        if (!$eherkenningActive) {
            return [
                'active' => false
            ];
        }

        return [
            'active' => true,
            'title'  => esc_attr(strip_tags(get_post_meta($post->ID, '_owc_eherkenning_button_title', true) ?: '')),
            'url'    => esc_url(get_post_meta($post->ID, '_owc_eherkenning_button_url', true) ?: ''),
            'meta'   => esc_attr(get_post_meta($post->ID, '_owc_eherkenning_descriptive_text', true) ?: ''),
        ];
    }

    private function createEidas(WP_Post $post): array
    {
        $eidasActive = get_post_meta($post->ID, '_owc_eidas_active', true);

        if (!$eidasActive) {
            return [
                'active' => false
            ];
        }

        return [
            'active' => true,
            'title'  => esc_attr(strip_tags(get_post_meta($post->ID, '_owc_eidas_button_title', true) ?: '')),
            'url'    => esc_url(get_post_meta($post->ID, '_owc_eidas_button_url', true) ?: ''),
            'meta'   => esc_attr(get_post_meta($post->ID, '_owc_eidas_descriptive_text', true) ?: ''),
        ];
    }
}
