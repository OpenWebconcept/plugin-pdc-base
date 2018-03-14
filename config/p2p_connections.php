<?php

return [

	'posttypes_info' => [
		'pdc-item'        =>
			[
				'id'    => 'pdc-item',
				'title' => __('PDC item')
			],
		'pdc-category'    =>
			[
				'id'    => 'pdc-category',
				'title' => 'PDC thema'
			],
		'pdc-subcategory' =>
			[
				'id'    => 'pdc-subcategory',
				'title' => 'PDC subthema'
			],
		'pdc-owner'       =>
			[
				'id'    => 'pdc-owner',
				'title' => 'PDC eigenaar'
			]
	],
	'connections'    => [
		[
			'from'       => 'pdc-item',
			'to'         => 'pdc-category',
			'reciprocal' => true
		],
		[
			'from'       => 'pdc-item',
			'to'         => 'pdc-subcategory',
			'reciprocal' => true
		],
		[
			'from'       => 'pdc-category',
			'to'         => 'pdc-subcategory',
			'reciprocal' => true
		],
		[
			'from'       => 'pdc-item',
			'to'         => 'pdc-item',
			'reciprocal' => false
		],
	]

];