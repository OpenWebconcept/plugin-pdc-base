<?php

/**
 * Adds boolean field to the output which indicates if the item uses table of contents.
 */

namespace OWC\PDC\Base\RestAPI\ItemFields;

use WP_Post;
use OWC\PDC\Base\Models\Item;
use OWC\PDC\Base\Support\CreatesFields;

class TableOfContentsField extends CreatesFields
{
    /**
     * The condition for the creator.
     */
    protected function condition(): callable
    {
        return function () {
            return $this->plugin->settings->useTableOfContents();
        };
    }

    public function create(WP_Post $post): bool
    {
        $itemModel = new Item($post->to_array());

        return $itemModel->useTableOfContents();
    }
}
