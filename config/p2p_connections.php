<?php

return [

	'posttypes_info' => [
		'pdc-item'        =>
			[
				'id'    => 'pdc-item',
				'title' => _x('PDC item', 'P2P titel', 'pdc-base' )
			],
		'pdc-category'    =>
			[
				'id'    => 'pdc-category',
				'title' => _x('PDC thema', 'P2P titel', 'pdc-base')
			],
		'pdc-subcategory' =>
			[
				'id'    => 'pdc-subcategory',
				'title' => _x('PDC subthema', 'P2P titel', 'pdc-base')
			],
		'pdc-owner'       =>
			[
				'id'    => 'pdc-owner',
				'title' => _x('PDC eigenaar', 'P2P titel', 'pdc-base')
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