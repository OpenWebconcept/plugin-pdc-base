<?php

/**
 * Controller which handels general quering, such as pagination.
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use WP_Query;
use WP_REST_Request;
use OWC\PDC\Base\Foundation\Plugin;

/**
 * Controller which handels general quering, such as pagination.
 */
abstract class BaseController
{
    /**
     * Instance of the plugin.
     */
    protected Plugin $plugin;

    /**
     * Construction, with dependency injection of the BasePlugin.
     *
     * @return void
     */
    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Merges a paginator, based on a WP_Query, inside a data arary.
     */
    protected function addPaginator(array $data, WP_Query $query): array
    {
        $page = $query->get('paged');
        $page = 0 == $page ? 1 : $page;

        return array_merge([
            'data' => $data,
        ], [
            'pagination' => [
                'total_count' => (int) $query->found_posts,
                'total_pages' => $query->max_num_pages,
                'current_page' => $page,
                'limit' => $query->get('posts_per_page'),
            ],
        ]);
    }

    /**
     * Get the paginator query params for a given query.
     */
    protected function getPaginatorParams(WP_REST_Request $request, int $limit = 10): array
    {
        return [
            'posts_per_page' => $request->get_param('limit') ?: $limit,
            'paged' => $request->get_param('page') ?: 0,
        ];
    }

    /**
     * Return the post status to query on.
     */
    protected function getPostStatus(WP_REST_Request $request): array
    {
        $preview = filter_var($request->get_param('draft-preview'), FILTER_VALIDATE_BOOLEAN);

        if (! \is_user_logged_in()) {
            $preview = false;
        }

        return $preview ? ['publish', 'draft', 'future'] : ['publish'];
    }

    /**
     * Check if the source parameter is valid.
     */
    protected function showOnParamIsValid(WP_REST_Request $request): bool
    {
        if (empty($request->get_param('source'))) {
            return false;
        }

        if (! is_numeric($request->get_param('source'))) {
            return false;
        }

        return true;
    }

    protected function targetAudienceParamIsValid(WP_REST_Request $request): bool
    {
        return $this->defaultTaxonomyParamIsValid($request, 'pdc-doelgroep');
    }

    protected function aspectParamIsValid(WP_REST_Request $request): bool
    {
        return $this->defaultTaxonomyParamIsValid($request, 'pdc-aspect');
    }

    protected function usageParamIsValid(WP_REST_Request $request): bool
    {
        return $this->defaultTaxonomyParamIsValid($request, 'pdc-usage');
    }

    protected function defaultTaxonomyParamIsValid(WP_REST_Request $request, string $param): bool
    {
        if (empty($request->get_param($param))) {
            return false;
        }

        if (! is_array($request->get_param($param)) && ! is_string($request->get_param($param))) {
            return false;
        }

        return true;
    }
}
