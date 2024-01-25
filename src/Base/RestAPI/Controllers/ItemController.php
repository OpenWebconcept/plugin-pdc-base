<?php

/**
 * Controller which handles the (requested) pdc-item(s).
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use WP_Error;
use WP_REST_Request;
use OWC\PDC\Base\Repositories\Item;
use OWC\PDC\Base\Support\Traits\QueryHelpers;
use OWC\PDC\Base\Support\Traits\CheckPluginActive;

/**
 * Controller which handles the (requested) pdc-item(s).
 */
class ItemController extends BaseController
{
    use CheckPluginActive;
    use QueryHelpers;

    /**
     * Get a list of all items.
     */
    public function getItems(WP_REST_Request $request): array
    {
        $parameters = $this->convertParameters($request->get_params());
        $items = (new Item())
            ->query(apply_filters('owc/pdc/rest-api/items/query', $this->getPaginatorParams($request)))
            ->query($parameters)
            ->query($this->excludeInactiveItemsQuery());

        if ($this->plugin->settings->useShowOn() && $this->showOnParamIsValid($request)) {
            $items->filterSource($request->get_param('source'));
        };

        if (false === $parameters['include-connected']) {
            $items->hide(['connected']);
        }

        $data = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }

    /**
     * Convert the parameters to the allowed ones.
     */
    protected function convertParameters(array $parametersFromRequest): array
    {
        $allowedQueryParams = [
            'name',
            'include-connected',
            'slug',
            'id',
            'p',
            'tax_query',
            'meta_query',
            'post_type',
            'post_status',
        ];

        $parameters = array_filter(
            $parametersFromRequest,
            static function ($param) use ($allowedQueryParams) {
                return in_array($param, $allowedQueryParams, true);
            },
            ARRAY_FILTER_USE_KEY
        );

        if (isset($parameters['name'])) {
            $parameters['name'] = esc_attr($parameters['name']);
        }

        $parameters['include-connected'] = (isset($parameters['include-connected'])) ? true : false;

        if (isset($parameters['slug'])) {
            $parameters['name'] = esc_attr($parameters['slug']);
            unset($parameters['slug']);
        }

        if (isset($parameters['id'])) {
            $parameters['p'] = absint($parameters['id']);
            unset($parameters['id']);
        }

        return $parameters;
    }

    /**
     * Get an individual post item.
     *
     * @return array|WP_Error
     */
    public function getItem(WP_REST_Request $request)
    {
        $id = (int) $request->get_param('id');
        $item = $this->buildQueryFromRequest($request);

        $item = $item->find($id);

        if (! $item) {
            return new WP_Error('no_item_found', sprintf('Item with ID [%d] not found', $id), [
                'status' => 404,
            ]);
        }

        if ($this->needsAuthorization($item)) {
            return new WP_Error(
                'unauthorized_request',
                sprintf('Unauthorized request for item with ID [%d]', $id),
                ['status' => 401]
            );
        }

        return $item;
    }

    /**
     * Get an individual post item by slug.
     *
     * @return array|WP_Error
     */
    public function getItemBySlug(WP_REST_Request $request)
    {
        $slug = $request->get_param('slug');
        $item = $this->buildQueryFromRequest($request);

        $item = $item->findBySlug($slug);

        if (! $item) {
            return new WP_Error(
                'no_item_found',
                sprintf('Item with slug [%s] not found', $slug),
                ['status' => 404]
            );
        }

        if ($this->needsAuthorization($item)) {
            return new WP_Error(
                'unauthorized_request',
                sprintf('Unauthorized request for item with slug [%s]', $slug),
                ['status' => 401]
            );
        }

        return $item;
    }

    public function buildQueryFromRequest(WP_REST_Request $request): Item
    {
        $item = (new Item())
            ->query(apply_filters('owc/pdc/rest-api/items/query/single', []))
            ->query(['post_status' => $this->getPostStatus($request)])
            ->query($this->excludeInactiveItemsQuery());

        $password = esc_attr($request->get_param('password'));
        if (! empty($password)) {
            $item->setPassword($password);
        }

        if ($this->plugin->settings->useShowOn() && $this->showOnParamIsValid($request)) {
            $item->filterSource($request->get_param('source'));
        };

        $connectedField = $item->getGlobalField('connected');
        if ($request->get_param('connected_sort') && ! empty($connectedField)) {
            $connectedField['creator']->setSorting(
                $request->get_param('connected_sort'),
                strtoupper($request->get_param('connected_sort_direction')) ?: 'ASC',
                $request->get_param('connected_sort_type') ?: 'string'
            );
        }

        return $item;
    }

    private function needsAuthorization(array $item): bool
    {
        if (! $this->isPluginPDCInternalProductsActive()) {
            return false;
        }

        $types = $item['taxonomies']['pdc-type'] ?? [];

        if (empty($types)) {
            return false;
        }

        foreach ($types as $type) {
            if ('external' === $type['slug']) {
                return false;
            }
        }

        return true;
    }
}
