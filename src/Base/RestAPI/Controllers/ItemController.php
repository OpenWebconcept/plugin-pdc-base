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
use OWC\PDC\Base\RestAPI\ItemFields\ConnectedFieldSorter;

/**
 * Controller which handles the (requested) pdc-item(s).
 */
class ItemController extends BaseController
{
    use CheckPluginActive;
    use QueryHelpers;

    /**
     * Route arguments for the items collection.
     *
     * @return array<string, array<string, mixed>>
     */
    public function collectionArguments(): array
    {
        return array_merge($this->paginatorArguments(), [
            'source' => $this->sourceArgument(),
            'pdc-doelgroep' => [
                'description' => esc_html__('Target audience slugs to filter on.', 'pdc-base'),
                'type' => 'array',
                'items' => ['type' => 'string'],
            ],
            'pdc-aspect' => [
                'description' => esc_html__('Aspect slugs to filter on.', 'pdc-base'),
                'type' => 'array',
                'items' => ['type' => 'string'],
            ],
            'pdc-usage' => [
                'description' => esc_html__('Usage slugs to filter on.', 'pdc-base'),
                'type' => 'array',
                'items' => ['type' => 'string'],
            ],
            'name' => [
                'description' => esc_html__('Item slug to filter on.', 'pdc-base'),
                'type' => 'string',
            ],
            'slug' => [
                'description' => esc_html__('Item slug to filter on, alias of name.', 'pdc-base'),
                'type' => 'string',
            ],
            'id' => [
                'description' => esc_html__('Item ID to filter on.', 'pdc-base'),
                'type' => 'integer',
            ],
            // Untyped: sites send it as a bare flag, which boolean validation would reject.
            'include-connected' => [
                'description' => esc_html__('Include connected items when present.', 'pdc-base'),
            ],
            'fields' => [
                'description' => esc_html__('Comma-separated list of fields to return.', 'pdc-base'),
                'type' => 'string',
            ],
        ]);
    }

    /**
     * Route arguments for a single item.
     *
     * @return array<string, array<string, mixed>>
     */
    public function singleArguments(): array
    {
        return [
            'draft-preview' => $this->draftPreviewArgument(),
            'source' => $this->sourceArgument(),
            'password' => [
                'description' => esc_html__('Password of a password-protected item.', 'pdc-base'),
                'type' => 'string',
            ],
            'connected_sort' => [
                'description' => esc_html__('Field to sort the connected items by.', 'pdc-base'),
                'type' => 'string',
                'enum' => [
                    ConnectedFieldSorter::SORTING_FIELD_TYPE_ID,
                    ConnectedFieldSorter::SORTING_FIELD_TYPE_TITLE,
                    ConnectedFieldSorter::SORTING_FIELD_TYPE_SLUG,
                    ConnectedFieldSorter::SORTING_FIELD_TYPE_EXCERPT,
                    ConnectedFieldSorter::SORTING_FIELD_TYPE_DATE,
                ],
            ],
            'connected_sort_type' => [
                'description' => esc_html__('How the connected items are compared when sorting.', 'pdc-base'),
                'type' => 'string',
                'enum' => [
                    ConnectedFieldSorter::SORTING_TYPE_STRING,
                    ConnectedFieldSorter::SORTING_TYPE_INT,
                    ConnectedFieldSorter::SORTING_TYPE_DATE,
                ],
                'default' => ConnectedFieldSorter::SORTING_TYPE_STRING,
            ],
            // No enum: the value is upper-cased before use.
            'connected_sort_direction' => [
                'description' => esc_html__('Direction to sort the connected items in.', 'pdc-base'),
                'type' => 'string',
                'default' => ConnectedFieldSorter::DIRECTION_ASC,
            ],
            'fields' => [
                'description' => esc_html__('Comma-separated list of fields to return.', 'pdc-base'),
                'type' => 'string',
            ],
        ];
    }

    /**
     * Get a list of all items.
     */
    public function getItems(WP_REST_Request $request): array
    {
        $parameters = $this->convertParameters($request->get_params());
        $items = (new Item())
            ->query(apply_filters('owc/pdc/rest-api/items/query', $this->getPaginatorParams($request)))
            ->query($parameters)
            ->query($this->excludeInactiveItemsQuery())
            ->query(['orderby' => [
                'post_date' => 'DESC',
                'ID' => 'DESC',
            ]]);

        if ($this->plugin->settings->useShowOn() && $request->get_param('source')) {
            $items->filterSource($request->get_param('source'));
        };

        if (! empty($request->get_param('pdc-doelgroep'))) {
            $items->filterTargetAudience($request->get_param('pdc-doelgroep'));
        }

        if (! empty($request->get_param('pdc-aspect'))) {
            $items->filterAspect($request->get_param('pdc-aspect'));
        }

        if (! empty($request->get_param('pdc-usage'))) {
            $items->filterUsage($request->get_param('pdc-usage'));
        }

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
     * @return array|WP_Error
     */
    public function getItem(WP_REST_Request $request)
    {
        $id = (int) $request->get_param('id');
        $item = $this->buildQueryFromRequest($request);
        $item = $item->find($id);

        if (! $item) {
            return new WP_Error(
                'no_item_found',
                sprintf('Item with ID [%d] not found', $id),
                ['status' => 404]
            );
        }

        if ($this->needsAuthorization($item)) {
            return new WP_Error(
                'unauthorized_request',
                sprintf('Unauthorized request for item with ID [%d]', $id),
                ['status' => 401]
            );
        }

        return $this->validateShowOnAvailability($item, $request, $id);
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

        $id = (int) ($item['id'] ?? 0);

        if ($this->needsAuthorization($item)) {
            return new WP_Error(
                'unauthorized_request',
                sprintf('Unauthorized request for item with slug [%s]', $slug),
                ['status' => 401]
            );
        }

        return $this->validateShowOnAvailability($item, $request, $id, $slug);
    }

    /**
     * Validate if the item is available for the provided source, when applicable.
     *
     * @return array|WP_Error
     */
    protected function validateShowOnAvailability(array $item, WP_REST_Request $request, int $id, string $slug = '')
    {
        if (! $this->plugin->settings->useShowOn()) {
            return $item;
        }

        // If the item has no 'pdc-show-on' terms, it is available for all sources.
        if (! $this->postHasTermsConnected($id, 'pdc-show-on')) {
            return $item;
        }

        if (! $request->get_param('source')) {
            return new WP_Error(
                'invalid_source_param',
                'Invalid or missing source parameter',
                ['status' => 400]
            );
        }

        if (! $this->postHasTermField((string) $request->get_param('source'), $id, 'pdc-show-on')) {
            return new WP_Error(
                'item_not_available_for_source',
                1 > strlen($slug) ? sprintf('Item with ID [%d] is not available for the provided source', $id) : sprintf('Item with slug [%s] is not available for the provided source', $slug),
                ['status' => 403]
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

        if ($this->plugin->settings->useShowOn() && $request->get_param('source')) {
            $item->filterSource($request->get_param('source'));
        };

        $connectedField = $item->getGlobalField('connected');
        if ($request->get_param('connected_sort') && ! empty($connectedField)) {
            $connectedField['creator']->setSorting(
                $request->get_param('connected_sort'),
                strtoupper($request->get_param('connected_sort_direction')),
                $request->get_param('connected_sort_type')
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
