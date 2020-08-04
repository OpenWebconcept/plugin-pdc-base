<?php

/**
 * Controller which handles the (requested) pdc-item(s).
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use OWC\PDC\Base\Repositories\Item;
use WP_REST_Request;

/**
 * Controller which handles the searching of pdc-item(s).
 */
class SearchController extends ItemController
{
    /**
     * Get a list of all items.
     *
     * @param WP_REST_Request $request
     *
     * @return array
     */
    public function search(WP_REST_Request $request)
    {
        $items = (new Item())
            ->hide(['connected'])
            ->query(apply_filters('owc/pdc/rest-api/items/query', $this->getPaginatorParams($request)))
            ->query([
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
                ]
            ]);

        $data  = $items->all();
        $query = $items->getQuery();

        return $this->addPaginator($data, $query);
    }

    /**
     * Get an individual post item.
     *
     * @return array
     */
    public function arguments()
    {
        $args      = [];
        $args['s'] = [
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
        $args['page'] = [
            'description' => esc_html__('Pagination', 'pdc-base'),
            'required'    => false,
            'default'     => 1,
            'type'        => 'int',
        ];

        return $args;
    }
}
