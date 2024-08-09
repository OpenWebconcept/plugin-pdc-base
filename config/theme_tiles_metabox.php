<?php

return [
    'tiles' => [
        'id' => 'pdc_tiles',
        'title' => __('Tiles', 'pdc-base'),
        'post_types' => ['pdc-category'],
        'context' => 'normal',
        'priority' => 'low',
        'autosave' => true,
        'fields' => [
            'tiles' => [
                'group' => [
                    'id'         => 'pdc_tiles_group',
                    'type'       => 'group',
                    'clone'      => true,
                    'sort_clone' => true,
                    'add_button' => __('Add new tile', 'pdc-base'),
                    'fields'     => [
                        [
                            'id'   => 'pdc_tile_title',
                            'name' => __('Title', 'pdc-base'),
                            'type' => 'text',
                        ],
						[
                            'id'   => 'pdc_tile_url',
                            'name' => __('URL', 'pdc-base'),
                            'type' => 'url',
                        ],
						[
                            'id'   => 'pdc_tile_icon',
                            'name' => __('Icon', 'pdc-base'),
                            'type' => 'text',
                        ],
                    ],
                ],
            ],
        ]
    ]
];
