<?php

/**
 * Class for handling the thema fields.
 */

namespace OWC\PDC\Base\RestAPI\ThemaFields;

use WP_Post;
use OWC\PDC\Base\RestAPI\ItemFields\ConnectedField;

/**
 * Class for handling the thema fields.
 */
class ThemaField extends ConnectedField
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
        return $this->getConnectedItems($post->ID, 'pdc-category_to_pdc-subcategory', $this->extraQueryArgs('pdc-category_to_pdc-subcategory'));
    }
}
