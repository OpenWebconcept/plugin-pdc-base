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

            # Show post type in rest api
            'show_in_rest'  => true,

            # Show all posts on the post type archive:
            'archive'       => [
                'nopaging' => true,
            ],
            'supports'      => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'author', 'custom-fields'],
            'admin_cols'    => [
                'author' => [
                    'title'      => __('Author', 'pdc-base'),
                ],
                'aspect'               => [
                    'title'    => __('Aspect', 'pdc-base'),
                    'taxonomy' => 'pdc-aspect',
                    'sortable' => false,
                ],
                'item_to_item'         => [
                    'connection' => 'pdc-item_to_pdc-item',
                ],
                'item_to_category'     => [
                    'connection' => 'pdc-item_to_pdc-category',
                ],
                'item_to_sub_category' => [
                    'connection' =>
                    'pdc-item_to_pdc-subcategory',
                ],
                'type'                 => [
                    'title'    => __('Type', 'pdc-base'),
                    'taxonomy' => 'pdc-type',
                    'sortable' => false,
                ],
                'published'            => [
                    'title'       => __('Published', 'pdc-base'),
                    'post_field'  => 'post_date',
                    'date_format' => get_option('date_format') . ', ' . get_option('time_format'),
                ],
            ],

            # Add a dropdown filter to the admin screen:
            'admin_filters' => [
                'type'   => [
                    'taxonomy' => 'pdc-type',
                ],
                'aspect' => [
                    'taxonomy' => 'pdc-aspect',
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
            'labels'       => [
                'name'               => __('PDC theme', 'pdc-base'),
                'singular_name'      => __('PDC theme', 'pdc-base'),
                'add_new'            => __('Add new pdc theme', 'pdc-base'),
                'add_new_item'       => __('Add new pdc theme', 'pdc-base'),
                'edit_item'          => __('Edit pdc theme', 'pdc-base'),
                'new_item'           => __('New pdc theme', 'pdc-base'),
                'view_item'          => __('View pdc theme', 'pdc-base'),
                'view_items'         => __('View pdc themes', 'pdc-base'),
                'search_items'       => __('Search pdc themes', 'pdc-base'),
                'not_found'          => __('No pdc themes found.', 'pdc-base'),
                'not_found_in_trash' => __('No pdc themes found in Trash.', 'pdc-base'),
                'all_items'          => __('All pdc themes', 'pdc-base'),
                'archives'           => __('PDC themes archives', 'pdc-base'),
                'attributes'         => __('PDC theme attributes', 'pdc-base'),
                'insert_into_item'   => __('Insert into pdc theme', 'pdc-base'),
                'featured_image'     => __('Featured image', 'pdc-base'),
                'set_featured_image' => __('Set featured image', 'pdc-base'),
                'menu_name'          => __('PDC themes', 'pdc-base'),
                'name_admin_bar'     => __('PDC themes', 'pdc-base'),
                'parent_item_colon'  => __('Parent pdc themes:', 'pdc-base'),
            ],

            # Add the post type to the site's main RSS feed:
            'show_in_feed' => false,

            # Show post type in rest api
            'show_in_rest'  => true,

            # Show all posts on the post type archive:
            'archive'      => [
                'nopaging' => true,
            ],
            'supports'     => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields'],
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
            'labels'       => [
                'name'               => __('PDC subtheme', 'pdc-base'),
                'singular_name'      => __('PDC subtheme', 'pdc-base'),
                'add_new'            => __('Add new pdc subtheme', 'pdc-base'),
                'add_new_item'       => __('Add new pdc subtheme', 'pdc-base'),
                'edit_item'          => __('Edit pdc subtheme', 'pdc-base'),
                'new_item'           => __('New pdc subtheme', 'pdc-base'),
                'view_item'          => __('View pdc subtheme', 'pdc-base'),
                'view_items'         => __('View pdc subthemes', 'pdc-base'),
                'search_items'       => __('Search pdc subthemes', 'pdc-base'),
                'not_found'          => __('No pdc subthemes found.', 'pdc-base'),
                'not_found_in_trash' => __('No pdc subthemes found in Trash.', 'pdc-base'),
                'all_items'          => __('All pdc subthemes', 'pdc-base'),
                'archives'           => __('PDC subthemes archives', 'pdc-base'),
                'attributes'         => __('PDC subtheme attributes', 'pdc-base'),
                'insert_into_item'   => __('Insert into pdc subtheme', 'pdc-base'),
                'featured_image'     => __('Featured image', 'pdc-base'),
                'set_featured_image' => __('Set featured image', 'pdc-base'),
                'menu_name'          => __('PDC subtheme', 'pdc-base'),
                'name_admin_bar'     => __('PDC subtheme', 'pdc-base'),
                'parent_item_colon'  => __('Parent pdc subthemes:', 'pdc-base'),
            ],
            # Add the post type to the site's main RSS feed:
            'show_in_feed' => false,

            # Show post type in rest api
            'show_in_rest'  => true,

            # Show all posts on the post type archive:
            'archive'      => [
                'nopaging' => true,
            ],
            'supports'     => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes', 'custom-fields'],
            'hierarchical' => true,
        ],
        'names' => [
            # Override the base names used for labels:
            'singular' => __('PDC subtheme', 'pdc-base'),
            'plural'   => __('PDC subthemes', 'pdc-base'),
            'slug'     => 'pdc-subthema',
        ],
    ],
    'pdc-group' => [
        'args'  => [
            'labels'       => [
                'name'               => __('PDC group', 'pdc-base'),
                'singular_name'      => __('PDC group', 'pdc-base'),
                'add_new'            => __('Add new pdc group', 'pdc-base'),
                'add_new_item'       => __('Add new pdc group', 'pdc-base'),
                'edit_item'          => __('Edit pdc group', 'pdc-base'),
                'new_item'           => __('New pdc group', 'pdc-base'),
                'view_item'          => __('View pdc group', 'pdc-base'),
                'view_items'         => __('View pdc groups', 'pdc-base'),
                'search_items'       => __('Search pdc groups', 'pdc-base'),
                'not_found'          => __('No pdc groups found.', 'pdc-base'),
                'not_found_in_trash' => __('No pdc groups found in Trash.', 'pdc-base'),
                'all_items'          => __('All pdc groups', 'pdc-base'),
                'archives'           => __('PDC groups archives', 'pdc-base'),
                'attributes'         => __('PDC group attributes', 'pdc-base'),
                'insert_into_item'   => __('Insert into pdc group', 'pdc-base'),
                'featured_image'     => __('Featured image', 'pdc-base'),
                'set_featured_image' => __('Set featured image', 'pdc-base'),
                'menu_name'          => __('PDC groups', 'pdc-base'),
                'name_admin_bar'     => __('PDC groups', 'pdc-base'),
                'parent_item_colon'  => __('Parent pdc groups:', 'pdc-base'),
            ],

            # Add the post type to the site's main RSS feed:
            'show_in_feed' => false,

            # Show post type in rest api
            'show_in_rest'  => true,

            # Show all posts on the post type archive:
            'archive'      => [
                'nopaging' => true,
            ],
            'supports'     => ['title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'custom-fields'],
        ],
        'names' => [
            # Override the base names used for labels:
            'singular' => __('PDC group', 'pdc-base'),
            'plural'   => __('PDC groups', 'pdc-base'),
            'slug'     => 'pdc-groep',
        ],
    ],
];
