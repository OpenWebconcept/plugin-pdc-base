<?php

return [

    'base' => [
        'id'             => 'general',
        'title'          => _x('Portal', 'PDC instellingen subpagina', 'pdc-base'),
        'settings_pages' => '_owc_pdc_base_settings',
        'tab'            => 'base',
        'fields'         => [
            'portal' => [
                'portal_url'    => [
                    'name' => __('Portal URL', 'pdc-base'),
                    'desc' => __('URL including http(s)://', 'pdc-base'),
                    'id'   => 'setting_portal_url',
                    'type' => 'text'
                ],
                'pdc_item_slug' => [
                    'name' => __('Portal PDC item slug', 'pdc-base'),
                    'desc' => __('URL for PDC items in the portal, eg "onderwerp"', 'pdc-base'),
                    'id'   => 'setting_portal_pdc_item_slug',
                    'type' => 'text'
                ],
                'pdc_theme_in_portal_url' => [
                    'name' => __('Theme in "View in portal" slug', 'pdc-base'),
                    'desc' => __('Include theme, of PDC item, in "View in portal" slug?', 'pdc-base'),
                    'id'   => 'setting_include_theme_in_portal_url',
                    'type' => 'checkbox',
                ],
                'pdc_subtheme_in_portal_url' => [
                    'name' => __('Subtheme in "View in portal" slug', 'pdc-base'),
                    'desc' => __('Include subtheme, of PDC item, in "View in portal" slug?', 'pdc-base'),
                    'id'   => 'setting_include_subtheme_in_portal_url',
                    'type' => 'checkbox',
                ],
                'pdc_id_in_portal_url' => [
                    'name' => __('ID in "View in portal" slug', 'pdc-base'),
                    'desc' => __('Include ID, of PDC item, in "View in portal" slug?', 'pdc-base'),
                    'id'   => 'setting_include_id_in_portal_url',
                    'type' => 'checkbox',
                    'std' => 1,
                ],
                'pdc_use_group_cpt' => [
                    'name' => __('Use the group layer', 'pdc-base'),
                    'desc' => __('Use the group layer as connection between a pdc-item and a pdc-group.', 'pdc-base'),
                    'id'   => 'setting_pdc-group',
                    'type' => 'checkbox',
                ],
                'pdc_use_identifications' => [
                    'name' => __('Use identifications', 'pdc-base'),
                    'desc' => __('DigiD, eHerkenning and eIDAS.', 'pdc-base'),
                    'id'   => 'setting_identifications',
                    'type' => 'checkbox',
                ],
                'pdc_use_portal_url' => [
                    'name' => __('Portal url', 'pdc-base'),
                    'desc' => __('Use portal url in api.', 'pdc-base'),
                    'id'   => 'setting_use_portal_url',
                    'type' => 'checkbox',
                ],
                'pdc_use_escape_element' => [
                    'name' => __('Escape element', 'pdc-base'),
                    'desc' => __('Enable escape element.', 'pdc-base'),
                    'id'   => 'setting_use_escape_element',
                    'type' => 'checkbox',
                ],
                'upl_heading' => [
                    'type' => 'heading',
                    'name' => __('The Uniform Product list of names (upl)', 'pdc-base'),
                ],
                'upl_terms_url'  => [
                    'name' => __('URL', 'pdc-base'),
                    'desc' => __('URL used for retrieving UPL terms.', 'pdc-base'),
                    'id'   => 'upl_terms_url',
                    'type' => 'text'
                ],
            ]
        ]
    ]
];
