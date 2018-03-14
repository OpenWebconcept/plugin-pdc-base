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

        /**
         * Providers specific to the admin.
         */
        'admin'    => [

        ]

    ],

];