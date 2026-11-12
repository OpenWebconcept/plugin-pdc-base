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
     * Route arguments for paginated collections.
     *
     * @return array<string, array<string, mixed>>
     */
    public function paginatorArguments(): array
    {
        return [
            'limit' => [
                'description' => esc_html__('Maximum number of items per page, -1 for all.', 'pdc-base'),
                'type' => 'integer',
                'minimum' => -1,
                'default' => 10,
            ],
            'page' => [
                'description' => esc_html__('Page of the collection.', 'pdc-base'),
                'type' => 'integer',
                'minimum' => 1,
                'default' => 1,
            ],
        ];
    }

    /** @return array<string, mixed> */
    protected function sourceArgument(): array
    {
        return [
            'description' => esc_html__('Blog ID of the site the content is shown on.', 'pdc-base'),
            'type' => 'integer',
        ];
    }

    /** @return array<string, mixed> */
    protected function draftPreviewArgument(): array
    {
        return [
            'description' => esc_html__('Include drafts and scheduled posts for logged-in users.', 'pdc-base'),
            'type' => 'boolean',
        ];
    }

    /** @return array<string, mixed> */
    protected function languageArgument(): array
    {
        return [
            'description' => esc_html__('Language code to filter on.', 'pdc-base'),
            'type' => 'string',
        ];
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

    protected function postHasTermField(string $param, int $postId, string $taxonomy, string $field = 'slug'): bool
    {
        $terms = get_the_terms($postId, $taxonomy);

        if (! is_array($terms) || [] === $terms) {
            return false;
        }

        $sanitizedParam = sanitize_text_field($param);
        $pluckedValues = wp_list_pluck($terms, $field);

        return in_array($sanitizedParam, $pluckedValues, true);
    }

    protected function postHasTermsConnected(int $postId, string $taxonomy): bool
    {
        $terms = get_the_terms($postId, $taxonomy);

        if (! is_array($terms) || [] === $terms) {
            return false;
        }

        return true;
    }
}
