<?php

/**
 * Controller which handles the (requested) pdc-item(s).
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use OWC\PDC\Base\Repositories\Item;
use OWC\PDC\Base\Support\Traits\CheckPluginActive;
use WP_Error;
use WP_REST_Request;

/**
 * Controller which handles the (requested) pdc-item(s).
 */
class ItemController extends BaseController
{
    use CheckPluginActive;

    /**
     * Get a list of all items.
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function getItems(WP_REST_Request $request)
    {
        $parameters = $this->convertParameters($request->get_params());
        $items      = (new Item())
            ->query(apply_filters('owc/pdc/rest-api/items/query', $this->getPaginatorParams($request)))
            ->query($parameters)
            ->query(self::hideInactiveItem());

        if (false === $parameters['include-connected']) {
            $items->hide(['connected']);
        }

        $data  = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }

    /**
     * Convert the parameters to the allowed ones.
     *
     * @param array $parametersFromRequest
     *
     * @return array
     */
    protected function convertParameters(array $parametersFromRequest): array
    {
        $parameters = [];

        if (isset($parametersFromRequest['name'])) {
            $parameters['name'] = esc_attr($parametersFromRequest['name']);
        }

        $parameters['include-connected'] = (isset($parametersFromRequest['include-connected'])) ? true : false;

        if (isset($parametersFromRequest['slug'])) {
            $parameters['name'] = esc_attr($parametersFromRequest['slug']);
            unset($parametersFromRequest['slug']);
        }

        if (isset($parametersFromRequest['id'])) {
            $parameters['p'] = absint($parametersFromRequest['id']);
            unset($parametersFromRequest['slug']);
        }

        return $parameters;
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
            ->query(self::hideInactiveItem())
            ->find($id);

        if (! $item) {
            return new WP_Error('no_item_found', sprintf('Item with ID [%d] not found', $id), [
                'status' => 404,
            ]);
        }

        if ($this->needsAuthorization($item)) {
            return new WP_Error(
                'unauthorized_request',
                sprintf('Unauthorized request for [%d]', $id),
                ['status' => 401]
            );
        }

        return $item;
    }

    /**
     * Get an individual post item by slug.
     *
     * @param $request $request
     *
     * @return array|WP_Error
     */
    public function getItemBySlug(WP_REST_Request $request)
    {
        $slug = $request->get_param('slug');
        $item = (new Item)
            ->query(apply_filters('owc/pdc/rest-api/items/query/single', []))
            ->query(self::hideInactiveItem())
            ->findBySlug($slug);


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
                sprintf('Unauthorized request for [%s]', $slug),
                ['status' => 401]
            );
        }

        return $item;
    }

    /**
     * Hide inactive item from output.
     */
    public static function hideInactiveItem(): array
    {
        return [
            'meta_query' => [
                [
                    'key'     => '_owc_pdc_active',
                    'value'   => '1',
                    'compare' => '=',
                ],
            ]
        ];
    }

    /**
     * Hide internal items from output
     */
    public static function showExternalOnly(): array
    {
        return [
            'tax_query' => [
                'relation' => 'OR',
                [
                    'taxonomy'     => 'pdc-type',
                    'field'        => 'slug',
                    'terms'        => 'external',
                ],
                [
                    'taxonomy'        => 'pdc-type',
                    'field'           => 'id',
                    'operator'        => 'NOT EXISTS',
                ],
            ]
        ];
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
