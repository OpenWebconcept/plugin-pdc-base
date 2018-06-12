<?php

namespace OWC\PDC\Base\RestAPI\ThemaFields;

use WP_Post;
use OWC\PDC\Base\RestAPI\ItemFields\ConnectedField;

class Items extends ConnectedField
{

    /**
     * Creates an array of connected posts.
     *
     * @param WP_Post $post
     *
     * @return array
     */
    public function create(WP_Post $post): array
    {
        return $this->getConnectedItems($post->ID, 'pdc-item_to_'.$post->post_type);
    }

}