<?php

namespace OWC\PDC\Base\RestAPI\Controllers;

use WP_Error;
use WP_REST_Request;
use OWC\PDC\Base\Models\Item;

class ItemController extends BaseController
{

    /**
     * Get a list of all items.
     */
    public function getItems(WP_REST_Request $request)
    {
        $items = (new Item())
            ->hide([ 'connected' ])
            ->query(apply_filters('owc/pdc/rest-api/items/query', $this->getPaginatorParams($request)))
            ->query($this->hideInactiveItem());

        $data = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
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

        $item = (new Item)
            ->query(apply_filters('owc/pdc/rest-api/items/query/single', []))
            ->query($this->hideInactiveItem())
            ->find($id);

        if ( ! $item) {
            return new WP_Error('no_item_found', sprintf('Item with ID "%d" not found', $id), [
                'status' => 404
            ]);
        }

        return $item;
    }

    /**
     * Hide inactive item from output.
     */
    protected function hideInactiveItem() {
        return [
            'meta_query' => [
                [
                    'key' => '_owc_pdc_active',
                    'value' => 1
                ]
            ]
        ];
    }

}