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
                            'readonly' => true
                        ],
                        [
                            'name' => __('Specific Text', 'pdc-base'),
                            'id'   => 'enrichment_specific_text',
                            'type' => 'textarea',
                            'readonly' => true
                        ],
                        [
                            'name' => __('Specific text in feed', 'pdc-base'),
                            'id'   => 'enrichment_specific_show_in_checkbox',
                            'type' => 'checkbox',
                        ],
                        [
                            'name' => __('Procedure description', 'pdc-base'),
                            'id'   => 'enrichment_procedure_description',
                            'type' => 'textarea'
                        ]
                    ]
                ]
            ]
        ]
    ]
];