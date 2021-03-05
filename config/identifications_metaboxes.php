<?php

return [
    'identifications' => [
        'id'         => 'pdc_identifications',
        'title'      => __('Identifications', 'pdc-base'),
        'post_types' => ['pdc-item'],
        'context'    => 'normal',
        'priority'   => 'low',
        'autosave'   => true,
        'fields'     => [
            'digid-group' => [
                'group' => [
                    'id'         => 'digid-group',
                    'type'       => 'group',
                    'clone'      => true,
                    'add_button' => __('Add new group', 'pdc-base'),
                    'fields'     => [
                        [
                            'type' => 'heading',
                            'name' => __('DigiD', 'pdc-base'),
                        ],
                        [
                            'name'    => __('Active', 'pdc-base'),
                            'desc'    => __('Use DigiD for identification.', 'pdc-base'),
                            'id'      => 'digid_active',
                            'type'    => 'radio',
                            'options' => [
                                '1' => __('Yes', 'pdc-base'),
                                '0' => __('No', 'pdc-base'),
                            ],
                            'std'     => '0',
                        ],
                        [
                            'name' => __('DigiD button title', 'pdc-base'),
                            'id'   => 'digid_button_title',
                            'type' => 'text',
                            'std'  => __('Request', 'pdc-base'),
                        ],
                        [
                            'name' => __('DigiD button URL', 'pdc-base'),
                            'id'   => 'digid_button_url',
                            'type' => 'text',
                        ],
                        [
                            'name'    => __('DigiD descriptive text', 'pdc-base'),
                            'id'      => 'digid_descriptive_text',
                            'type'    => 'wysiwyg',
                            'options' => [
                                'textarea_rows' => 4,
                            ],
                            'std' => 'Log in met DigiD en uw persoonsgegevens zijn al ingevuld. <a href="/online-zaken-regelen-met-digid/">Lees meer over DigiD</a>.',
                        ],
                        [
                            'name' => __('Order', 'pdc-base'),
                            'id'   => 'digid_order',
                            'type' => 'number',
                            'min'  => 0,
                            'desc' => __('Order in which the identification buttons will be displayed in.', 'pdc-base')
                        ],
                    ]
                ]
            ],
            'eherkenning-group' => [
                'group' => [
                    'id'         => 'eherkenning-group',
                    'type'       => 'group',
                    'clone'      => true,
                    'add_button' => __('Add new group', 'pdc-base'),
                    'fields'     => [
                        [
                            'type' => 'heading',
                            'name' => __('eHerkenning', 'pdc-base'),
                        ],
                        [
                            'name'    => __('Active', 'pdc-base'),
                            'desc'    => __('Use eHerkenning for identification.', 'pdc-base'),
                            'id'      => 'eherkenning_active',
                            'type'    => 'radio',
                            'options' => [
                                '1' => __('Yes', 'pdc-base'),
                                '0' => __('No', 'pdc-base'),
                            ],
                            'std'     => '0',
                        ],
                        [
                            'name' => __('eHerkenning button title', 'pdc-base'),
                            'id'   => 'eherkenning_button_title',
                            'type' => 'text',
                            'std'  => __('Request', 'pdc-base'),
                        ],
                        [
                            'name' => __('eHerkenning button URL', 'pdc-base'),
                            'id'   => 'eherkenning_button_url',
                            'type' => 'text',
                        ],
                        [
                            'name'    => __('eHerkenning descriptive text', 'pdc-base'),
                            'id'      => 'eherkenning_descriptive_text',
                            'type'    => 'wysiwyg',
                            'options' => [
                                'textarea_rows' => 4,
                            ],
                            'std' => 'Log in met eHerkenning en uw organisatiegegevens zijn al ingevuld. <a href="/online-zaken-regelen-met-eherkenning/">Lees meer over eHerkenning</a>.',
                        ],
                        [
                            'name' => __('Order', 'pdc-base'),
                            'id'   => 'eherkenning_order',
                            'type' => 'number',
                            'min'  => 0,
                            'desc' => __('Order in which the identification buttons will be displayed in.', 'pdc-base')
                        ]
                    ]
                ]
            ],
            'eidas-group' => [
                'group' => [
                    'id'         => 'eidas-group',
                    'type'       => 'group',
                    'clone'      => true,
                    'add_button' => __('Add new group', 'pdc-base'),
                    'fields'     => [
                        [
                            'type' => 'heading',
                            'name' => __('eIDAS', 'pdc-base'),
                        ],
                        [
                            'name'    => __('Active', 'pdc-base'),
                            'desc'    => __('Use eIDAS for identification.', 'pdc-base'),
                            'id'      => 'eidas_active',
                            'type'    => 'radio',
                            'options' => [
                                '1' => __('Yes', 'pdc-base'),
                                '0' => __('No', 'pdc-base'),
                            ],
                            'std'     => '0',
                        ],
                        [
                            'name' => __('eIDAS button title', 'pdc-base'),
                            'id'   => 'eidas_button_title',
                            'type' => 'text',
                            'std'  => __('Request', 'pdc-base'),
                        ],
                        [
                            'name' => __('eIDAS button URL', 'pdc-base'),
                            'id'   => 'eidas_button_url',
                            'type' => 'text',
                        ],
                        [
                            'name'    => __('eIDAS descriptive text', 'pdc-base'),
                            'id'      => 'eidas_descriptive_text',
                            'type'    => 'wysiwyg',
                            'options' => [
                                'textarea_rows' => 4,
                            ],
                            'std' => 'Login with your European approved digital identity. More information on <a href="https://www.digitaleoverheid.nl/overzicht-van-alle-onderwerpen/identiteit/eidas/">eIDAS</a>.',
                        ],
                        [
                            'name' => __('Order', 'pdc-base'),
                            'id'   => 'eidas_order',
                            'type' => 'number',
                            'min'  => 0,
                            'desc' => __('Order in which the identification buttons will be displayed in.', 'pdc-base')
                        ]
                    ]
                ]
            ],
            'general_identification-group' => [
                'group' => [
                    'id'         => 'general_identification-group',
                    'type'       => 'group',
                    'clone'      => true,
                    'add_button' => __('Add new group', 'pdc-base'),
                    'fields'     => [
                        [
                            'type' => 'heading',
                            'name' => __('General identification', 'pdc-base'),
                        ],
                        [
                            'name'    => __('Active', 'pdc-base'),
                            'desc'    => __('Use general identification.', 'pdc-base'),
                            'id'      => 'general_identification_active',
                            'type'    => 'radio',
                            'options' => [
                                '1' => __('Yes', 'pdc-base'),
                                '0' => __('No', 'pdc-base'),
                            ],
                            'std'     => '0',
                        ],
                        [
                            'name' => __('General identification button title', 'pdc-base'),
                            'id'   => 'general_identification_button_title',
                            'type' => 'text',
                            'std'  => __('Request', 'pdc-base'),
                        ],
                        [
                            'name' => __('General identification button URL', 'pdc-base'),
                            'id'   => 'general_identification_button_url',
                            'type' => 'text',
                        ],
                        [
                            'name'    => __('General_identification descriptive text', 'pdc-base'),
                            'id'      => 'general_identification_descriptive_text',
                            'type'    => 'wysiwyg',
                            'options' => [
                                'textarea_rows' => 4,
                            ],
                            'std' => 'Ga verder zonder in te loggen en vul uw gegevens in.',
                        ],
                        [
                            'name' => __('Order', 'pdc-base'),
                            'id'   => 'general_identification_order',
                            'type' => 'number',
                            'min'  => 0,
                            'desc' => __('Order in which the identification buttons will be displayed in.', 'pdc-base')
                        ]
                    ]
                ]
            ],
        ],
    ]
];
