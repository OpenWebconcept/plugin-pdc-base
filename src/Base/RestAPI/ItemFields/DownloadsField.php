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
class DownloadsField extends CreatesFields
{

    /**
     * Get the downloads associated to the post.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        return array_map(function ($download) {
            $url = $download['pdc_downloads_url'];
            if (empty($download['pdc_downloads_url'])) {
                $url = do_shortcode($download['pdc_downloads_shortcode']);
            }

            return [
                'title'    => esc_attr(strip_tags($download['pdc_downloads_title'])),
                'url'      => esc_url($url),
                'filesize' => $this->getFileSize($url)
            ];
        }, $this->getDownloads($post));
    }

    /**
     * Get downloads of a post, if URL & title are present.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    private function getDownloads(WP_Post $post)
    {
        return array_filter(get_post_meta($post->ID, '_owc_pdc_downloads_group', true) ?: [], function ($download) {
            return (!empty($download['pdc_downloads_url']) or !empty($download['pdc_downloads_shortcode'])) && (!empty($download['pdc_downloads_title']));
        });
    }
}
