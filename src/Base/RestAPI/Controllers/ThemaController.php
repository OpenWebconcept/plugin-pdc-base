<?php

/**
 * Controller which handles the (requested) thema(s).
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use WP_Error;
use WP_REST_Request;
use OWC\PDC\Base\Repositories\Thema;

/**
 * Controller which handles the (requested) thema(s).
 */
class ThemaController extends BaseController
{
    /**
     * Route arguments for the themas collection.
     *
     * @return array<string, array<string, mixed>>
     */
    public function collectionArguments(): array
    {
        return array_merge($this->paginatorArguments(), [
            'orderby' => [
                'description' => esc_html__('Field to order the themas by.', 'pdc-base'),
                'type' => 'string',
                'default' => 'title',
            ],
            'order' => [
                'description' => esc_html__('Order direction, ASC or DESC.', 'pdc-base'),
                'type' => 'string',
                'default' => 'ASC',
            ],
            'draft-preview' => $this->draftPreviewArgument(),
            'source' => $this->sourceArgument(),
            'language' => $this->languageArgument(),
        ]);
    }

    /**
     * Route arguments for a single thema.
     *
     * @return array<string, array<string, mixed>>
     */
    public function singleArguments(): array
    {
        return [
            'draft-preview' => $this->draftPreviewArgument(),
            'source' => $this->sourceArgument(),
            'language' => $this->languageArgument(),
        ];
    }

    /**
     * Get a list of all themas.
     */
    public function getThemas(WP_REST_Request $request): array
    {
        $orderBy = $request->get_param('orderby') ?? 'title';
        $order = $request->get_param('order') ?? 'ASC';

        $items = (new Thema())
            ->query(apply_filters('owc/pdc/rest-api/themas/query', $this->getPaginatorParams($request)))
            ->query([
                'order' => $order,
                'orderby' => $orderBy,
                'post_status' => $this->getPostStatus($request)
            ])
            ->hide(['items']);

        if ($this->plugin->settings->useShowOn() && $request->get_param('source')) {
            $items->filterSource($request->get_param('source'));
        }

        if ($language = $request->get_param('language')) {
            $items->filterLanguage((string) $language);
        }

        $data = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }

    /**
     * Get an individual thema.
     *
     * @return array|WP_Error
     */
    public function getThema(WP_REST_Request $request)
    {
        $id = (int) $request->get_param('id');

        $thema = (new Thema())
            ->query(apply_filters('owc/pdc/rest-api/themas/query/single', []))
            ->query(['post_status' => $this->getPostStatus($request)]);

        if ($this->plugin->settings->useShowOn() && $request->get_param('source')) {
            $thema->filterSource($request->get_param('source'));
        }

        if ($language = $request->get_param('language')) {
            $thema->filterLanguage((string) $language);
        }

        $thema = $thema->find($id);

        if (! $thema) {
            return new WP_Error('no_item_found', sprintf('Thema with ID [%d] not found', $id), [
                'status' => 404,
            ]);
        }

        return $thema;
    }

    /**
     * Get an individual theme by slug.
     *
     * @return array|WP_Error
     */
    public function getThemeBySlug(WP_REST_Request $request)
    {
        $slug = $request->get_param('slug');

        $theme = (new Thema())
            ->query(apply_filters('owc/pdc/rest-api/themas/query/single', []))
            ->query(['post_status' => $this->getPostStatus($request)]);

        if ($this->plugin->settings->useShowOn() && $request->get_param('source')) {
            $theme->filterSource($request->get_param('source'));
        }

        if ($language = $request->get_param('language')) {
            $theme->filterLanguage((string) $language);
        }

        $theme = $theme->findBySlug($slug);

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
