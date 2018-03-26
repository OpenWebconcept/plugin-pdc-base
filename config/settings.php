<?php

return [

	'base' => [
		'id'             => 'general',
		'title'          => 'PDC basis plugin instellingen',
		'settings_pages' => '_owc_pdc_base_settings',
		'fields'         => [
			'portal' => [
				'heading'       => [
					'type' => 'heading',
					'name' => 'Portal',
				],
				'portal_url'    => [
					'name' => 'Portal URL',
					'desc' => 'URL inclusief http(s)://',
					'id'   => 'setting_portal_url',
					'type' => 'text'
				],
				'pdc_item_slug' => [
					'name' => 'PDC item slug',
					'desc' => 'url van de PDC items in de portal, bv "onderwerp"',
					'id'   => 'setting_portal_pdc_item_slug',
					'type' => 'text'
				]
			]
		]
	]
];