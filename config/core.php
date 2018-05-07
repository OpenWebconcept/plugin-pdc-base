<?php

return [

    /**
     * Service Providers.
     */
    'providers' => [
        /**
         * Global providers.
         */
	    OWC\PDC\Base\Settings\SettingsServiceProvider::class,
	    OWC\PDC\Base\PostType\PostTypeServiceProvider::class,
	    OWC\PDC\Base\Taxonomy\TaxonomyServiceProvider::class,
	    OWC\PDC\Base\PostsToPosts\PostsToPostsServiceProvider::class,
	    OWC\PDC\Base\Metabox\MetaboxServiceProvider::class,
	    OWC\PDC\Base\RestApi\RestApiServiceProvider::class,
	    OWC\PDC\Base\Template\TemplateServiceProvider::class,
	    /**
         * Providers specific to the admin.
         */
        'admin'    => [
	        OWC\PDC\Base\Admin\InterfaceServiceProvider::class
        ]

    ],

];