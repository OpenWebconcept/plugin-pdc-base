<?php

return [

    /**
             * Service Providers.
         */
    'providers'    => [
        /**
     * Global providers.
     */
        OWC\PDC\Base\Settings\SettingsServiceProvider::class,
        OWC\PDC\Base\PostType\PostTypeServiceProvider::class,
        OWC\PDC\Base\Taxonomy\TaxonomyServiceProvider::class,
        OWC\PDC\Base\PostsToPosts\PostsToPostsServiceProvider::class,
        OWC\PDC\Base\Metabox\MetaboxServiceProvider::class,
        OWC\PDC\Base\RestAPI\RestAPIServiceProvider::class,
        OWC\PDC\Base\Template\TemplateServiceProvider::class,
        OWC\PDC\Base\Admin\UPLServiceProvider::class,

        /**
         * Providers specific to the admin.
         */
        'admin' => [
            OWC\PDC\Base\Admin\InterfaceServiceProvider::class,
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
     * - Optional: version
     *
     * Type: class
     * - Required: name
     */
    'dependencies' => [
        [
            'type'    => 'plugin',
            'label'   => 'RWMB Metabox',
            'version' => '4.14.0',
            'file'    => 'meta-box/meta-box.php'
        ],
        [
            'type'  => 'class',
            'label' => '<a href="https://github.com/johnbillion/extended-cpts" target="_blank">Extended CPT library</a>',
            'name'  => 'Extended_CPT'
        ],
    ]

];
