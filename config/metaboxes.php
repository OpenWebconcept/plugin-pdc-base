<?php

return [

	'base' => [
		'id'         => 'pdc_metadata',
		'title'      => 'Gegevens',
		'post_types' => ['pdc-item'],
		'context'    => 'normal',
		'priority'   => 'high',
		// Auto save: true, false (default). Optional.
		'autosave'   => true,
		'fields'     => [
			'general'     => [
				'heading'  => [
					'type' => 'heading',
					'name' => 'Algemeen',
				],
				'title'    => [
					'name' => 'Alternatieve titel',
					'desc' => 'Gebruik deze mogelijkheid als de website een alternatieve titel gebruikt',
					'id'   => 'pdc_titel_alternatief',
					'type' => 'text',
				],
				'synonyms' => [
					'name' => 'Synoniemen',
					'desc' => 'Gebruik deze mogelijkheid om een komma gescheiden lijst van synoniemen of gerelateerde termen mee te geven',
					'id'   => 'pdc_tags',
					'type' => 'textarea',
				],
				'active'   => [
					'name'    => 'Actief',
					'desc'    => 'Is dit product op dit moment actief ja/nee',
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
				'heading2' => [
					'type' => 'heading',
					'name' => 'Afspraak maken',
				],
				'active'   => [
					'name'    => 'Actief',
					'desc'    => 'Is het nodig voor dit product een afspraak te maken ja/nee?',
					'id'      => 'pdc_afspraak_active',
					'type'    => 'radio',
					'options' => [
						'1' => 'Ja',
						'0' => 'Nee',
					],
					'std'     => '0',
				],
				'title'    => [
					'name' => 'Afspraak button titel',
					'desc' => 'Leeg laten als de standaard waarde gebruikt dient te worden',
					'id'   => 'pdc_afspraak_title',
					'type' => 'text',
				],
				'url'      => [
					'name' => 'Afspraak URL',
					'desc' => 'Gebruik dit veld als de afspraak knop met een specifieke URL ingericht moet worden. URL inclusief http(s)://',
					'id'   => 'pdc_afspraak_url',
					'type' => 'text',
				],
				'meta'     => [
					'name' => 'Afspraak meta',
					'desc' => 'Gebruik dit veld als de afspraak knop via een hier ingevoerde gegeven werkt (bv GravityForms id, of andere vorm van koppelings data, momenteel nog niet in gebruik)',
					'id'   => 'pdc_afspraak_meta',
					'type' => 'text',
				]
			],
			'links'       => [
				'heading' => [
					'type' => 'heading',
					'name' => 'Links',
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
							'name' => 'Link titel',
							'desc' => 'Wordt gebruikt om de link te tonen ipv de URL',
							'type' => 'text'
						],
						[
							'id'   => 'pdc_links_url',
							'name' => 'Link URL',
							'desc' => 'URL inclusief http(s)://',
							'type' => 'text'
						]
					]
				]
			],
			'downloads'   => [
				'heading'   => [
					'type' => 'heading',
					'name' => 'Downloads',
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
							'name' => 'Download titel',
							'desc' => 'Wordt gebruikt om de download te tonen ipv de URL',
							'type' => 'text',
						],
						[
							'id'   => 'pdc_downloads_url',
							'name' => 'Download URL',
							'desc' => 'URL inclusief http(s)://',
							'type' => 'text',
						]
					]
				]
			],
			'forms'       => [
				'heading' => [
					'type' => 'heading',
					'name' => 'Formulieren',
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
							'name' => 'Formulier titel',
							'desc' => 'Wordt gebruikt om het formulier te tonen ipv de URL',
							'type' => 'text',
						],
						[
							'id'   => 'pdc_forms_url',
							'name' => 'Formulier URL',
							'desc' => 'URL inclusief http(s)://',
							'type' => 'text',
						]
					]
				]
			],
			'government'  => [
				'heading'      => [
					'type' => 'heading',
					'name' => 'Overheid standaard',
				],
				'upl_name'     => [
					'name' => 'UPL naam',
					'desc' => 'Bijvoorbeeld: aanduiding naamgebruik',
					'id'   => 'pdc_upl_naam',
					'type' => 'text',
				],
				'upl_resource' => [
					'name' => 'UPL resource',
					'desc' => 'Bijvoorbeeld: http://standaarden.overheid.nl/owms/tersm/aanduiding_naamgebruik',
					'id'   => 'pdc_upl_resource',
					'type' => 'text',
				]
			],
			'other'       => [
				'heading' => [
					'type' => 'heading',
					'name' => 'Overig',
				],
				'other'   => [
					'name' => 'Vrij notitieveld (wetgeving, bevoegd gezag, uitvoerder, lokale regelgeving)',
					'desc' => '',
					'id'   => 'pdc_other_meta',
					'type' => 'textarea',
					'cols' => 20,
					'rows' => 5,
				]
			]
		]
	]
];