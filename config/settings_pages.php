<?php

return [

    'base' => [
        'id'            => '_owc_pdc_base_settings',
        'option_name'   => '_owc_pdc_base_settings',
        'menu_title'    => __('PDC settings', 'pdc-base'),
        'icon_url'      => 'dashicons-admin-settings',
        'submenu_title' => _x('Base', 'PDC settings subpage', 'pdc-base'),
        'position'      => 9,
        'columns'       => 1,
        'submit_button' => _x('Submit', 'PDC settings subpage', 'pdc-base'),
        'tabs'          => [
            'base'        => _x('General', 'PDC settings tab', 'pdc-base')
        ]
    ]
];
