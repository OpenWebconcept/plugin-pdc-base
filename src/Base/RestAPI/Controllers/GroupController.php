<?php

/**
 * Controller which handles the (requested) subthema(s).
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use WP_Error;
use WP_REST_Request;
use OWC\PDC\Base\Repositories\Group;

/**
 * Controller which handles the (requested) subthema(s).
 */
class GroupController extends BaseController
{
    /**
     * Get a list of all subthemas.
     */
    public function getGroups(WP_REST_Request $request): array
    {
        $items = (new Group())
            ->query(apply_filters('owc/pdc/rest-api/group/query', $this->getPaginatorParams($request)))
            ->query(['orderby' => 'name', 'order' => 'ASC']);

        $data = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }

    /**
     * Get an individual subthema.
     *
     * @return array|WP_Error
     */
    public function getGroup(WP_REST_Request $request)
    {
        $id = (int) $request->get_param('id');

        $group = (new Group())
            ->query(apply_filters('owc/pdc/rest-api/group/query/single', []))
            ->find($id);

        if (! $group) {
            return new WP_Error('no_item_found', sprintf('Group with ID [%d] not found', $id), [
                'status' => 404,
            ]);
        }

        return $group;
    }
}
