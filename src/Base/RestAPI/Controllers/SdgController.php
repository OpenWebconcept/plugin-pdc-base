<?php

/**
 * Controller which handles the (requested) pdc-item(s).
 */

namespace OWC\PDC\Base\RestAPI\Controllers;

use OWC\PDC\Base\Repositories\Item;
use OWC\PDC\Base\Support\Traits\CheckPluginActive;
use OWC\PDC\Base\UPL\Enrichment\Services\EnrichmentProductResolver;
use WP_Query;
use WP_REST_Request;

/**
 * Controller which handles the (requested) pdc-item(s).
 */
class SdgController extends BaseController
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
		$parameters = $request->get_params();
		$items      = (new Item())
			->query(apply_filters('owc/pdc/rest-api/sdg/query', $this->getPaginatorParams($request)))
			->query($parameters)
			->query(self::metaQuery($parameters));
		$items->all();

		$query = $items->getQuery();
		$posts = $query->posts;

		$enriched_posts = [];
		foreach( $posts as $post ) {
			$enriched_posts[] = (new EnrichmentProductResolver($post))->resolve()->jsonSerialize();
		}

		return $this->pagination( $query, $enriched_posts );
	}

	/**
	 * Add pagination and counter to the response.
	 *
	 * @param WP_Query  $query
	 * @param array     $results
	 *
	 * @return array
	 */
	public function pagination( $query, $results = [] ) : array {

		$page = $query->get('paged');
        $page = 0 == $page ? 1 : $page;

		return [
			'count'    => (int) $query->found_posts,
			'next'     => ( $query->max_num_pages > $page ? add_query_arg( 'page', ( $page + 1 ), get_rest_url( null, '/owc/pdc/v1/sdg/' ) ) : null ), 
			'previous' => ( $page > 1 ? add_query_arg( 'page', ( $page - 1 ), get_rest_url( null, '/owc/pdc/v1/sdg/' ) ) : null ),
			'results' => $results,
		];
	}

	public static function metaQuery(array $parametersFromRequest = []): array
	{
		$query = [
			'meta_query' => [
				[
					'key'     => '_owc_pdc_active',
					'value'   => '1',
					'compare' => '=',
				],
				[
					'key'     => '_owc_enrichment_send_data_to_sdg',
					'value'   => '1',
					'compare' => '=',
				],
				[
					'key'     => '_owc_enrichment_version',
					'compare' => 'EXISTS',
				]
			]
		];

		if(! empty($parametersFromRequest)){
			if ( isset( $parametersFromRequest['lang'] ) ) {
				$lang  = ! empty( $parametersFromRequest['lang'] ) ? esc_attr( $parametersFromRequest['lang'] ) : 'nl';
				$query = self::metaLanguageQuery( $lang, $query );
			}

			if ( isset( $parametersFromRequest['modified_before'] ) ) {
				$query['date_query'][] = array(
					'before'  => $parametersFromRequest['modified_before'],
					'column' => 'post_modified',
				);
			}

			if ( isset( $parametersFromRequest['modified_after'] ) ) {
				$query['date_query'][] = array(
					'after'  => $parametersFromRequest['modified_after'],
					'column' => 'post_modified',
				);
			}

			if ( isset( $parametersFromRequest['upnUri'] ) ) {
				$upl = esc_attr( $parametersFromRequest['upnUri'] );
				$query['meta_query'][] = [
					'key' => '_owc_pdc_upl_resource',
					'value' => $upl,
					'compare' => '=',
				];
			}

			if ( isset( $parametersFromRequest['doelgroep'] ) ) {
				$audience = esc_attr( $parametersFromRequest['doelgroep'] );
				$query['meta_query'][] = [
					'key' => '_owc_enrichment_audience',
					'value' => $audience,
					'compare' => '=',
				];
			}
		}

		return $query;
	}

	protected static function metaLanguageQuery(string $lang, array $query): array
	{
		if($lang === 'nl') {
			$query['meta_query'][] = [
				'relation' => 'OR',
				[
					'key'     => '_owc_pdc-item-language',
					'value'   => 'nl',
					'compare' => '=',
				],
				[
					'key'     => '_owc_pdc-item-language',
					'value'   => 'nl',
					'compare' => 'NOT EXISTS',
				]
			];

			return $query;
		}

		$query['meta_query'][] = [
			[
				'key'     => '_owc_pdc-item-language',
				'value'   => $lang,
				'compare' => '=',
			]
		];

		return $query;
	}

	public function arguments()
	{
		$args      = [];
		$args['modified_before'] = [
			'description' => esc_html__('Get all items modified before a specific date.', 'pdc-base'),
			'required'    => false,
			'type'        => 'string',
			'format'      => 'date-time',
		];
		$args['modified_after'] = [
			'description' => esc_html__('Get all items modified after a specific date.', 'pdc-base'),
			'required'    => false,
			'type'        => 'string',
			'format'      => 'date-time',
		];
		$args['lang'] = [
			'description' => esc_html__( 'Get items for a specific language.', 'pdc-base'),
			'required'    => false,
			'type'        => 'string'
		];
		$args['upnUri'] = [
			'description' => esc_html__('Get item by UPL.', 'pdc-base'),
			'required'    => false,
			'type'        => 'string',
		];
		$args['doelgroep'] = [
			'description' => esc_html__('Get items by audience.', 'pdc-base'),
			'required'    => false,
			'type'        => 'string',
		];

		return $args;
	}
}
