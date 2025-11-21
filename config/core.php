<?php

return [

    /**
     * Service Providers.
     */
    'providers' => [
        /** Global providers */
        OWC\PDC\Base\Settings\SettingsServiceProvider::class,
        OWC\PDC\Base\PostType\PostTypeServiceProvider::class,
        OWC\PDC\Base\Taxonomy\TaxonomyServiceProvider::class,
        OWC\PDC\Base\PostsToPosts\PostsToPostsServiceProvider::class,
        OWC\PDC\Base\Metabox\MetaboxServiceProvider::class,
        OWC\PDC\Base\RestAPI\RestAPIServiceProvider::class,
        OWC\PDC\Base\Template\TemplateServiceProvider::class,
        OWC\PDC\Base\Admin\AdminServiceProvider::class,
        OWC\PDC\Base\Varnish\VarnishServiceProvider::class,
        OWC\PDC\Base\UPL\UPLServiceProvider::class,

        /** Providers specific to the admin */
        'admin' => [
			OWC\PDC\Base\TinyMce\TinyMceServiceProvider::class
		]
    ],

    /**
     * Dependencies upon which the plugin relies.
     *
     * Required: type, label
     * Optional: message
     *
     * Type: plugin
     * - Required: file
     * - Optional: version, alternatives
     *
     * Type: class
     * - Required: name
     *
     * Type: function
     * - Required: name
     */
    'dependencies' => [
        [
            'type' => 'plugin',
            'label' => 'RWMB Metabox',
            'file' => 'meta-box/meta-box.php',
            'alternatives' => [
                'meta-box/meta-box.php',           // Free Meta Box
                'meta-box-aio/meta-box-aio.php'   // Meta Box AIO
            ],
        ],        [
            'type' => 'plugin',
            'label' => 'RWMB Metabox Group',
            'file' => 'meta-box-group/meta-box-group.php',
            'alternatives' => [
                'meta-box-group/meta-box-group.php', // Free Meta Box Group extension
                'meta-box-aio/meta-box-aio.php'      // Meta Box AIO (includes Group functionality)
            ]
        ],
        [
            'type' => 'function',
            'label' => '<a href="https://github.com/johnbillion/extended-cpts" target="_blank">Extended CPT library</a>',
            'name' => 'register_extended_post_type'
        ],
    ]
];
