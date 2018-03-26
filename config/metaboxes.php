<?php

return [

	'base' => [
		'id'         => 'pdc_metadata',
		'title'      => __('Gegevens', 'pdc-base'),
		'post_types' => ['pdc-item'],
		'context'    => 'normal',
		'priority'   => 'high',
		// Auto save: true, false (default). Optional.
		'autosave'   => true,
		'fields'     => [
			'general'     => [
				'heading'  => [
					'type' => 'heading',
					'name' => __('Algemeen', 'pdc-base'),
				],
				'title'    => [
					'name' => __('Alternatieve titel', 'pdc-base'),
					'desc' => __('Gebruik deze mogelijkheid als de website een alternatieve titel gebruikt', 'pdc-base'),
					'id'   => 'pdc_titel_alternatief',
					'type' => 'text',
				],
				'synonyms' => [
					'name' => __('Synoniemen', 'pdc-base'),
					'desc' => __('Gebruik deze mogelijkheid om een komma gescheiden lijst van synoniemen of gerelateerde termen mee te geven', 'pdc-base'),
					'id'   => 'pdc_tags',
					'type' => 'textarea',
				],
				'active'   => [
					'name'    => __('Actief', 'pdc-base'),
					'desc'    => __('Is dit product op dit moment actief ja/nee', 'pdc-base'),
					'id'      => 'pdc_active',
					'type'    => 'radio',
					'options' => [
						'1' => 'Ja',
						'0' => 'Nee',
					],
					'std'     => '1',
				]
			],
			'appointment' => [
				'heading' => [
					'type' => 'heading',
					'name' => __('Afspraak maken', 'pdc-base'),
				],
				'active'   => [
					'name'    => __('Actief', 'pdc-base'),
					'desc'    => __('Is het nodig voor dit product een afspraak te maken ja/nee?', 'pdc-base'),
					'id'      => 'pdc_afspraak_active',
					'type'    => 'radio',
					'options' => [
						'1' => 'Ja',
						'0' => 'Nee',
					],
					'std'     => '0',
				],
				'title'    => [
					'name' => __('Afspraak button titel', 'pdc-base'),
					'desc' => __('Leeg laten als de standaard waarde gebruikt dient te worden', 'pdc-base'),
					'id'   => 'pdc_afspraak_title',
					'type' => 'text',
				],
				'url'      => [
					'name' => __('Afspraak URL', 'pdc-base'),
					'desc' => __('Gebruik dit veld als de afspraak knop met een specifieke URL ingericht moet worden. URL inclusief http(s)://', 'pdc-base'),
					'id'   => 'pdc_afspraak_url',
					'type' => 'text',
				],
				'meta'     => [
					'name' => __('Afspraak meta', 'pdc-base'),
					'desc' => __('Gebruik dit veld als de afspraak knop via een hier ingevoerde gegeven werkt (bv GravityForms id, of andere vorm van koppelings data, momenteel nog niet in gebruik)', 'pdc-base'),
					'id'   => 'pdc_afspraak_meta',
					'type' => 'text',
				]
			],
			'links'       => [
				'heading' => [
					'type' => 'heading',
					'name' => __('Links', 'pdc-base'),
				],
				'links'   => [
					'id'         => 'pdc_links_group',
					'type'       => 'group',
					'clone'      => true,
					'sort_clone' => true,
					// List of sub-fields
					'fields'     => [
						[
							'id'   => 'pdc_links_title',
							'name' => __('Link titel', 'pdc-base'),
							'desc' => __('Wordt gebruikt om de link te tonen ipv de URL', 'pdc-base'),
							'type' => 'text'
						],
						[
							'id'   => 'pdc_links_url',
							'name' => __('Link URL', 'pdc-base'),
							'desc' => __('URL inclusief http(s)://', 'pdc-base'),
							'type' => 'text'
						]
					]
				]
			],
			'downloads'   => [
				'heading'   => [
					'type' => 'heading',
					'name' => __('Downloads', 'pdc-base'),
				],
				'downloads' => [
					'id'         => 'pdc_downloads_group',
					'type'       => 'group',
					'clone'      => true,
					'sort_clone' => true,
					// List of sub-fields
					'fields'     => [
						[
							'id'   => 'pdc_downloads_title',
							'name' => __('Download titel', 'pdc-base'),
							'desc' => __('Wordt gebruikt om de download te tonen ipv de URL', 'pdc-base'),
							'type' => 'text',
						],
						[
							'id'   => 'pdc_downloads_url',
							'name' => __('Download URL', 'pdc-base'),
							'desc' => __('URL inclusief http(s)://', 'pdc-base'),
							'type' => 'text',
						]
					]
				]
			],
			'forms'       => [
				'heading' => [
					'type' => 'heading',
					'name' => __('Formulieren', 'pdc-base'),
				],
				'forms'   => [
					'id'         => 'pdc_forms_group',
					'type'       => 'group',
					'clone'      => true,
					'sort_clone' => true,
					// List of sub-fields
					'fields'     => [
						[
							'id'   => 'pdc_forms_title',
							'name' => __('Formulier titel', 'pdc-base'),
							'desc' => __('Wordt gebruikt om het formulier te tonen ipv de URL', 'pdc-base'),
							'type' => 'text',
						],
						[
							'id'   => 'pdc_forms_url',
							'name' => __('Formulier URL', 'pdc-base'),
							'desc' => __('URL inclusief http(s)://', 'pdc-base'),
							'type' => 'text',
						]
					]
				]
			],
			'government'  => [
				'heading'      => [
					'type' => 'heading',
					'name' => __('Overheid standaard', 'pdc-base'),
				],
				'upl_name'     => [
					'name' => __('UPL naam', 'pdc-base'),
					'desc' => __('Bijvoorbeeld: aanduiding naamgebruik', 'pdc-base'),
					'id'   => 'pdc_upl_naam',
					'type' => 'text',
				],
				'upl_resource' => [
					'name' => __('UPL resource', 'pdc-base'),
					'desc' => __('Bijvoorbeeld: http://standaarden.overheid.nl/owms/tersm/aanduiding_naamgebruik', 'pdc-base'),
					'id'   => 'pdc_upl_resource',
					'type' => 'text',
				]
			],
			'other'       => [
				'heading' => [
					'type' => 'heading',
					'name' => __('Overig', 'pdc-base'),
				],
				'other'   => [
					'name' => __('Vrij notitieveld', 'pdc-base'),
					'desc' => __('(wetgeving, bevoegd gezag, uitvoerder, lokale regelgeving)', 'pdc-base'),
					'id'   => 'pdc_other_meta',
					'type' => 'textarea',
					'cols' => 20,
					'rows' => 5,
				]
			]
		]
	]
];