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
                    'desc' => __('All data of this product will be send to the SDG after saving this product.', 'pdc-base')
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
                    'type' => 'select',
                    'options'   => [
                        Doelgroep::TYPE_CITIZEN => Doelgroep::LABEL_CITIZEN,
                        Doelgroep::TYPE_COMPANY => Doelgroep::LABEL_COMPANY,
                    ],
                ],
                [
                    'name' => __('Product present', 'pdc-base'),
                    'id'   => 'enrichment_product_present',
                    'type' => 'select',
                    'options'   => [
                        '1' => __('Product present/available', 'pdc-base'),
                        '0' => __('Product unavailable', 'pdc-base'),
                        'null' => __('Not specified', 'pdc-base')
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
                            'desc' => __("Example text by the VNG which is used for one's own SDG text. Will be updated regularly by the VNG editorial. Check the checkbox below the header 'Edits' to add a custom SDG text.", 'pdc-base'),
                            'type' => 'textarea',
                            'readonly' => true
                        ],
                        [
                            'id'   => 'enrichment_links',
                            'name' => __('Links', 'pdc-base'),
                            'type' => 'key_value',
                        ],
                        [
                            'id'   => 'enrichment_procedure_link',
                            'name' => __('Procedure link', 'pdc-base'),
                            'type' => 'key_value',
                            'desc' => __('At the moment there is support for only one key-value field, other pairs added are not used.', 'pdc-base'),
                        ],
                        [
                            'name' => __('Procedure description', 'pdc-base'),
                            'id'   => 'enrichment_procedure_desc',
                            'type' => 'textarea',
                            'readonly' => true
                        ],
                        [
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
                            'type' => 'wysiwyg',
                            'options' => [
                                'textarea_rows' => 4,
                                'quicktags' => false,
                                'teeny' => true
                            ],
                        ],
                        [
                            'type' => 'heading',
                            'name' => __('SDG FAQ', 'pdc-base')
                        ],
                        [
                            'name' => __('Proof', 'pdc-base'),
                            'id'   => 'enrichment_proof',
                            'type' => 'wysiwyg',
                            'options' => [
                                'textarea_rows' => 4,
                                'quicktags' => false,
                                'teeny' => true
                            ],
                            'desc' => __('Proof to deliver.', 'pdc-base')
                        ],
                        [
                            'name' => __('Requirements', 'pdc-base'),
                            'id'   => 'enrichment_requirements',
                            'type' => 'wysiwyg',
                            'options' => [
                                'textarea_rows' => 4,
                                'quicktags' => false,
                                'teeny' => true
                            ],
                            'desc' => __('Requirements to fulfill on.', 'pdc-base')
                        ],
                        [
                            'name' => __('Object and appeal', 'pdc-base'),
                            'id'   => 'enrichment_object_and_appeal',
                            'type' => 'wysiwyg',
                            'options' => [
                                'textarea_rows' => 4,
                                'quicktags' => false,
                                'teeny' => true
                            ],
                            'desc' => __('How to object and appeal against.', 'pdc-base')
                        ],
                        [
                            'name' => __('Payment methods', 'pdc-base'),
                            'id'   => 'enrichment_payment_methods',
                            'type' => 'wysiwyg',
                            'options' => [
                                'textarea_rows' => 4,
                                'quicktags' => false,
                                'teeny' => true
                            ],
                            'desc' => __('Is there an payment required?', 'pdc-base')
                        ],
                        [
                            'name' => __('Deadline', 'pdc-base'),
                            'id'   => 'enrichment_deadline',
                            'type' => 'wysiwyg',
                            'options' => [
                                'textarea_rows' => 4,
                                'quicktags' => false,
                                'teeny' => true
                            ],
                            'desc' => __('When is the deadline?', 'pdc-base')
                        ],
                        [
                            'name' => __('Action when to reaction', 'pdc-base'),
                            'id'   => 'enrichment_action_when_no_reaction',
                            'type' => 'wysiwyg',
                            'options' => [
                                'textarea_rows' => 4,
                                'quicktags' => false,
                                'teeny' => true
                            ],
                            'desc' => __('What to do when a reaction remains.', 'pdc-base')
                        ],
                        [
                            'type' => 'heading',
                            'name' => __('Product additional information', 'pdc-base')
                        ],
                        [
                            'name' => __('Product present', 'pdc-base'),
                            'id'   => 'enrichment_product_present_explanation',
                            'type' => 'text',
                            'desc' => __('Specify the status of this product. If this product is not present this field is required!', 'pdc-base')
                        ],
                        [
                            'name' => __('Product belongs to', 'pdc-base'),
                            'id'   => 'enrichment_product_belongs_to_explanation',
                            'type' => 'text',
                            'desc' => __('Specify the owner of this product.', 'pdc-base')
                        ],
                    ]
                ]
            ]
        ]
    ]
];
