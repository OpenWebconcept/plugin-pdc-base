<?php

/**
 * Controller which handles the (requested) thema(s).
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use OWC\PDC\Base\Repositories\Thema;
use WP_Error;
use WP_REST_Request;

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
        $orderBy = $request->get_param('orderby') ?? 'title';
        $order   = $request->get_param('order') ?? 'ASC';
        $items   = (new Thema)
            ->query(apply_filters('owc/pdc/rest-api/themas/query', $this->getPaginatorParams($request)))
            ->query([
                'order'   => $order,
                'orderby' => $orderBy,
            ])
            ->hide(['items']);

        $data  = $items->all();
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

        if (!$thema) {
            return new WP_Error('no_item_found', sprintf('Thema with ID [%d] not found', $id), [
                'status' => 404,
            ]);
        }

        return $thema;
    }

    /**
     * Get an individual theme by slug.
     *
     * @param WP_Rest_Request $request
     *
     * @return array|WP_Error
     */
    public function getThemeBySlug(WP_REST_Request $request)
    {
        $slug = $request->get_param('slug');

        $theme = (new Thema)
            ->query(apply_filters('owc/pdc/rest-api/themas/query/single', []))
            ->findBySlug($slug);

        if (! $theme) {
            return new WP_Error(
                'no_theme_found',
                sprintf('Theme with slug [%s] not found', $slug),
                ['status' => 404]
            );
        }

        return $theme;
    }
}
