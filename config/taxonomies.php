<?php

return [

	/**
	 * Examples of registering taxonomies: http://johnbillion.com/extended-cpts/
	 */
	'pdc-doelgroep' => [
		'object_types' => ['pdc-item'],
		'args'         => [
			'meta_box' => 'simple',
			#			'capabilities' => [
			#				'manage_terms' => 'manage_pdc_categories',
			#				'edit_terms'   => 'manage_pdc_categories',
			#				'delete_terms' => 'manage_pdc_categories',
			#				'assign_terms' => 'edit_pdc_posts'
			#			]
		],
		'names'        => [

			# Override the base names used for labels:
			'singular' => _x('Audience', 'Taxonomy definition', 'pdc-base'),
			'plural'   => _x('Audiences', 'Taxonomy definition', 'pdc-base'),
			'slug'     => 'pdc-doelgroep'
		]
	],

	'pdc-type' => [
		'object_types' => ['pdc-item'],
		'args'         => [
			'meta_box'     => 'simple',
			'show_in_rest' => false,
			#			'capabilities' => [
			#				'manage_terms' => 'manage_pdc_categories',
			#				'edit_terms'   => 'manage_pdc_categories',
			#				'delete_terms' => 'manage_pdc_categories',
			#				'assign_terms' => 'edit_pdc_posts'
			#			]
		],
		'names'        => [

			# Override the base names used for labels:
			'singular' => _x('Type', 'Taxonomy definition', 'pdc-base'),
			'plural'   => _x('Types', 'Taxonomy definition', 'pdc-base'),
			'slug'     => 'pdc-type'
		]
	],

	'pdc-aspect' => [
		'object_types' => ['pdc-item'],
		'args'         => [
			'meta_box'     => 'simple',
			'show_in_rest' => false,
			#			'capabilities' => [
			#				'manage_terms' => 'manage_pdc_categories',
			#				'edit_terms'   => 'manage_pdc_categories',
			#				'delete_terms' => 'manage_pdc_categories',
			#				'assign_terms' => 'edit_pdc_posts'
			#			]
		],
		'names'        => [

			# Override the base names used for labels:
			'singular' => _x('Aspect', 'Taxonomy definition', 'pdc-base'),
			'plural'   => _x('Aspects', 'Taxonomy definition', 'pdc-base'),
			'slug'     => 'pdc-kenmerk'
		]
	],
	'pdc-usage'  => [
		'object_types' => ['pdc-item'],
		'args'         => [
			'meta_box'     => 'simple',
			'show_in_rest' => false,
			#			'capabilities' => [
			#				'manage_terms' => 'manage_pdc_categories',
			#				'edit_terms'   => 'manage_pdc_categories',
			#				'delete_terms' => 'manage_pdc_categories',
			#				'assign_terms' => 'edit_pdc_posts'
			#			]
		],
		'names'        => [

			# Override the base names used for labels:
			'singular' => _x('Usage', 'Taxonomy definition', 'pdc-base'),
			'plural'   => _x('Usages', 'Taxonomy definition', 'pdc-base'),
			'slug'     => 'pdc-toepassing'
		]
	],
	'pdc-owner'  => [
		'object_types' => ['pdc-item'],
		'args'         => [
			'meta_box'          => 'simple',
			'show_in_rest'      => false,
			#			'capabilities'      => [
			#				'manage_terms' => 'manage_pdc_categories',
			#				'edit_terms'   => 'manage_pdc_categories',
			#				'delete_terms' => 'manage_pdc_categories',
			#				'assign_terms' => 'edit_pdc_posts'
			#			],
			'show_admin_column' => true,
		],
		'names'        => [

			# Override the base names used for labels:
			'singular' => _x('Owner', 'Taxonomy definition', 'pdc-base'),
			'plural'   => _x('Owners', 'Taxonomy definition', 'pdc-base'),
			'slug'     => 'pdc-owner'
		]
	]
];