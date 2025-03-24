<?php

/**
 * Adds link fields to the output.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use WP_Post;
use OWC\PDC\Base\Support\CreatesFields;

/**
 * Adds link fields to the output.
 */
class LinksField extends CreatesFields
{
    /**
     * Generate the links field.
     */
    public function create(WP_Post $post): array
    {
        return array_map(function ($link) {
            $shortcode = isset($link['pdc_links_shortcode']) ? wp_kses_post(do_shortcode($link['pdc_links_shortcode'])) : '';
            $url = isset($link['pdc_links_url']) ? esc_url($link['pdc_links_url']) : '';

            if (! empty($shortcode)) {
                $url = $this->handlePossibleUrlInShortcode($shortcode);
            }

            return [
                'title' => esc_attr(strip_tags($link['pdc_links_title'])),
                'url' => $url,
            ];
        }, $this->getLinks($post));
    }

    /**
     * Extract a URL from a shortcode or return the shortcode itself if no URL is found
     * and the short is a URL itself.
     *
     * Some shortcodes may contain a URL embedded within an HTML element, such as an
     * <a> tag. This method attempts to extract the URL from the `href` attribute
     * using a regular expression. If no valid `href` is found, the raw shortcode
     * string is sanitized and returned as a fallback.
     */
    private function handlePossibleUrlInShortcode(string $shortcode): string
    {
        $regex = '/href=["\']([^"\']+)["\']/';

        if (preg_match($regex, $shortcode, $matches)) {
            $url = esc_url($matches[1]);
        } else {
            $url = esc_url($shortcode);
        }

        return filter_var($url, FILTER_VALIDATE_URL) ?: '';
    }

    /**
     * Get links of a post, if URL & title are present.
     */
    private function getLinks(WP_Post $post): array
    {
        $links = get_post_meta($post->ID, '_owc_pdc_links_group', true) ?: [];

        return array_filter($links, function ($link) {
            $hasUrlOrShortcode = ! empty($link['pdc_links_url']) || ! empty($link['pdc_links_shortcode']);
            $hasTitle = ! empty($link['pdc_links_title']);

            return $hasUrlOrShortcode && $hasTitle;
        });
    }
}
