<?php

/**
 * Adds taxonomy to the output based on the taxonomies in the config.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;

/**
 * Adds taxonomy to the output based on the taxonomies in the config.
 */
class TaxonomyField extends CreatesFields
{

    /**
     * Create an additional field on an array.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        $result = [];

        foreach (array_keys($this->plugin->config->get('taxonomies')) as $taxonomy) {
            $result[$taxonomy] = $this->getTerms($post->ID, $taxonomy);
        }

        return $result;
    }

    /**
     * Get terms of a taxonomy to which the post is connected.
     *
     * @param int    $postID
     * @param string $taxonomy
     *
     * @return array
     */
    private function getTerms(int $postID, string $taxonomy): array
    {
        $terms = wp_get_post_terms($postID, $taxonomy);

        if (is_wp_error($terms)) {
            return [];
        }

        return array_map(function ($term) {
            return [
                'id'   => $term->term_id,
                'name' => $term->name,
                'slug' => $term->slug,
            ];
        }, $terms);
    }
}
