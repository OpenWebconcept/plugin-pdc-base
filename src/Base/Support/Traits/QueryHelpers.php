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
            ],
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
                ],
            ],
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
                    'operator' => 'IN',
                ],
            ],
        ];
    }

    public function filterLanguageQuery(string $language): array
    {
        if ('nl' === $language) {
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
                    ],
                ],
            ];
        }

        return [
            'meta_query' => [
                [
                    'key' => '_owc_pdc-item-language',
                    'value' => $language,
                    'compare' => '=',
                ],
            ],
        ];
    }

    public function filterTargetAudienceQuery(array $audiences): array
    {
        return [
            'tax_query' => [
                [
                    'taxonomy' => 'pdc-doelgroep',
                    'terms' => array_map(function ($audience) {
                        return sanitize_text_field($audience);
                    }, $audiences),
                    'field' => 'slug',
                    'operator' => 'IN',
                ],
            ],
        ];
    }

    public function filterAspectQuery(array $aspects): array
    {
        return [
            'tax_query' => [
                [
                    'taxonomy' => 'pdc-aspect',
                    'terms' => array_map(function ($aspect) {
                        return sanitize_text_field($aspect);
                    }, $aspects),
                    'field' => 'slug',
                    'operator' => 'IN',
                ],
            ],
        ];
    }

    public function filterUsageQuery(array $usages): array
    {
        return [
            'tax_query' => [
                [
                    'taxonomy' => 'pdc-usage',
                    'terms' => array_map(function ($usage) {
                        return sanitize_text_field($usage);
                    }, $usages),
                    'field' => 'slug',
                    'operator' => 'IN',
                ],
            ],
        ];
    }
}
