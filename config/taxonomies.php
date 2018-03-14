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
			'singular' => 'Doelgroep',
			'plural'   => 'Doelgroepen',
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
			'singular' => 'Type',
			'plural'   => 'Types',
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
			'singular' => 'Kenmerk',
			'plural'   => 'Kenmerken',
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
			'singular' => 'Toepassing',
			'plural'   => 'Toepassingen',
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
			'singular' => 'Eigenaar',
			'plural'   => 'Eigenaren',
			'slug'     => 'pdc-owner'
		]
	]
];