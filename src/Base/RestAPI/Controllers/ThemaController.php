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
     * Get a list of all themas.
     */
    public function getThemas(WP_REST_Request $request): array
    {
        $orderBy = $request->get_param('orderby') ?? 'title';
        $order = $request->get_param('order') ?? 'ASC';

        $items = (new Thema())
            ->query(apply_filters('owc/pdc/rest-api/themas/query', $this->getPaginatorParams($request)))
			->query($this->getOrderClause($orderBy, $order))
			->query([
                'post_status' => $this->getPostStatus($request)
            ])
            ->hide(['items']);

        if ($this->plugin->settings->useShowOn() && $this->showOnParamIsValid($request)) {
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

        if ($this->plugin->settings->useShowOn() && $this->showOnParamIsValid($request)) {
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

        if ($this->plugin->settings->useShowOn() && $this->showOnParamIsValid($request)) {
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
