<?php

use OWC\PDC\Base\UPL\Enrichment\Models\Doelgroep;

return [
    'enrichment' => [
        'id'         => 'pdc_enrichment',
        'title'      => __('SDG content enrichment', 'pdc-base'),
        'post_types' => ['pdc-item'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     => [
            'enrichment-data' => [
                'heading' => [
                    'type' => 'heading',
                    'name' => __('General', 'pdc-base'),
                ],
                [
                    'name' => __('Last modified', 'pdc-base'),
                    'id'   => 'enrichment_version_date',
                    'type' => 'date',
                    'desc' => __('This field shows the date of the current enrichment version.', 'pdc-base'),
                    'readonly' => true,
                ],
                [
                    'name' => __('Audience', 'pdc-base'),
                    'id'   => 'enrichment_audience',
                    'desc' => __('', 'pdc-base'),
                    'type' => 'select',
                    'options'   => [
                        Doelgroep::TYPE_CITIZEN => Doelgroep::LABEL_CITIZEN,
                        Doelgroep::TYPE_COMPANY => Doelgroep::LABEL_COMPANY,
                    ],
                ],
                [
                    'name' => __('Product aanwezig', 'pdc-base'),
                    'id'   => 'enrichment_product_present',
                    'desc' => __('', 'pdc-base'),
                    'type' => 'select',
                    'options'   => [
                        '1' => 'Product aanwezig/beschikbaar',
                        '0' => 'Product niet beschikbaar'
                    ],
                ]
            ],
            'enrichment-language' => [
                'group' => [
                    'id'         => 'enrichment-language',
                    'type'       => 'group',
                    'clone'      => false,
                    'fields'     => [
                        [
                            'name' => __('Language', 'pdc-base'),
                            'id'   => 'enrichment_language',
                            'type' => 'text',
                            'desc' => __('The language of the enrichment.', 'pdc-base'),
                            'readonly' => true
                        ],
                        [
                            'name' => __('National text', 'pdc-base'),
                            'id'   => 'enrichment_national_text',
                            'type' => 'textarea',
                            'desc' => __('The national text is displayed above the own SDG text on the national portals. This text is served for informational purposes only no further action required.', 'pdc-base'),
                            'readonly' => true
                        ],
                        [
                            'name' => __('Example text VNG editorial', 'pdc-base'),
                            'id'   => 'enrichment_sdg_example_text',
                            'desc' => __("Example text by the VNG which is used for one's own SDG text. Will be updated regularly by the VNG editorial. Check the checkbox down below to add a custom SDG text.", 'pdc-base'),
                            'type' => 'textarea',
                            'readonly' => true
                        ],
                        'heading' => [
                            'type' => 'heading',
                            'name' => __('Edits', 'pdc-base')
                        ],
                        [
                            'name' => __('SDG input facility', 'pdc-base'),
                            'id'   => 'enrichment_sdg_example_text_to_insert_api',
                            'type' => 'checkbox',
                            'desc' => __('Use custom SDG text on national portals.', 'pdc-base')
                        ],
                        [
                            'name' => __('Own SDG text', 'pdc-base'),
                            'id'   => 'enrichment_sdg_custom_text',
                            'desc' => __('Custom SDG text for displaying on national portals.', 'pdc-base'),
                            'type' => 'wysiwyg'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
