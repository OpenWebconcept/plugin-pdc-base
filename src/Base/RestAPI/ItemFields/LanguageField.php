<?php

namespace OWC\PDC\Base\RestAPI\ItemFields;

use WP_Post;
use OWC\PDC\Base\Support\CreatesFields;

class LanguageField extends CreatesFields
{
    /**
     * Create the language field for a given post.
     *
     * @param WP_Post $post
     *
     * @return string
     */
    public function create(WP_Post $post): string
    {
        $language = get_post_meta($post->ID, '_owc_pdc-item-language', true);

        if (! $language) {
            return 'nl';
        }

        return $language;
    }
}
