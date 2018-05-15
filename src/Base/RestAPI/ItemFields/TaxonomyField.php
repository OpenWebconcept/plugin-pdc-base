<?php

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Models\CreatesFields;

class TaxonomyField extends CreatesFields
{

    /**
     * Create an additional field on an array.
     *
     * @param array $post
     *
     * @return array
     */
    public function create(array $post)
    {
        $taxonomies = $this->plugin->config->get('taxonomies');

        $result = [];

        foreach (array_keys($taxonomies) as $taxonomy) {
            $result[$taxonomy] = $this->getTerms($post['id'], $taxonomy);
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
                'slug' => $term->slug
            ];
        }, $terms);
    }

}