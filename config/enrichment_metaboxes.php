<?php


return [
    'enrichment' => [
        'id'         => 'pdc_enrichment',
        'title'      => __('Enrichment', 'pdc-base'),
        'post_types' => ['pdc-item'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     => [
            'enrichtment-data' => [
                'data   ' => [
                    'name' => __('Last modified', 'pdc-base'),
                    'id'   => 'enrichment_version_date',
                    'type' => 'date',
                    'desc' => __('This field shows the latest version.', 'pdc-base'),
                    'readonly' => true,
                ]
            ],
            'enrichment-group' => [
                'group' => [
                    'id'         => 'enrichment-group',
                    'type'       => 'group',
                    'clone'      => false,
                    'add_button' => __('Add new enrichment', 'pdc-base'),
                    'fields'     => [
                        [
                            'name' => __('Language', 'pdc-base'),
                            'id'   => 'enrichment_language',
                            'type' => 'text',
                            'desc' => __('The language of the loaded text is shown here.', 'pdc-base'),
                            'readonly' => true
                        ],
                        [
                            'name' => __('Mandatory text', 'pdc-base'),
                            'id'   => 'enrichment_specific_text',
                            'type' => 'textarea',
                            'desc' => __('This text needs to be placed in the content as an exact copy. Select the complete text, copy (CTRL+C) the text and paste (CTRL+V) the text in the content of the corresponding PDC item.', 'pdc-base'),
                            'readonly' => true
                        ],
                        [
                            'name' => __('Mandatory text to SDG', 'pdc-base'),
                            'id'   => 'enrichment_specific_show_in_api',
                            'type' => 'checkbox',
                            'desc' => __('Activate this field if the mandatory text is not part of the content but needs to be send to the SDG API.', 'pdc-base'),
                        ],
                        [
                            'name' => __('Procedure description', 'pdc-base'),
                            'id'   => 'enrichment_procedure_description',
                            'desc' => __('This text can be modified and copied here. Be aware: After updating, this text will be reset!', 'pdc-base'),
                            'type' => 'wysiwyg'
                        ],
                    ]
                ]
            ]
        ]
    ]
];