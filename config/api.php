<?php

return [

    'item' => [
        /**
         * Custom field creators.
         *
         * [
         *      'creator'   => CreatesFields::class,
         *      'condition' => \Closure
         * ]
         */
        'fields' => [
            'taxonomies'  => OWC\PDC\Base\RestAPI\ItemFields\TaxonomyField::class,
            'connected'   => OWC\PDC\Base\RestAPI\ItemFields\ConnectedField::class,
            'image'       => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
            'appointment' => OWC\PDC\Base\RestAPI\ItemFields\AppointmentField::class
        ]
    ]

];