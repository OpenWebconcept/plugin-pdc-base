<?php

return [

    /**
     * Examples of registering taxonomies: http://johnbillion.com/extended-cpts/
     */
    'pdc-doelgroep' => [
        'object_types' => ['pdc-item'],
        'args'         => [
            'labels'   => [
                'name'                       => __('Audience', 'pdc-base'),
                'singular_name'              => __('Audience', 'pdc-base'),
                'menu_name'                  => __('Audience', 'pdc-base'),
                'all_items'                  => __('All audiences', 'pdc-base'),
                'edit_item'                  => __('Edit audience', 'pdc-base'),
                'view_item'                  => __('View audience', 'pdc-base'),
                'update_item'                => __('Update audience', 'pdc-base'),
                'add_new_item'               => __('Add new audience', 'pdc-base'),
                'new_item_name'              => __('New audience', 'pdc-base'),
                'parent_item_colon'          => __('Parent audience:', 'pdc-base'),
                'search_items'               => __('Search audience', 'pdc-base'),
                'separate_items_with_commas' => __('Separate tags with commas', 'pdc-base'),
                'add_or_remove_items'        => __('Add or remove tags', 'pdc-base'),
                'choose_from_most_used'      => __('Choose from the most used tags', 'pdc-base'),
                'not_found'                  => __('No audience found.', 'pdc-base'),
                'back_to_items'              => __('← Back to tags', 'pdc-base'),
            ],
            'meta_box' => 'simple',
        ],
        'names'        => [
            'singular' => __('Audience', 'pdc-base'),
            'plural'   => __('Audiences', 'pdc-base'),
            'slug'     => 'pdc-doelgroep',
        ],
    ],

    'pdc-type'      => [
        'object_types' => ['pdc-item'],
        'args'         => [
            'meta_box'     => 'simple',
            'show_in_rest' => false,
        ],
        'names'        => [
            'singular' => __('Type', 'pdc-base'),
            'plural'   => __('Types', 'pdc-base'),
            'slug'     => 'pdc-type',
        ],
    ],

    'pdc-aspect'    => [
        'object_types' => ['pdc-item'],
        'args'         => [
            'meta_box'     => 'simple',
            'show_in_rest' => false,
        ],
        'names'        => [
            'singular' => __('Aspect', 'pdc-base'),
            'plural'   => __('Aspects', 'pdc-base'),
            'slug'     => 'pdc-kenmerk',
        ],
    ],
    'pdc-usage'     => [
        'object_types' => ['pdc-item'],
        'args'         => [
            'meta_box'     => 'simple',
            'show_in_rest' => false,
        ],
        'names'        => [
            'singular' => __('Usage', 'pdc-base'),
            'plural'   => __('Usages', 'pdc-base'),
            'slug'     => 'pdc-toepassing',
        ],
    ],
    'pdc-owner'     => [
        'object_types' => ['pdc-item'],
        'args'         => [
            'meta_box'          => 'simple',
            'show_in_rest'      => false,
            'show_admin_column' => true,
        ],
        'names'        => [
            'singular' => __('Owner', 'pdc-base'),
            'plural'   => __('Owners', 'pdc-base'),
            'slug'     => 'pdc-owner',
        ],
    ],
];
