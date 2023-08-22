<?php

return [
    'show_on' => [
        'id' => 'show_on',
        'title' => __('External', 'pdc-base'),
        'post_types' => ['pdc-item', 'pdc-category', 'pdc-subcategory'],
        'context' => 'normal',
        'priority' => 'low',
        'autosave' => true,
        'fields' => [
            'settings' => [
                [
                    'name' => __('Show on', 'pdc-base'),
                    'desc' => __('Select websites where this item should be displayed on.', 'pdc-base'),
                    'id' => 'show_on_active',
                    'type' => 'taxonomy',
                    'taxonomy' => 'pdc-show-on',
                    'field_type' => 'select_advanced',
                    'required' => 1,
                    'multiple' => 1
                ],
            ]
        ]
    ]
];
