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

        /**
         * Providers specific to the admin.
         */
        'admin'    => [

        ]

    ],

];