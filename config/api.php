<?php

return [

    'models' => [

        'item'     => [
            /**
             * Custom field creators.
             *
             * [
             *      'creator'   => CreatesFields::class,
             *      'condition' => \Closure
             * ]
             */
            'fields' => [
                'appointment'       => OWC\PDC\Base\RestAPI\ItemFields\AppointmentField::class,
                'connected'         => OWC\PDC\Base\RestAPI\ItemFields\ConnectedField::class,
                'downloads'         => OWC\PDC\Base\RestAPI\ItemFields\DownloadsField::class,
                'faq'               => OWC\PDC\Base\RestAPI\ItemFields\FAQField::class,
                'forms'             => OWC\PDC\Base\RestAPI\ItemFields\FormsField::class,
                'image'             => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                'links'             => OWC\PDC\Base\RestAPI\ItemFields\LinksField::class,
                'synonyms'          => OWC\PDC\Base\RestAPI\ItemFields\SynonymsField::class,
                'taxonomies'        => OWC\PDC\Base\RestAPI\ItemFields\TaxonomyField::class,
                'title_alternative' => OWC\PDC\Base\RestAPI\ItemFields\TitleAlternativeField::class,
            ],
        ],

        'subthema' => [
            'fields' => [
                'items'  => OWC\PDC\Base\RestAPI\ThemaFields\ItemsField::class,
                'image'  => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                'themes' => OWC\PDC\Base\RestAPI\ThemaFields\ThemaField::class,
            ],
        ],

        'thema'    => [
            'fields' => [
                'items'     => OWC\PDC\Base\RestAPI\ThemaFields\ItemsField::class,
                'image'  => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                'subthemes' => OWC\PDC\Base\RestAPI\ThemaFields\ThemaField::class,
            ],
        ],
    ],
];
