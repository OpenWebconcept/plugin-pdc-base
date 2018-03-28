<?php

namespace OWC_PDC_Base\Core\RestApi;


/**
 * Class RestPdcItemPostsController
 * @package OWC_PDC_Base\Core\RestApi
 *
 * Custom Posts_Controller class used to allow added filtering on active state
 * of PDC item via '_owc_pdc_active' metakey
 * also added p2p connected items to response
 *
 */
class RestPdcItemPostsController extends \WP_REST_Posts_Controller
{
	/**
	 * Retrieves a single post.
	 *
	 * @since  4.7.0
	 * @access public
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_item($request)
	{

		$pdcActive = (bool)get_post_meta($request['id'], '_owc_pdc_active', $single = true);
		if ( ! $pdcActive ) {
			$response = new \WP_Error('rest_post_invalid_id', 'PDC-item2 is not active.', ['status' => 404]);

			return $response;
		}

		$post = $this->get_post($request['id']);
		if ( is_wp_error($post) ) {
			return $post;
		}

		$data     = $this->prepare_item_for_response($post, $request);
		$response = rest_ensure_response($data);

		if ( is_post_type_viewable(get_post_type_object($post->post_type)) ) {
			$response->link_header('alternate', get_permalink($post->ID), ['type' => 'text/html']);
		}

		return $response;
	}

	/**
	 * Retrieves a collection of posts.
	 *
	 * @since  4.7.0
	 * @access public
	 *
	 * @param WP_REST_Request $request Full details about the request.
	 *
	 * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
	 */
	public function get_items($request)
	{

		// Ensure a search string is set in case the orderby is set to 'relevance'.
		if ( ! empty($request['orderby']) && 'relevance' === $request['orderby'] && empty($request['search']) ) {
			return new \WP_Error('rest_no_search_term_defined', __('You need to define a search term to order by relevance.'), ['status' => 400]);
		}

		// Ensure an include parameter is set in case the orderby is set to 'include'.
		if ( ! empty($request['orderby']) && 'include' === $request['orderby'] && empty($request['include']) ) {
			return new \WP_Error('rest_orderby_include_missing_include', sprintf(__('Missing parameter(s): %s'), 'include'), ['status' => 400]);
		}

		// Retrieve the list of registered collection query parameters.
		$registered = $this->get_collection_params();
		$args       = [];

		/*
		 * This array defines mappings between public API query parameters whose
		 * values are accepted as-passed, and their internal WP_Query parameter
		 * name equivalents (some are the same). Only values which are also
		 * present in $registered will be set.
		 */
		$parameterMappings = [
			'author'         => 'author__in',
			'author_exclude' => 'author__not_in',
			'exclude'        => 'post__not_in',
			'include'        => 'post__in',
			'menu_order'     => 'menu_order',
			'offset'         => 'offset',
			'order'          => 'order',
			'orderby'        => 'orderby',
			'page'           => 'paged',
			'parent'         => 'post_parent__in',
			'parent_exclude' => 'post_parent__not_in',
			'search'         => 's',
			'slug'           => 'post_name__in',
			'status'         => 'post_status',
		];

		/*
		 * For each known parameter which is both registered and present in the request,
		 * set the parameter's value on the query $args.
		 */
		foreach ( $parameterMappings as $apiParam => $wpParam ) {
			if ( isset($registered[ $apiparam ], $request[ $apiparam ]) ) {
				$args[ $wpParam ] = $request[ $apiparam ];
			}
		}

		// Check for & assign any parameters which require special handling or setting.
		$args['date_query'] = [];

		// Set before into date query. Date query must be specified as an array of an array.
		if ( isset($registered['before'], $request['before']) ) {
			$args['date_query'][0]['before'] = $request['before'];
		}

		// Set after into date query. Date query must be specified as an array of an array.
		if ( isset($registered['after'], $request['after']) ) {
			$args['date_query'][0]['after'] = $request['after'];
		}

		// Ensure our per_page parameter overrides any provided posts_per_page filter.
		if ( isset($registered['per_page']) ) {
			$args['posts_per_page'] = $request['per_page'];
		}

		if ( isset($registered['sticky'], $request['sticky']) ) {
			$stickyPosts = get_option('sticky_posts', []);
			if ( ! is_array($stickyPosts) ) {
				$stickyPosts = [];
			}
			if ( $request['sticky'] ) {
				/*
				 * As post__in will be used to only get sticky posts,
				 * we have to support the case where post__in was already
				 * specified.
				 */
				$args['post__in'] = $args['post__in'] ? array_intersect($stickyPosts, $args['post__in']) :
					$stickyPosts;

				/*
				 * If we intersected, but there are no post ids in common,
				 * WP_Query won't return "no posts" for post__in = array()
				 * so we have to fake it a bit.
				 */
				if ( ! $args['post__in'] ) {
					$args['post__in'] = [0];
				}
			} else {
				if ( $stickyPosts ) {
					/*
					 * As post___not_in will be used to only get posts that
					 * are not sticky, we have to support the case where post__not_in
					 * was already specified.
					 */
					$args['post__not_in'] = array_merge($args['post__not_in'], $stickyPosts);
				}
			}
		}

		// Force the post_type argument, since it's not a user input variable.
		$args['post_type'] = $this->post_type;

		/**
		 * Filters the query arguments for a request.
		 *
		 * Enables adding extra arguments or setting defaults for a post collection request.
		 *
		 * @since 4.7.0
		 *
		 * @link  https://developer.wordpress.org/reference/classes/wp_query/
		 *
		 * @param array           $args    Key value array of query var to query value.
		 * @param WP_REST_Request $request The request used.
		 */
		$args       = apply_filters("rest_{$this->post_type}_query", $args, $request);
		$queryArgs = $this->prepare_items_query($args, $request);

		$taxonomies = wp_list_filter(get_object_taxonomies($this->post_type, 'objects'), ['show_in_rest' => true]);

		foreach ( $taxonomies as $taxonomy ) {
			$base        = ! empty($taxonomy->rest_base) ? $taxonomy->rest_base : $taxonomy->name;
			$taxExclude = $base . '_exclude';

			if ( ! empty($request[ $base ]) ) {
				$queryArgs['tax_query'][] = [
					'taxonomy'         => $taxonomy->name,
					'field'            => 'term_id',
					'terms'            => $request[ $base ],
					'include_children' => false,
				];
			}

			if ( ! empty($request[ $taxExclude ]) ) {
				$queryArgs['tax_query'][] = [
					'taxonomy'         => $taxonomy->name,
					'field'            => 'term_id',
					'terms'            => $request[ $taxExclude ],
					'include_children' => false,
					'operator'         => 'NOT IN',
				];
			}
		}

		$postsQuery = new \WP_Query();

		$queryResult = $postsQuery->query($queryArgs);

		p2p_type('pdc-item_to_pdc-subcategory')->each_connected($queryResult);

		// Allow access to all password protected posts if the context is edit.
		if ( 'edit' === $request['context'] ) {
			add_filter('post_password_required', '__return_false');
		}

		$posts = [];

		foreach ( $queryResult as $post ) {
			if ( ! $this->check_read_permission($post) ) {
				continue;
			}

			$data    = $this->prepare_item_for_response($post, $request);
			$posts[] = $this->prepare_response_for_collection($data);
		}

		// Reset filter.
		if ( 'edit' === $request['context'] ) {
			remove_filter('post_password_required', '__return_false');
		}

		$page        = (int)$queryArgs['paged'];
		$totalPosts = $postsQuery->found_posts;

		if ( $totalPosts < 1 ) {
			// Out-of-bounds, run the query again without LIMIT for total count.
			unset($queryArgs['paged']);

			$countQuery = new \WP_Query();
			$countQuery->query($queryArgs);
			$totalPosts = $countQuery->found_posts;
		}

		$maxPages = ceil($totalPosts / (int)$postsQuery->query_vars['posts_per_page']);
		$response  = rest_ensure_response($posts);

		$response->header('X-WP-Total', (int)$totalPosts);
		$response->header('X-WP-TotalPages', (int)$maxPages);

		$requestParams = $request->get_query_params();
		$base           = add_query_arg($requestParams, rest_url(sprintf('%s/%s', $this->namespace, $this->rest_base)));

		if ( $page > 1 ) {
			$prevPage = $page - 1;

			if ( $prevPage > $maxPages ) {
				$prevPage = $maxPages;
			}

			$prevLink = add_query_arg('page', $prevPage, $base);
			$response->link_header('prev', $prevLink);
		}
		if ( $maxPages > $page ) {
			$nextPage = $page + 1;
			$nextLink = add_query_arg('page', $nextPage, $base);

			$response->link_header('next', $nextLink);
		}

		return $response;
	}
}