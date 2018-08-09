<?php
/**
 * Controller which handles the (requested) thema(s).
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use WP_Error;
use WP_REST_Request;
use OWC\PDC\Base\Models\Thema;

/**
 * Controller which handles the (requested) thema(s).
 */
class ThemaController extends BaseController
{

    /**
     * Get a list of all themas.
     * 
     * @param WP_REST_Request $request
     * 
     * @return void
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
     * @param WP_REST_Request $request
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