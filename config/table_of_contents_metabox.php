<?php

return [
    'table_of_contents' => [
        'id' => 'table_of_contents',
        'title' => __('Table of contents', 'pdc-base'),
        'post_types' => ['pdc-item'],
        'context' => 'normal',
        'priority' => 'high',
        'autosave' => true,
        'fields' => [
            'table_of_contents' => [
                [
                    'name' => __('Table of contents', 'pdc-base'),
                    'desc' => __('Use this option if you want to use a table of contents', 'pdc-base'),
                    'id' => 'pdc_use_table_of_contents',
                    'type' => 'checkbox',
                ]
            ],
        ]
    ]
];
