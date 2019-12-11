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
                ]
            ]
        ]
    ]
];
