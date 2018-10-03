<?php

return [

    /**
     * Examples of registering post types: http://johnbillion.com/extended-cpts/
     */
    'pdc-item'        => [
        'args'  => [
            'labels'        => [
                'name'               => __('PDC item', 'pdc-base'),
                'singular_name'      => __('PDC item', 'pdc-base'),
                'add_new'            => __('Add new pdc item', 'pdc-base'),
                'add_new_item'       => __('Add new pdc item', 'pdc-base'),
                'edit_item'          => __('Edit pdc item', 'pdc-base'),
                'new_item'           => __('New pdc item', 'pdc-base'),
                'view_item'          => __('View pdc item', 'pdc-base'),
                'view_items'         => __('View pdc items', 'pdc-base'),
                'search_items'       => __('Search pdc items', 'pdc-base'),
                'not_found'          => __('No pdc items found.', 'pdc-base'),
                'not_found_in_trash' => __('No pdc items found in Trash.', 'pdc-base'),
                'all_items'          => __('All pdc items', 'pdc-base'),
                'archives'           => __('PDC items archives', 'pdc-base'),
                'attributes'         => __('PDC item attributes', 'pdc-base'),
                'insert_into_item'   => __('Insert into pdc item', 'pdc-base'),
                'featured_image'     => __('Featured image', 'pdc-base'),
                'set_featured_image' => __('Set featured image', 'pdc-base'),
                'menu_name'          => __('PDC items', 'pdc-base'),
                'name_admin_bar'     => __('PDC items', 'pdc-base'),
                'parent_item_colon'  => __('Parent pdc items:', 'pdc-base'),
            ],
            # Add the post type to the site's main RSS feed:
            'show_in_feed'  => false,

            # Show all posts on the post type archive:
            'archive'       => [
                'nopaging' => true,
            ],
            'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions'],
            'admin_cols'    => [
                'type' => [
                    'taxonomy' => 'pdc-type',
                ],
            ],

            # Add a dropdown filter to the admin screen:
            'admin_filters' => [
                'type' => [
                    'taxonomy' => 'pdc-type',
                ],
            ],
        ],
        'names' => [
            # Override the base names used for labels:
            'singular' => __('PDC item', 'pdc-base'),
            'plural'   => __('PDC items', 'pdc-base'),
            'slug'     => 'pdc-item',
        ],
    ],
    'pdc-category'    => [
        'args'  => [

            # Add the post type to the site's main RSS feed:
            'show_in_feed' => false,

            # Show all posts on the post type archive:
            'archive'      => [
                'nopaging' => true,
            ],
            'supports'     => ['title', 'editor', 'excerpt', 'revisions', 'thumbnail'],
        ],
        'names' => [

            # Override the base names used for labels:
            'singular' => __('PDC theme', 'pdc-base'),
            'plural'   => __('PDC themes', 'pdc-base'),
            'slug'     => 'pdc-thema',
        ],
    ],
    'pdc-subcategory' => [
        'args'  => [
            # Add the post type to the site's main RSS feed:
            'show_in_feed' => false,

            # Show all posts on the post type archive:
            'archive'      => [
                'nopaging' => true,
            ],
            'supports'     => ['title', 'editor', 'excerpt', 'revisions', 'thumbnail', 'page-attributes'],
            'hierarchical' => true,
        ],
        'names' => [

            # Override the base names used for labels:
            'singular' => __('PDC subtheme', 'pdc-base'),
            'plural'   => __('PDC subthemes', 'pdc-base'),
            'slug'     => 'pdc-subthema',

        ],
    ],
];
