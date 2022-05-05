<?php

return [
    'models' => [
        'item' => [
            /**
             * Custom field creators.
             *
             * [
             *   'creator'   => CreatesFields::class,
             *   'condition' => \Closure
             * ]
             */
            'fields' => [
                'language'          => OWC\PDC\Base\RestAPI\ItemFields\LanguageField::class,
                'appointment'       => OWC\PDC\Base\RestAPI\ItemFields\AppointmentField::class,
                'portal_url'        => OWC\PDC\Base\RestAPI\ItemFields\PortalURL::class,
                'date_modified'     => OWC\PDC\Base\RestAPI\ItemFields\DateModified::class,
                'connected'         => OWC\PDC\Base\RestAPI\ItemFields\ConnectedField::class,
                'downloads'         => OWC\PDC\Base\RestAPI\ItemFields\DownloadsField::class,
                'faq'               => OWC\PDC\Base\RestAPI\ItemFields\FAQField::class,
                'forms'             => OWC\PDC\Base\RestAPI\ItemFields\FormsField::class,
                'image'             => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                'links'             => OWC\PDC\Base\RestAPI\ItemFields\LinksField::class,
                'synonyms'          => OWC\PDC\Base\RestAPI\ItemFields\SynonymsField::class,
                'taxonomies'        => OWC\PDC\Base\RestAPI\ItemFields\TaxonomyField::class,
                'title_alternative' => OWC\PDC\Base\RestAPI\ItemFields\TitleAlternativeField::class,
                'identifications'   => OWC\PDC\Base\RestAPI\ItemFields\IdentificationsField::class,
                'escape_element'    => OWC\PDC\Base\RestAPI\ItemFields\EscapeElementField::class,
            ],
        ],
        'subthema' => [
            'fields' => [
                'icon'   => OWC\PDC\Base\RestAPI\SharedFields\IconField::class,
                'items'  => OWC\PDC\Base\RestAPI\SharedFields\ItemsField::class,
                'image'  => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                'themes' => OWC\PDC\Base\RestAPI\ThemaFields\ThemaField::class,
                'groups' => OWC\PDC\Base\RestAPI\SubThemaFields\GroupField::class,
            ],
        ],
        'group' => [
            'fields' => [
                'items'     => OWC\PDC\Base\RestAPI\SharedFields\ItemsField::class,
                'image'     => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                'themes'    => OWC\PDC\Base\RestAPI\GroupFields\ThemaField::class,
                'subthemes' => OWC\PDC\Base\RestAPI\GroupFields\SubThemaField::class,
            ],
        ],
        'thema' => [
            'fields' => [
                'icon'      => OWC\PDC\Base\RestAPI\SharedFields\IconField::class,
                'items'     => OWC\PDC\Base\RestAPI\SharedFields\ItemsField::class,
                'image'     => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                'subthemes' => OWC\PDC\Base\RestAPI\ThemaFields\ThemaField::class,
            ],
        ],
    ],
];
