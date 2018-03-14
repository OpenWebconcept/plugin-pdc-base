<?php

namespace OWC_PDC_Base\Core\PostType;

use OWC_PDC_Base\Core\Plugin\ServiceProvider;

class PostTypeServiceProvider extends ServiceProvider
{

	public function register()
	{

		$this->plugin->loader->addAction('init', $this, 'registerPdcItemPostType');

		/**
		 * Registering the post types and taxonomies
		 */

		//				// Examples of registering post types: http://johnbillion.com/extended-cpts/
		//
		//				register_extended_post_type('pdc-category', [
		//
		//					# Add the post type to the site's main RSS feed:
		//					'show_in_feed' => false,
		//
		//					# Show all posts on the post type archive:
		//					'archive'      => [
		//						'nopaging' => true
		//					],
		//
		//					'supports' => ['title', 'editor', 'excerpt', 'revisions', 'thumbnail'],
		//
		//					'show_in_rest' => true,
		//					'rest_base'    => 'pdc-thema',
		//					'map_meta_cap' => true
		//
		//				], [
		//
		//					# Override the base names used for labels:
		//					'singular' => 'PDC thema',
		//					'plural'   => 'PDC themas',
		//					'slug'     => 'pdc-thema'
		//
		//				]);
		//
		//				register_extended_post_type('pdc-subcategory', [
		//
		//					# Add the post type to the site's main RSS feed:
		//					'show_in_feed' => false,
		//
		//					# Show all posts on the post type archive:
		//					'archive'      => [
		//						'nopaging' => true
		//					],
		//
		//					'supports' => ['title', 'editor', 'excerpt', 'revisions', 'thumbnail', 'page-attributes'],
		//
		//					'show_in_rest' => true,
		//					'hierarchical' => true,
		//					'rest_base'    => 'pdc-subthema',
		//					'map_meta_cap' => true
		//
		//				], [
		//
		//					# Override the base names used for labels:
		//					'singular' => 'PDC subthema',
		//					'plural'   => 'PDC subthemas',
		//					'slug'     => 'pdc-subthema'
		//
		//				]);
		//			}
		//
		//			add_action('init', 'register_extended_post_type', 3);
		//		}

	}

	/**
	 * register PDC-item custom posttype.
	 */
	public function registerPdcItemPostType()
	{

		if ( function_exists('register_extended_post_type') ) {

			// Examples of registering post types: http://johnbillion.com/extended-cpts/
			register_extended_post_type('pdc-item', [

				# Add the post type to the site's main RSS feed:
				'show_in_feed' => false,

				# Show all posts on the post type archive:
				'archive'      => [
					'nopaging' => true
				],

				'supports' => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields'],

				'show_in_rest'          => true,
				'rest_base'             => 'pdc-item',
				'rest_controller_class' => 'OWC_PDC_Base\\REST_PDC_Posts_Controller',
				'capability_type'       => 'pdc_post',
				'map_meta_cap'          => true

			], [

				# Override the base names used for labels:
				'singular' => 'PDC item',
				'plural'   => 'PDC items',
				'slug'     => 'pdc-item'

			]);

		}
	}
}