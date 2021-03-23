<?php
/**
 * Adds connected fields to item in API.
 */

namespace OWC\PDC\Base\RestAPI\ThemaFields;

use OWC\PDC\Base\RestAPI\Controllers\ItemController;
use OWC\PDC\Base\RestAPI\ItemFields\ConnectedField;
use WP_Post;

/**
 * Adds connected fields to item in API.
 */
class ItemsField extends ConnectedField
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
        $this->query['tax_query'] = ItemController::showExternalOnly();

        return $this->getConnectedItems($post->ID, 'pdc-item_to_' . $post->post_type);
    }
}
