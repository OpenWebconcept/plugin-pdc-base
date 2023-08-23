<?php

/**
 * Adds portal url field to the output.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use WP_Post;
use OWC\PDC\Base\Support\CreatesFields;

class DateModified extends CreatesFields
{
    public function create(WP_Post $post): string
    {
        return (string) $post->post_modified;
    }
}
