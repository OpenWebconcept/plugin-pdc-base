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
			'singular' => _x('Doelgroep', 'Taxonomie definitie', 'pdc-base'),
			'plural'   => _x('Doelgroepen', 'Taxonomie definitie', 'pdc-base'),
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
			'singular' => _x('Type', 'Taxonomie definitie', 'pdc-base'),
			'plural'   => _x('Types', 'Taxonomie definitie', 'pdc-base'),
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
			'singular' => _x('Kenmerk', 'Taxonomie definitie', 'pdc-base'),
			'plural'   => _x('Kenmerken', 'Taxonomie definitie', 'pdc-base'),
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
			'singular' => _x('Toepassing', 'Taxonomie definitie', 'pdc-base'),
			'plural'   => _x('Toepassingen', 'Taxonomie definitie', 'pdc-base'),
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
			'singular' => _x('Eigenaar', 'Taxonomie definitie', 'pdc-base'),
			'plural'   => _x('Eigenaren', 'Taxonomie definitie', 'pdc-base'),
			'slug'     => 'pdc-owner'
		]
	]
];