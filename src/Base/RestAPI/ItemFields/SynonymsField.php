<?php
/**
 * Adds synonyms field to the output.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;

/**
 * Adds synonyms fields to the output.
 */
class SynonymsField extends CreatesFields
{

    /**
     * Create the synonyms field for a given post.
     *
     * @param WP_Post $post
     *
     * @return string
     */
    public function create(WP_Post $post): string
    {
        return get_post_meta($post->ID, '_owc_pdc_tags', true);
    }
}
