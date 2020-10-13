<?php

return [

    'base' => [
        'id'         => 'pdc_metadata',
        'title'      => __('Data', 'pdc-base'),
        'post_types' => ['pdc-item'],
        'context'    => 'normal',
        'priority'   => 'high',
        // Auto save: true, false (default). Optional.
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
                    'desc' => __('Example: aanduiding naamgebruik', 'pdc-base'),
                    'id'   => 'pdc_upl_naam',
                    'type' => 'text',
                ],
                'upl_resource' => [
                    'name' => __('UPL resource', 'pdc-base'),
                    'desc' => __('Example: http://standaarden.overheid.nl/owms/terms/{aanduiding_naamgebruik}', 'pdc-base'),
                    'id'   => 'pdc_upl_resource',
                    'type' => 'text',
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
            'digid' => [
                'heading' => [
                    'type' => 'heading',
                    'name' => __('DigiD', 'pdc-base'),
                ],
                'active'  => [
                    'name'    => __('Active', 'pdc-base'),
                    'desc'    => __('Use DigiD for identification.', 'pdc-base'),
                    'id'      => 'digid_active',
                    'type'    => 'radio',
                    'options' => [
                        '1' => 'Ja',
                        '0' => 'Nee',
                    ],
                    'std'     => '0',
                ],
                'button-title'   => [
                    'name' => __('DigiD button title', 'pdc-base'),
                    'id'   => 'digid_button_title',
                    'desc' => __('Leave empty for default value usage.', 'pdc-base'),
                    'type' => 'text',
                ],
                'button-url'   => [
                    'name' => __('DigiD button URL', 'pdc-base'),
                    'id'   => 'digid_button_url',
                    'type' => 'text',
                ],
                'descriptive-text'   => [
                    'name' => __('DigiD descriptive text', 'pdc-base'),
                    'id'   => 'digid_descriptive_text',
                    'type' => 'wysiwyg',
                    'options' => array(
                        'textarea_rows' => 4,
                    ),
                ],
            ],
            'eherkenning' => [
                'heading' => [
                    'type' => 'heading',
                    'name' => __('eHerkenning', 'pdc-base'),
                ],
                'active'  => [
                    'name'    => __('Active', 'pdc-base'),
                    'desc'    => __('Use eHerkenning for identification.', 'pdc-base'),
                    'id'      => 'eherkenning_active',
                    'type'    => 'radio',
                    'options' => [
                        '1' => 'Ja',
                        '0' => 'Nee',
                    ],
                    'std'     => '0',
                ],
                'button-title'   => [
                    'name' => __('eHerkenning button title', 'pdc-base'),
                    'id'   => 'eherkenning_button_title',
                    'desc' => __('Leave empty for default value usage.', 'pdc-base'),
                    'type' => 'text',
                ],
                'button-url'   => [
                    'name' => __('eHerkenning button URL', 'pdc-base'),
                    'id'   => 'eherkenning_button_url',
                    'type' => 'text',
                ],
                'descriptive-text'   => [
                    'name' => __('eHerkenning descriptive text', 'pdc-base'),
                    'id'   => 'eherkenning_descriptive_text',
                    'type' => 'wysiwyg',
                    'options' => array(
                        'textarea_rows' => 4,
                    ),
                ],
            ],
            'eidas' => [
                'heading' => [
                    'type' => 'heading',
                    'name' => __('eIDAS', 'pdc-base'),
                ],
                'active'  => [
                    'name'    => __('Active', 'pdc-base'),
                    'desc'    => __('Use eIDAS for identification.', 'pdc-base'),
                    'id'      => 'eidas_active',
                    'type'    => 'radio',
                    'options' => [
                        '1' => 'Ja',
                        '0' => 'Nee',
                    ],
                    'std'     => '0',
                ],
                'button-title'   => [
                    'name' => __('eIDAS button title', 'pdc-base'),
                    'id'   => 'eidas_button_title',
                    'desc' => __('Leave empty for default value usage.', 'pdc-base'),
                    'type' => 'text',
                ],
                'button-url'   => [
                    'name' => __('eIDAS button URL', 'pdc-base'),
                    'id'   => 'eidas_button_url',
                    'type' => 'text',
                ],
                'descriptive-text'   => [
                    'name' => __('eIDAS descriptive text', 'pdc-base'),
                    'id'   => 'eidas_descriptive_text',
                    'type' => 'wysiwyg',
                    'options' => array(
                        'textarea_rows' => 4,
                    ),
                ],
            ],
            'general_identification' => [
                'heading' => [
                    'type' => 'heading',
                    'name' => __('General identification', 'pdc-base'),
                ],
                'active'  => [
                    'name'    => __('Active', 'pdc-base'),
                    'desc'    => __('Use general identification.', 'pdc-base'),
                    'id'      => 'general_identification_active',
                    'type'    => 'radio',
                    'options' => [
                        '1' => 'Ja',
                        '0' => 'Nee',
                    ],
                    'std'     => '0',
                ],
                'button-title'   => [
                    'name' => __('General identification button title', 'pdc-base'),
                    'id'   => 'general_identification_button_title',
                    'desc' => __('Leave empty for default value usage.', 'pdc-base'),
                    'type' => 'text',
                ],
                'button-url'   => [
                    'name' => __('General identification button URL', 'pdc-base'),
                    'id'   => 'general_identification_button_url',
                    'type' => 'text',
                ],
                'descriptive-text'   => [
                    'name' => __('General_identification descriptive text', 'pdc-base'),
                    'id'   => 'general_identification_descriptive_text',
                    'type' => 'wysiwyg',
                    'options' => array(
                        'textarea_rows' => 4,
                    ),
                ],
            ],
        ],
    ],
];
