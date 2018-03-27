<?php

$pdcItemModel = new \OWC_PDC_Base\Core\PostType\PostTypes\PdcItemModel($this);

return [

	'pdc-item'        => [
		'pdc_links'         =>
			[
				'get_callback'    => ['\\OWC_PDC_Base\\Core\\PostType\\PostTypes\\PdcItemModel', 'get_links'],
				//'get_callback'    => [new \OWC_PDC_Base\Core\PostType\PostTypes\PdcItem, 'get_links'],
				'update_callback' => null,
				'schema'          => null,
			],
		'pdc_downloads'     =>
			[
				'get_callback'    => ['\\OWC_PDC_Base\\Core\\PostType\\PostTypes\\PdcItemModel', 'get_downloads'],
				'update_callback' => null,
				'schema'          => null,
			],
		'pdc_forms'         =>
			[
				'get_callback'    => ['\\OWC_PDC_Base\\Core\\PostType\\PostTypes\\PdcItemModel', 'get_forms'],
				'update_callback' => null,
				'schema'          => null,
			],
		'title_alternative' =>
			[
				'get_callback'    => ['\\OWC_PDC_Base\\Core\\PostType\\PostTypes\\PdcItemModel', 'get_title_alternative'],
				'update_callback' => null,
				'schema'          => null,
			],
		'pdc_appointment'   =>
			[
				'get_callback'    => ['\\OWC_PDC_Base\\Core\\PostType\\PostTypes\\PdcItemModel', 'get_appointment'],
				'update_callback' => null,
				'schema'          => null,
			],
		'featured_image'    =>
			[
				'get_callback'    => ['\\OWC_PDC_Base\\Core\\PostType\\PostTypes\\PdcItemModel', 'get_featured_image'],
				'update_callback' => null,
				'schema'          => null,
			],
		'taxonomies'        =>
			[
				'get_callback'    => [ $pdcItemModel, 'get_taxonomies'],
				'update_callback' => null,
				'schema'          => null,
			],
		'connected'         =>
			[
				'get_callback'    => [ $pdcItemModel, 'get_connections'],
				'update_callback' => null,
				'schema'          => null,
			],
	],
	'pdc-subcategory' => [
		'has_report'      =>
			[
				'get_callback'    => ['\\OWC_PDC_Base\\Core\\PostType\\PostTypes\\PdcSubcategory', 'has_report'],
				'update_callback' => null,
				'schema'          => null,
			],
		'has_appointment' =>
			[
				'get_callback'    => ['\\OWC_PDC_Base\\Core\\PostType\\PostTypes\\PdcSubcategory', 'has_appointment'],
				'update_callback' => null,
				'schema'          => null,
			]
	]
];