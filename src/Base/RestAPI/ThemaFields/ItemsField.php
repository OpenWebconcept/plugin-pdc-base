<?php
/**
 * Adds connected fields to item in API.
 */

namespace OWC\PDC\Base\RestAPI\ThemaFields;

use OWC\PDC\Base\RestAPI\Controllers\ItemController;
use OWC\PDC\Base\RestAPI\ItemFields\ConnectedField;
use OWC\PDC\Base\Support\Traits\CheckPluginActive;
use WP_Post;

/**
 * Adds connected fields to item in API.
 */
class ItemsField extends ConnectedField
{
    use CheckPluginActive;

    /**
     * Creates an array of connected posts.
     */
    public function create(WP_Post $post): array
    {
        if ($this->isPluginPDCInternalProductsActive()) {
            $this->query['tax_query'] = ItemController::showExternalOnly();
        }

        return $this->getConnectedItems($post->ID, 'pdc-item_to_' . $post->post_type);
    }
}
