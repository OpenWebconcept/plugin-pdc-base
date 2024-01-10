<?php

namespace OWC\PDC\Base\Support\Traits;

trait QueryHelpers
{
    public function excludeInactiveItemsQuery(): array
    {
        return [
            'meta_query' => [
                [
                    'key' => '_owc_pdc_active',
                    'value' => '1',
                    'compare' => '=',
                ],
            ]
        ];
    }

    public function excludeInternalItemsQuery(): array
    {
        return [
            'tax_query' => [
                [
                    'relation' => 'OR',
                    [
                        'taxonomy' => 'pdc-type',
                        'field' => 'slug',
                        'terms' => 'external',
                    ],
                    [
                        'taxonomy' => 'pdc-type',
                        'field' => 'id',
                        'operator' => 'NOT EXISTS',
                    ],
                ]
            ]
        ];
    }

    public function filterShowOnTaxonomyQuery(int $termID): array
    {
        return [
            'tax_query' => [
                [
                    'taxonomy' => 'pdc-show-on',
                    'terms' => sanitize_text_field($termID),
                    'field' => 'slug',
                    'operator' => 'IN'
                ]
            ]
        ];
    }

	public function filterLanguageQuery(string $language): array
	{
		if ($language === 'nl') {
			return [
				'meta_query' => [
					[
						'relation' => 'OR',
						[
							'key' => '_owc_pdc-item-language',
							'value' => $language,
							'compare' => '=',
						],
						[
							'key' => '_owc_pdc-item-language',
							'value' => '',
							'compare' => '=',
						],
						[
							'key' => '_owc_pdc-item-language',
							'compare' => 'NOT EXISTS',
						],
					]
				]
			];
		}

		return [
			'meta_query' => [
				[
					'key' => '_owc_pdc-item-language',
					'value' => $language,
					'compare' => '=',
				],
			]
		];
	}
}
