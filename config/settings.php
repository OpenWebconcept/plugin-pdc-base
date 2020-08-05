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
                'pdc_subtheme_in_portal_url' => [
                    'name' => __('PDC item subtheme in "View in portal" slug', 'pdc-base'),
                    'desc' => __('Include subtheme, of PDC item, in "View in portal" slug? Default only uses the theme.', 'pdc-base'),
                    'id'   => 'setting_include_subtheme_in_portal_url',
                    'type' => 'checkbox',
                ],
                'pdc_use_mainthema_cpt' => [
                    'name' => __('Use the maintheme layer', 'pdc-base'),
                    'desc' => __('Use the mainthema layer as parent for the theme layer, below theme layer is the subtheme layer', 'pdc-base'),
                    'id'   => 'setting_pdc-maincategory',
                    'type' => 'checkbox',
                ]
            ]
        ]
    ]
];
