<?php

namespace OWC\PDC\Base\RestAPI\Controllers;

use OWC\PDC\Base\Repositories\Item;
use OWC\PDC\Base\UPL\Enrichment\Services\KissEnrichmentProductResolver;
use WP_Query;
use WP_REST_Request;

class SdgKissController extends SdgController
{
    /**
     * Get a list of all items.
     */
    public function getItems(WP_REST_Request $request): array
    {
        $parameters = $request->get_params();
        $items      = (new Item())
            ->query(apply_filters('owc/pdc/rest-api/sdg-kiss/query', $this->getPaginatorParams($request)))
            ->query($parameters)
            ->query(self::metaQuery($parameters));
        $items->all();

        $query = $items->getQuery();
        $posts = $query->posts;

        $enrichedPosts = [];
        foreach ($posts as $post) {
            $enrichedPosts[] = (new KissEnrichmentProductResolver($post))->resolve()->jsonSerialize();
        }

        return $this->pagination($query, $enrichedPosts);
    }

    /**
     * Add pagination and counter to the response.
     *
     * @param WP_Query  $query
     * @param array     $results
     *
     * @return array
     */
    public function pagination($query, $results = []) : array
    {
        $page = $query->get('paged');
        $page = 0 == $page ? 1 : $page;

        return [
            'count' => (int) $query->found_posts,
            'next' => ($query->max_num_pages > $page ? add_query_arg('page', ($page + 1), get_rest_url(null, '/owc/pdc/v1/sdg-kiss/')) : null),
            'previous' => ($page > 1 ? add_query_arg('page', ($page - 1), get_rest_url(null, '/owc/pdc/v1/sdg-kiss/')) : null),
            'results' => $results,
        ];
    }
}
