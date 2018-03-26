<?php

return [

    /**
     * Service Providers.
     */
    'providers' => [
        /**
         * Global providers.
         */
	    OWC_PDC_Base\Core\Settings\SettingsServiceProvider::class,
	    OWC_PDC_Base\Core\PostType\PostTypeServiceProvider::class,
	    OWC_PDC_Base\Core\Taxonomy\TaxonomyServiceProvider::class,
	    OWC_PDC_Base\Core\PostsToPosts\PostsToPostsServiceProvider::class,
	    OWC_PDC_Base\Core\Metabox\MetaboxServiceProvider::class,
	    OWC_PDC_Base\Core\RestApi\RestApiServiceProvider::class,
	    OWC_PDC_Base\Core\Template\TemplateServiceProvider::class,
	    /**
         * Providers specific to the admin.
         */
        'admin'    => [
	        OWC_PDC_Base\Core\Admin\InterfaceServiceProvider::class
        ]

    ],

];