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
            'taxonomies' => OWC\PDC\Base\RestAPI\ItemFields\TaxonomyField::class,
            'connected'  => OWC\PDC\Base\RestAPI\ItemFields\ConnectedField::class
        ]
    ]

];