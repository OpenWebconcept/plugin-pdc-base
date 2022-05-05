<?php

return [
    'base' => [
        'id'         => 'pdc_metadata',
        'title'      => __('Data', 'pdc-base'),
        'post_types' => ['pdc-item'],
        'context'    => 'normal',
        'priority'   => 'high',
        'autosave'   => true,
        'fields'     => [
            'general'     => [
                'heading'  => [
                    'type' => 'heading',
                    'name' => __('General', 'pdc-base'),
                ],
                'title'    => [
                    'name' => __('Title alternative', 'pdc-base'),
                    'desc' => __('Use this option if you want to use an alternative title', 'pdc-base'),
                    'id'   => 'pdc_titel_alternatief',
                    'type' => 'text',
                ],
                'synonyms' => [
                    'name' => __('Synonyms', 'pdc-base'),
                    'desc' => __('Use this option to add an comma separated list of synonyms or related terms', 'pdc-base'),
                    'id'   => 'pdc_tags',
                    'type' => 'textarea',
                ],
                'active'   => [
                    'name'    => __('Active', 'pdc-base'),
                    'desc'    => __('Is this product active yes/no', 'pdc-base'),
                    'id'      => 'pdc_active',
                    'type'    => 'radio',
                    'options' => [
                        '1' => 'Ja',
                        '0' => 'Nee',
                    ],
                    'std'     => '1',
                ],
            ],
            'appointment' => [
                'heading' => [
                    'type' => 'heading',
                    'name' => __('Make an appointment', 'pdc-base'),
                ],
                'active'  => [
                    'name'    => __('Active', 'pdc-base'),
                    'desc'    => __('Is an appointment obligatory for this product yes/no?', 'pdc-base'),
                    'id'      => 'pdc_afspraak_active',
                    'type'    => 'radio',
                    'options' => [
                        '1' => 'Ja',
                        '0' => 'Nee',
                    ],
                    'std'     => '0',
                ],
                'title'   => [
                    'name' => __('Appointment button title', 'pdc-base'),
                    'desc' => __('Leave empty for default value usage.', 'pdc-base'),
                    'id'   => 'pdc_afspraak_title',
                    'type' => 'text',
                ],
                'url'     => [
                    'name' => __('Appointment URL', 'pdc-base'),
                    'desc' => __('Use this field to get a specific URL for the appointment button. URL including http(s)://', 'pdc-base'),
                    'id'   => 'pdc_afspraak_url',
                    'type' => 'text',
                ],
                'meta'    => [
                    'name' => __('Appointment meta', 'pdc-base'),
                    'desc' => __('Use this field if the appointment method leverages an special data attribute like eg. GravityForms-id (currently not in use)', 'pdc-base'),
                    'id'   => 'pdc_afspraak_meta',
                    'type' => 'text',
                ],
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
                    'add_button' => __('Add new link', 'pdc-base'),
                    'fields'     => [
                        [
                            'id'   => 'pdc_links_title',
                            'name' => __('Link title', 'pdc-base'),
                            'desc' => __('Use the title to replace the URL', 'pdc-base'),
                            'type' => 'text',
                        ],
                        [
                            'id'   => 'pdc_links_url',
                            'name' => __('Link URL', 'pdc-base'),
                            'desc' => __('URL including http(s)://', 'pdc-base'),
                            'type' => 'text',
                        ],
                        [
                            'id'   => 'pdc_links_shortcode',
                            'name' => __('Link shortcode URL', 'pdc-base'),
                            'desc' => __('Insert shortcode instead of URL. This overrides Link URL.', 'pdc-base'),
                            'type' => 'text',
                        ],
                    ],
                ],
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
                    'add_button' => __('Add new download', 'pdc-base'),
                    'fields'     => [
                        [
                            'id'   => 'pdc_downloads_title',
                            'name' => __('Download title', 'pdc-base'),
                            'desc' => __('Use the title to replace the URL', 'pdc-base'),
                            'type' => 'text',
                        ],
                        [
                            'id'   => 'pdc_downloads_url',
                            'name' => __('Download URL', 'pdc-base'),
                            'desc' => __('URL including http(s)://', 'pdc-base'),
                            'type' => 'text',
                        ],
                        [
                            'id'   => 'pdc_downloads_shortcode',
                            'name' => __('Download shortcode url', 'pdc-base'),
                            'desc' => __('Insert shortcode instead of url. This overrides url', 'pdc-base'),
                            'type' => 'text',
                        ],
                    ],
                ],
            ],
            'forms'       => [
                'heading' => [
                    'type' => 'heading',
                    'name' => __('Forms', 'pdc-base'),
                ],
                'forms'   => [
                    'id'         => 'pdc_forms_group',
                    'type'       => 'group',
                    'clone'      => true,
                    'sort_clone' => true,
                    'add_button' => __('Add new form', 'pdc-base'),
                    'fields'     => [
                        [
                            'id'   => 'pdc_forms_title',
                            'name' => __('Form title', 'pdc-base'),
                            'desc' => __('Use the title to replace the URL', 'pdc-base'),
                            'type' => 'text',
                        ],
                        [
                            'id'   => 'pdc_forms_url',
                            'name' => __('Form URL', 'pdc-base'),
                            'desc' => __('URL including http(s)://', 'pdc-base'),
                            'type' => 'url',
                        ],
                        [
                            'id'   => 'pdc_forms_shortcode',
                            'name' => __('Form shortcode url', 'pdc-base'),
                            'desc' => __('Insert shortcode instead of url. This overrides url', 'pdc-base'),
                            'type' => 'text',
                        ],
                    ],
                ],
            ],
            'government'  => [
                'heading'      => [
                    'type' => 'heading',
                    'name' => __('Government standards', 'pdc-base'),
                ],
                'upl_name'     => [
                    'name' => __('UPL name', 'pdc-base'),
                    'desc' => __('Available terms can be found at: \'https://standaarden.overheid.nl/owms/oquery/UPL-actueel.plain\'. For more information please visit \'https://standaarden.overheid.nl/upl\'.', 'pdc-base'),
                    'id'   => 'pdc_upl_naam',
                    'type' => 'select_advanced',
                    'options' => [],
                ],
            ],
            'other'       => [
                'heading' => [
                    'type' => 'heading',
                    'name' => __('Other', 'pdc-base'),
                ],
                'other'   => [
                    'name' => __('Notes', 'pdc-base'),
                    'desc' => __('(the law, authority, local regulations, etc.)', 'pdc-base'),
                    'id'   => 'pdc_other_meta',
                    'type' => 'textarea',
                    'cols' => 20,
                    'rows' => 5,
                ],
            ],
            'language' => [
                'heading' => [
                    'type' => 'heading',
                    'name' => __('Language', 'pdc-base'),
                ],
                'language' => [
                    'name'            => __('Language', 'pdc-base'),
                    'desc'            => __('Select a language that is not Dutch. This is necessary for the web accessibility.', 'pdc-base'),
                    'id'              => 'pdc-item-language',
                    'type'            => 'select',
                    'placeholder'     => __('Dutch (default)', 'pdc-base'),
                    'options'         => [
                        'en'    => __('English', 'pdc-base'),
                        'de'    => __('German', 'pdc-base'),
                        'tr'    => __('Turkish', 'pdc-base'),
                    ],
                ]
            ],
        ],
    ],
    'pdc-category' => [
        'id'         => 'pdc_category_metadata',
        'title'      => __('Icon', 'pdc-base'),
        'post_types' => ['pdc-category'],
        'context'    => 'side',
        'priority'   => 'high',
        'fields'     => [
            'general'     => [
                'title'    => [
                    'name' => __('Icon', 'pdc-base'),
                    'desc' => __('Use this option to add an icon to this theme.', 'pdc-base'),
                    'id'   => 'pdc_category_icon',
                    'type' => 'text',
                ],
            ]
        ]
    ],
    'pdc-subcategory' => [
        'id'         => 'pdc_subcategory_metadata',
        'title'      => __('Icon', 'pdc-base'),
        'post_types' => ['pdc-subcategory'],
        'context'    => 'side',
        'priority'   => 'high',
        'fields'     => [
            'general'     => [
                'title'    => [
                    'name' => __('Icon', 'pdc-base'),
                    'desc' => __('Use this option to add an icon to this subtheme.', 'pdc-base'),
                    'id'   => 'pdc_category_icon',
                    'type' => 'text',
                ],
            ]
        ]
    ]
];
