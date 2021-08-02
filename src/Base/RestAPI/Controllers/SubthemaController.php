<?php

/**
 * Controller which handles the (requested) subthema(s).
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use OWC\PDC\Base\Repositories\Subthema;
use WP_Error;
use WP_REST_Request;

/**
 * Controller which handles the (requested) subthema(s).
 */
class SubthemaController extends BaseController
{

    /**
     * Get a list of all subthemas.
     *
     * @param WP_REST_Request $request
     *
     * @return void
     */
    public function getSubthemas(WP_REST_Request $request)
    {
        $items = (new Subthema)
            ->query(apply_filters('owc/pdc/rest-api/subthemas/query', $this->getPaginatorParams($request)))
            ->query(['orderby' => 'name', 'order' => 'ASC']);

        $data  = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }

    /**
     * Get an individual subthema.
     *
     * @param $request $request
     *
     * @return array|WP_Error
     */
    public function getSubthema(WP_REST_Request $request)
    {
        $id = (int) $request->get_param('id');

        $thema = (new Subthema)
            ->query(apply_filters('owc/pdc/rest-api/subthemas/query/single', []))
            ->find($id);

        if (!$thema) {
            return new WP_Error('no_item_found', sprintf('Subthema with ID [%d] not found', $id), [
                'status' => 404,
            ]);
        }

        return $thema;
    }

    /**
     * Get an individual subtheme by slug.
     *
     * @param WP_Rest_Request $request
     *
     * @return array|WP_Error
     */
    public function getSubthemeBySlug(WP_REST_Request $request)
    {
        $slug = $request->get_param('slug');

        $subtheme = (new Subthema)
            ->query(apply_filters('owc/pdc/rest-api/subthemas/query/single', []))
            ->findBySlug($slug);


        if (! $subtheme) {
            return new WP_Error(
                'no_subtheme_found',
                sprintf('Subheme with slug [%s] not found', $slug),
                ['status' => 404]
            );
        }

        return $subtheme;
    }
}
