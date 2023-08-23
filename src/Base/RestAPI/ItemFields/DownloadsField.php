<?php

namespace OWC\PDC\Base\RestAPI\ItemFields;

use WP_Post;
use OWC\PDC\Base\Support\CreatesFields;

class DownloadsField extends CreatesFields
{
    /**
     * Get the downloads associated to the post.
     */
    public function create(WP_Post $post): array
    {
        return array_map(function ($download) {
            $url = $download['pdc_downloads_url'] ?? '';

            if (empty($url)) {
                $url = do_shortcode($download['pdc_downloads_shortcode']);
            }

            return [
                'title' => esc_attr(strip_tags($download['pdc_downloads_title'])),
                'url' => esc_url($url),
                'filesize' => $this->getFileSize($url)
            ];
        }, $this->getDownloads($post));
    }

    /**
     * Get downloads of a post, if URL & title are present.
     */
    private function getDownloads(WP_Post $post): array
    {
        return array_filter(get_post_meta($post->ID, '_owc_pdc_downloads_group', true) ?: [], function ($download) {
            return (! empty($download['pdc_downloads_url']) || ! empty($download['pdc_downloads_shortcode'])) && (! empty($download['pdc_downloads_title']));
        });
    }
}
