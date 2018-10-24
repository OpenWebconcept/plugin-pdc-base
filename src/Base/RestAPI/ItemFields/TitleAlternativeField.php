<?php
/**
 * Adds alternative title field to the output.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;

/**
 * Adds alternative title field to the output.
 */
class TitleAlternativeField extends CreatesFields
{

    /**
     * Get an alternative title of the post.
     *
     * @param WP_Post $post
     *
     * @return string
     */
    public function create(WP_Post $post): string
    {
        $title = get_post_meta($post->ID, '_owc_pdc_titel_alternatief', true);
        $title = strip_tags($title);
        $title = preg_replace('#[\n\r]+#s', ' ', $title);

        return apply_filters('owc/pdc-base/rest-api/item/field/title-alternative', $title, $post);
    }
}
