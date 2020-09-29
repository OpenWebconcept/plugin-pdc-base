<?php

/**
 * Class for handling the thema fields.
 */

namespace OWC\PDC\Base\RestAPI\SubThemaFields;

use OWC\PDC\Base\RestAPI\ItemFields\ConnectedField;
use WP_Post;

/**
 * Class for handling the thema fields.
 */
class GroupField extends ConnectedField
{
    /**
     * The condition for the creator.
     *
     * @return callable
     */
    protected function condition(): callable
    {
        return function () {
            return $this->plugin->settings->useGroupLayer();
        };
    }

    /**
     * Creates an array of connected posts.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        return $this->getConnectedItems($post->ID, $post->post_type . '_to_pdc-group');
    }
}
