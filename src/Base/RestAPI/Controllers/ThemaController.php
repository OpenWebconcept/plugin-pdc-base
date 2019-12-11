<?php
/**
 * Controller which handles the (requested) thema(s).
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use OWC\PDC\Base\Models\Thema;
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
        $parameters = $this->convertParameters($request);
        $items      = (new Thema)
            ->query(apply_filters('owc/pdc/rest-api/themas/query', $this->getPaginatorParams($request)))
            ->query($parameters);

        if (false === $parameters['include-items']) {
            $items->hide(['items']);
        }

        $data  = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }

    /**
     * Convert the parameters to the allowed ones.
     *
     * @param Request $parametersFromRequest
     * @return array
     */
    protected function convertParameters(WP_REST_Request $parametersFromRequest): array
    {
        $parameters = [];

        $parameters['orderby']       = $parametersFromRequest->get_param('orderby') ?? 'title';
        $parameters['order']         = $parametersFromRequest->get_param('order') ?? 'ASC';
        $parameters['include-items'] = (isset($parametersFromRequest['include-items'])) ? true : false;

        return $parameters;
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
            return new WP_Error('no_item_found', sprintf('Thema with ID "%d" not found', $id), [
                'status' => 404,
            ]);
        }

        return $thema;
    }
}
