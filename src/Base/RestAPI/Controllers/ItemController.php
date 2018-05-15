<?php

namespace OWC\PDC\Base\RestAPI\Controllers;

use WP_Error;
use WP_REST_Request;
use OWC\PDC\Base\Models\ItemModel;

class ItemController
{

    /**
     * Get a list of all items.
     */
    public function getItems()
    {
        return (new ItemModel())
            ->hide([ 'connected' ])
            ->query(apply_filters('owc/pdc/rest-api/items/query', []))
            ->all();
    }

    /**
     * Get an individual post item.
     *
     * @param $request $request
     *
     * @return array|WP_Error
     */
    public function getItem(WP_REST_Request $request)
    {
        $id = (int) $request->get_param('id');

        $item = (new ItemModel)
            ->query(apply_filters('owc/pdc/rest-api/items/single/query', []))
            ->find($id);

        if ( ! $item) {
            return new WP_Error('no_item_found', sprintf('Item with ID "%d" not found', $id), [
                'status' => 404
            ]);
        }

        return $item;
    }

}