<?php

namespace OWC\PDC\Base\RestAPI\ThemaFields;

use OWC\PDC\Base\RestAPI\ItemFields\ConnectedField;
use WP_Post;

/**
 * Class for handling the thema fields.
 */
class TilesField extends ConnectedField
{
	/**
     * The condition for the creator.
     */
    protected function condition(): callable
    {
        return function () {
            return $this->plugin->settings->useThemeTiles();
        };
    }

    public function create(WP_Post $post): array
    {
        return get_post_meta($post->ID, '_owc_pdc_tiles_group', true) ?: [];
    }
}
