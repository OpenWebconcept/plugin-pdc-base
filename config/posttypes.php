<?php

return [

	/**
	 * Examples of registering post types: http://johnbillion.com/extended-cpts/
	 */
	'pdc-item'        => [
		'args'  => [

			# Add the post type to the site's main RSS feed:
			'show_in_feed'          => false,

			# Show all posts on the post type archive:
			'archive'               => [
				'nopaging' => true
			],
			'supports'              => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
			'show_in_rest'          => true,
			'rest_base'             => 'pdc-item',
			'rest_controller_class' => 'OWC_PDC_Base\\REST_PDC_Posts_Controller',
		],
		'names' => [

			# Override the base names used for labels:
			'singular' => 'PDC item',
			'plural'   => 'PDC items',
			'slug'     => 'pdc-item'
		]
	],
	'pdc-category'    => [
		'args'  => [

			# Add the post type to the site's main RSS feed:
			'show_in_feed' => false,

			# Show all posts on the post type archive:
			'archive'      => [
				'nopaging' => true
			],
			'supports'     => ['title', 'editor', 'excerpt', 'revisions', 'thumbnail'],
			'show_in_rest' => true,
			'rest_base'    => 'pdc-thema',
		],
		'names' => [

			# Override the base names used for labels:
			'singular' => 'PDC thema',
			'plural'   => 'PDC themas',
			'slug'     => 'pdc-thema'
		]
	],
	'pdc-subcategory' => [
		'args'  => [
			# Add the post type to the site's main RSS feed:
			'show_in_feed' => false,

			# Show all posts on the post type archive:
			'archive'      => [
				'nopaging' => true
			],
			'supports' => ['title', 'editor', 'excerpt', 'revisions', 'thumbnail', 'page-attributes'],
			'show_in_rest' => true,
			'hierarchical' => true,
			'rest_base'    => 'pdc-subthema',
		],
		'names' => [

			# Override the base names used for labels:
			'singular' => 'PDC subthema',
			'plural'   => 'PDC subthemas',
			'slug'     => 'pdc-subthema'

		]
	]
];