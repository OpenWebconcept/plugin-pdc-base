<?php

/**
 * Adds portal url field to the output.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use OWC\PDC\Base\Support\CreatesFields;
use WP_Post;

class DateModified extends CreatesFields
{
    /**
     * The condition for the creator.
     *
     * @return callable
     */
    protected function condition(): callable
    {
        return function () {
            return $this->plugin->settings->usePortalURL();
        };
    }

    /**
     * Create the portal url field for a given post.
     *
     * @param WP_Post $post
     *
     * @return string
     */
    public function create(WP_Post $post): string
    {
        return (string) $post->post_modified;
    }
}
