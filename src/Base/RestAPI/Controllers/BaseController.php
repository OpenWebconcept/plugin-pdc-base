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
     *
     * @var Plugin
     */
    protected $plugin;

    /**
     * Construction, with dependency injection of the BasePlugin.
     *
     * @param Plugin $plugin
     *
     * @return void
     */
    public function __construct(Plugin $plugin)
    {
        $this->plugin = $plugin;
    }

    /**
     * Get an individual post item.
     *
     * @return array
     */
    public function arguments()
    {
        $args             = [];
        $args['s']        = [
            'description' => esc_html__('The search term.', 'pdc-base'),
            'required'    => true,
            'type'        => 'string',
        ];
        $args['per-page'] = [
            'description' => esc_html__('The limit.', 'pdc-base'),
            'required'    => false,
            'default'     => 10,
            'type'        => 'int',
        ];
        $args['page']     = [
            'description' => esc_html__('Pagination', 'pdc-base'),
            'required'    => false,
            'default'     => 1,
            'type'        => 'int',
        ];

        return $args;
    }

    /**
     * Merges a paginator, based on a WP_Query, inside a data arary.
     *
     * @param array    $data
     * @param WP_Query $query
     *
     * @return array
     */
    protected function addPaginator(array $data, WP_Query $query): array
    {
        $page = $query->get('paged');
        $page = $page == 0 ? 1 : $page;

        return array_merge([
            'data' => $data,
        ], [
            'pagination' => [
                'total_count'  => (int)$query->found_posts,
                'total_pages'  => $query->max_num_pages,
                'current_page' => $page,
                'limit'        => $query->get('posts_per_page'),
            ],
        ]);
    }

    /**
     * Get the paginator query params for a given query.
     *
     * @param WP_REST_Request $request
     * @param int             $limit
     *
     * @return array
     */
    protected function getPaginatorParams(WP_REST_Request $request, int $limit = 10)
    {
        return [
            'posts_per_page' => $request->get_param('limit') ?: $limit,
            'paged'          => $request->get_param('page') ?: 0,
        ];
    }

    /**
     * Get the search query when available, otherwise return all the items
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    protected function getSearchArray(WP_REST_Request $request)
    {
        $orderBy = $request->get_param('orderby') ?? 'title';
        $order   = $request->get_param('order') ?? 'ASC';

        if (empty($request->get_param('s'))) {
            return [
                'order'   => $order,
                'orderby' => $orderBy,
            ];
        }

        return [
            's'             => $request->get_param('s'),
            'ep_integrate'  => true,
            'search_fields' => [
                'post_title^2',
                'post_content',
                'post_content_filtered',
                'post_excerpt',

                'meta._owc_meta_data.value',
                'meta._owc_pdc_links_group.value',
                'meta._owc_pdc_downloads_group.value',
                'meta._owc_pdc_forms_group.value',
                'meta._owc_pdc_titel_alternatief.value',
                'meta._owc_pdc_afspraak_url.value',
                'meta._owc_pdc_afspraak_title.value',
                'meta._owc_pdc_afspraak_meta.value',
                'meta._owc_pdc_tags.value',
                'meta._owc_pdc_faq_group.value',
                'meta._owc_pdc_other_meta.value',
                'meta.faq_group.value',
            ],
            'order'         => $order,
            'orderby'       => $orderBy,
        ];
    }
}
