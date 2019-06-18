<?php
/**
 * Controller which handles the (requested) pdc-item(s).
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use OWC\PDC\Base\Models\Item;
use WP_REST_Request;

/**
 * Controller which handles the searching of pdc-item(s).
 */
class SearchController extends ItemController
{
    /**
     * Get a list of all items.
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function search(WP_REST_Request $request)
    {
        $items = (new Item())
            ->hide(['connected'])
            ->query(apply_filters('owc/pdc/rest-api/items/query', $this->getPaginatorParams($request)))
            ->query($this->getSearchArray($request));

        $data  = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }
}
