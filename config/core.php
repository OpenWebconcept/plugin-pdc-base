<?php

return [

    /**
     * Service Providers.
     */
    'providers' => [
        /**
         * Global providers.
         */
	    OWC_PDC_Base\Core\PostType\PostTypeServiceProvider::class,
	    OWC_PDC_Base\Core\Taxonomy\TaxonomyServiceProvider::class,
	    OWC_PDC_Base\Core\PostsToPosts\PostsToPostsServiceProvider::class,
	    OWC_PDC_Base\Core\Metabox\MetaboxServiceProvider::class,
	    OWC_PDC_Base\Core\RestApi\RestApiServiceProvider::class,
        /**
         * Providers specific to the admin.
         */
        'admin'    => [

        ]

    ],

];