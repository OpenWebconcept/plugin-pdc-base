<?php

/**
 * Adds connected fields to item in API.
 */

namespace OWC\PDC\Base\RestAPI\SharedFields;

use OWC\PDC\Base\RestAPI\Controllers\ItemController;
use OWC\PDC\Base\RestAPI\ItemFields\ConnectedField;
use OWC\PDC\Base\Support\Traits\CheckPluginActive;
use OWC\PDC\Base\Support\Traits\QueryHelpers;
use WP_Post;

/**
 * Adds connected fields to item in API.
 */
class ItemsField extends ConnectedField
{
    use CheckPluginActive;
    use QueryHelpers;

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

        $query = array_merge_recursive($query, $this->excludeInactiveItemsQuery());

        if ($this->isPluginPDCInternalProductsActive()) {
            $query = array_merge_recursive($query, $this->excludeInternalItemsQuery());
        }

        if ($this->shouldFilterSource()) {
            $query = array_merge_recursive($query, $this->filterShowOnTaxonomyQuery($this->source));
        }

        $query['connected_query'] = [
            'post_status' => ['publish', 'draft'],
        ];

        return $query;
    }
}
