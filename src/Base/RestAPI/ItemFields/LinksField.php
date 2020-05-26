<?php
/**
 * Adds link fields to the output.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;

/**
 * Adds link fields to the output.
 */
class LinksField extends CreatesFields
{
    /**
     * Generate the links field.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        return array_map(function ($link) {
            $shortcode = isset($link['pdc_links_shortcode']) ? do_shortcode($link['pdc_links_shortcode']) : '';
            $url = isset($link['pdc_links_url']) ? esc_url($link['pdc_links_url']) : '';
            if (!empty($shortcode)) {
                $url = $shortcode;
            }

            return [
                'title' => esc_attr(strip_tags($link['pdc_links_title'])),
                'url'   => $url,
            ];
        }, $this->getLinks($post));
    }

    /**
     * Get links of a post, if URL & title are present.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    private function getLinks(WP_Post $post)
    {
        return array_filter(get_post_meta($post->ID, '_owc_pdc_links_group', true) ?: [], function ($link) {
            return (!empty($link['pdc_links_url']) or !empty($link['pdc_links_shortcode'])) && (!empty($link['pdc_links_title']));
        });
    }
}
