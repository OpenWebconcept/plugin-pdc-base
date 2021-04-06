<?php

return [
    'escape_element' => [
        'id'         => 'escape_element',
        'title'      => __('Escape element', 'pdc-base'),
        'post_types' => ['pdc-item'],
        'context'    => 'normal',
        'priority'   => 'low',
        'autosave'   => true,
        'fields'     => [
            'settings' => [
                [
                    'name'    => __('Enable escape element', 'pdc-base'),
                    'desc'    => __('Show escape element on portal page.', 'pdc-base'),
                    'id'      => 'escape_element_active',
                    'type'    => 'radio',
                    'options' => [
                        '1' => __('Yes', 'pdc-base'),
                        '0' => __('No', 'pdc-base'),
                    ],
                    'std'     => '0',
                ],
            ]
        ]
    ]
];
