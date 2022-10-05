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
                [
                    'type' => 'heading',
                    'name' => __('General', 'pdc-base'),
                ],
                [
                    'name' => __('Send to SDG', 'pdc-base'),
                    'id'   => 'enrichment_send_data_to_sdg',
                    'type' => 'checkbox',
                    'desc' => __('All data of this product will be send to the SDG when product is saved.', 'pdc-base')
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
                        '1' => 'Product aanwezig/beschikbaar', // Vertalen
                        '0' => 'Product niet beschikbaar', // Vertalen
                        'null' => 'Niet gespecificeerd' // Vertalen
                    ],
                ]
            ],
            'enrichment-language' => [
                'group' => [
                    'id'         => 'enrichment_language',
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
                        ],
                        [
                            'name' => __('Proof', 'pdc-base'),
                            'id'   => 'enrichment_proof',
                            'type' => 'text',
                            'desc' => __('Proof to deliver.', 'pdc-base')
                        ],
                        [
                            'name' => __('Requirements', 'pdc-base'),
                            'id'   => 'enrichment_requirements',
                            'type' => 'text',
                            'desc' => __('Requirements to fulfil on.', 'pdc-base')
                        ],
                        [
                            'name' => __('Object and appeal', 'pdc-base'),
                            'id'   => 'enrichment_object_and_appeal',
                            'type' => 'text',
                            'desc' => __('How to object and appeal against.', 'pdc-base')
                        ],
                        [
                            'name' => __('Payment methods', 'pdc-base'),
                            'id'   => 'enrichment_payment_methods',
                            'type' => 'text',
                            'desc' => __('Is there an payment required?', 'pdc-base')
                        ],
                        [
                            'name' => __('Deadline', 'pdc-base'),
                            'id'   => 'enrichment_deadline',
                            'type' => 'text',
                            'desc' => __('When is the deadline?', 'pdc-base')
                        ],
                        [
                            'name' => __('Action when to reaction', 'pdc-base'),
                            'id'   => 'enrichment_action_when_no_reaction',
                            'type' => 'text',
                            'desc' => __('What to do when a reaction remains.', 'pdc-base')
                        ],
                        [
                            'name' => __('Product present', 'pdc-base'),
                            'id'   => 'enrichment_product_present_explanation',
                            'type' => 'text',
                            'desc' => __('Need to discuss the value of this desc.', 'pdc-base')
                        ],
                        [
                            'name' => __('Product belongs to', 'pdc-base'),
                            'id'   => 'enrichment_product_belongs_to_explanation',
                            'type' => 'text',
                            'desc' => __('Need to discuss the value of this desc.', 'pdc-base')
                        ],
                    ]
                ]
            ]
        ]
    ]
];
