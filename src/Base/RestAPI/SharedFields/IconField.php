<?php

namespace OWC\PDC\Base\RestAPI\SharedFields;

use WP_Post;
use OWC\PDC\Base\Support\CreatesFields;

class IconField extends CreatesFields
{
    public function create(WP_Post $post): string
    {
        $icon = \get_post_meta($post->ID, '_owc_pdc_category_icon', true);

        if (false === $icon) {
            return '';
        }

        return $icon;
    }
}
