<?php

/**
 * Adds connected fields to item in API.
 */

namespace OWC\PDC\Base\RestAPI\SharedFields;

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
        $connectionType = 'pdc-item_to_' . $post->post_type;

        return $this->getConnectedItems($post->ID, $connectionType, $this->extraQueryArgs($connectionType));
    }

    protected function extraQueryArgs(string $type): array
    {
        $query = [];

        $query = array_merge_recursive($query, ItemController::excludeInactiveItems());

        if ($this->isPluginPDCInternalProductsActive()) {
            $query = array_merge_recursive($query, ItemController::excludeInternalItems());
        }

        $query['connected_query'] = ['post_status' => ['publish', 'draft']];

        return $query;
    }
}
