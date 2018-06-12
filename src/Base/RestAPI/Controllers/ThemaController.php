<?php

namespace OWC\PDC\Base\RestAPI\Controllers;

use WP_Error;
use WP_REST_Request;
use OWC\PDC\Base\Models\Thema;

class ThemaController extends BaseController
{

    /**
     * Get a list of all themas.
     */
    public function getThemas(WP_REST_Request $request)
    {
        $items = (new Thema)
            ->query(apply_filters('owc/pdc/rest-api/themas/query', $this->getPaginatorParams($request)))
            ->hide([ 'items' ]);

        $data = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }

    /**
     * Get an individual thema.
     *
     * @param $request $request
     *
     * @return array|WP_Error
     */
    public function getThema(WP_REST_Request $request)
    {
        $id = (int) $request->get_param('id');

        $thema = (new Thema)
            ->query(apply_filters('owc/pdc/rest-api/themas/query/single', []))
            ->find($id);

        if ( ! $thema) {
            return new WP_Error('no_item_found', sprintf('Thema with ID "%d" not found', $id), [
                'status' => 404
            ]);
        }

        return $thema;
    }

}