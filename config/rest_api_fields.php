<?php

$pdcItemModel = new \OWC_PDC_Base\Core\PostType\PostTypes\PdcItemModel($this);
$pdcSubcategoryModel = new \OWC_PDC_Base\Core\PostType\PostTypes\PdcSubcategoryModel($this);

return [

	'pdc-item'        => [
		'pdc_links'         =>
			[
				'get_callback'    => [$pdcItemModel, 'getLinks'],
				'update_callback' => null,
				'schema'          => null,
			],
		'pdc_downloads'     =>
			[
				'get_callback'    => [$pdcItemModel, 'getDownloads'],
				'update_callback' => null,
				'schema'          => null,
			],
		'pdc_forms'         =>
			[
				'get_callback'    => [$pdcItemModel, 'getForms'],
				'update_callback' => null,
				'schema'          => null,
			],
		'title_alternative' =>
			[
				'get_callback'    => [$pdcItemModel, 'getTitleAlternative'],
				'update_callback' => null,
				'schema'          => null,
			],
		'pdc_appointment'   =>
			[
				'get_callback'    => [$pdcItemModel, 'getAppointment'],
				'update_callback' => null,
				'schema'          => null,
			],
		'featured_image'    =>
			[
				'get_callback'    => [$pdcItemModel, 'getFeaturedImage'],
				'update_callback' => null,
				'schema'          => null,
			],
		'taxonomies'        =>
			[
				'get_callback'    => [ $pdcItemModel, 'getTaxonomies'],
				'update_callback' => null,
				'schema'          => null,
			],
		'connected'         =>
			[
				'get_callback'    => [ $pdcItemModel, 'getConnections'],
				'update_callback' => null,
				'schema'          => null,
			],
	],
	'pdc-subcategory' => [
		'has_report'      =>
			[
				'get_callback'    => [ $pdcSubcategoryModel, 'hasReport'],
				'update_callback' => null,
				'schema'          => null,
			],
		'has_appointment' =>
			[
				'get_callback'    => [ $pdcSubcategoryModel, 'hasAppointment'],
				'update_callback' => null,
				'schema'          => null,
			]
	]
];