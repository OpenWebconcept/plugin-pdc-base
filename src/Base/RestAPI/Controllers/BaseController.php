<?php

/**
 * Controller which handels general quering, such as pagination.
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use OWC\PDC\Base\Foundation\Plugin;
use WP_Query;
use WP_REST_Request;

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
            'data' => $data
        ], [
            'pagination' => [
                'total_count'  => (int) $query->found_posts,
                'total_pages'  => $query->max_num_pages,
                'current_page' => $page,
                'limit'        => $query->get('posts_per_page')
            ]
        ]);
    }

    /**
     * Get the paginator query params for a given query.
     */
    protected function getPaginatorParams(WP_REST_Request $request, int $limit = 10): array
    {
        return [
            'posts_per_page' => $request->get_param('limit') ?: $limit,
            'paged'          => $request->get_param('page') ?: 0
        ];
    }

    /**
     * Return the post status to query on.
     */
    protected function getPostStatus(WP_REST_Request $request): array
    {
        $preview = filter_var($request->get_param('draft-preview'), FILTER_VALIDATE_BOOLEAN);

        return $preview ? ['publish', 'draft', 'future'] : ['publish'];
    }
}
