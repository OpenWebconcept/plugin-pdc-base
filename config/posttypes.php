<?php

return [

    /**
     * Examples of registering post types: http://johnbillion.com/extended-cpts/
     */
    'pdc-item'        => [
        'args'  => [

            # Add the post type to the site's main RSS feed:
            'show_in_feed'  => false,

            # Show all posts on the post type archive:
            'archive'       => [
                'nopaging' => true
            ],
            'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
            'admin_cols'    => [
                'type' => [
                    'taxonomy' => 'pdc-type'
                ]
            ],

            # Add a dropdown filter to the admin screen:
            'admin_filters' => [
                'type' => [
                    'taxonomy' => 'pdc-type'
                ]
            ],
        ],
        'names' => [

            # Override the base names used for labels:
            'singular' => _x('PDC item', 'Posttype definition', 'pdc-base'),
            'plural'   => _x('PDC items', 'Posttype definition', 'pdc-base'),
            'slug'     => 'pdc-item'
        ]
    ],
    'pdc-category'    => [
        'args'  => [

            # Add the post type to the site's main RSS feed:
            'show_in_feed' => false,

            # Show all posts on the post type archive:
            'archive'      => [
                'nopaging' => true
            ],
            'supports'     => [ 'title', 'editor', 'excerpt', 'revisions', 'thumbnail' ],
        ],
        'names' => [

            # Override the base names used for labels:
            'singular' => _x('PDC theme', 'Posttype definition', 'pdc-base'),
            'plural'   => _x('PDC themes', 'Posttype definition', 'pdc-base'),
            'slug'     => 'pdc-thema'
        ]
    ],
    'pdc-subcategory' => [
        'args'  => [
            # Add the post type to the site's main RSS feed:
            'show_in_feed' => false,

            # Show all posts on the post type archive:
            'archive'      => [
                'nopaging' => true
            ],
            'supports'     => [ 'title', 'editor', 'excerpt', 'revisions', 'thumbnail', 'page-attributes' ],
            'hierarchical' => true,
        ],
        'names' => [

            # Override the base names used for labels:
            'singular' => _x('PDC subtheme', 'Posttype definition', 'pdc-base'),
            'plural'   => _x('PDC subthemes', 'Posttype definition', 'pdc-base'),
            'slug'     => 'pdc-subthema'

        ]
    ]
];