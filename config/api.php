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
                'language' => OWC\PDC\Base\RestAPI\ItemFields\LanguageField::class,
                'appointment' => OWC\PDC\Base\RestAPI\ItemFields\AppointmentField::class,
                'portal_url' => OWC\PDC\Base\RestAPI\ItemFields\PortalURL::class,
                'date_modified' => OWC\PDC\Base\RestAPI\ItemFields\DateModified::class,
                'connected' => OWC\PDC\Base\RestAPI\ItemFields\ConnectedField::class,
                'downloads' => OWC\PDC\Base\RestAPI\ItemFields\DownloadsField::class,
                'faq' => OWC\PDC\Base\RestAPI\ItemFields\FAQField::class,
                'forms' => OWC\PDC\Base\RestAPI\ItemFields\FormsField::class,
                'image' => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                'links' => OWC\PDC\Base\RestAPI\ItemFields\LinksField::class,
                'synonyms' => OWC\PDC\Base\RestAPI\ItemFields\SynonymsField::class,
                'taxonomies' => OWC\PDC\Base\RestAPI\ItemFields\TaxonomyField::class,
                'title_alternative' => OWC\PDC\Base\RestAPI\ItemFields\TitleAlternativeField::class,
                'identifications' => OWC\PDC\Base\RestAPI\ItemFields\IdentificationsField::class,
                'escape_element' => OWC\PDC\Base\RestAPI\ItemFields\EscapeElementField::class,
                'seopress' => OWC\PDC\Base\RestAPI\ItemFields\SeoPress::class,
                'yoast' => OWC\PDC\Base\RestAPI\ItemFields\Yoast::class,
                'hide_feedback_form' => OWC\PDC\Base\RestAPI\SharedFields\HideFeedbackForm::class,
                'table_of_contents_is_active' => OWC\PDC\Base\RestAPI\ItemFields\TableOfContentsField::class
            ],
        ],
        'subthema' => [
            'fields' => [
                'icon' => OWC\PDC\Base\RestAPI\SharedFields\IconField::class,
                'items' => OWC\PDC\Base\RestAPI\SharedFields\ItemsField::class,
                'image' => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                'themes' => OWC\PDC\Base\RestAPI\ThemaFields\ThemaField::class,
                'groups' => OWC\PDC\Base\RestAPI\SubThemaFields\GroupField::class,
                'hide_feedback_form' => OWC\PDC\Base\RestAPI\SharedFields\HideFeedbackForm::class
            ],
        ],
        'group' => [
            'fields' => [
                'items' => OWC\PDC\Base\RestAPI\SharedFields\ItemsField::class,
                'image' => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                'themes' => OWC\PDC\Base\RestAPI\GroupFields\ThemaField::class,
                'subthemes' => OWC\PDC\Base\RestAPI\GroupFields\SubThemaField::class,
            ],
        ],
        'thema' => [
            'fields' => [
                'icon' => OWC\PDC\Base\RestAPI\SharedFields\IconField::class,
                'items' => OWC\PDC\Base\RestAPI\SharedFields\ItemsField::class,
                'image' => OWC\PDC\Base\RestAPI\ItemFields\FeaturedImageField::class,
                'subthemes' => OWC\PDC\Base\RestAPI\ThemaFields\ThemaField::class,
                'yoast' => OWC\PDC\Base\RestAPI\ItemFields\Yoast::class,
                'date_modified' => OWC\PDC\Base\RestAPI\ItemFields\DateModified::class,
                'hide_feedback_form' => OWC\PDC\Base\RestAPI\SharedFields\HideFeedbackForm::class,
                'tiles' => OWC\PDC\Base\RestAPI\ThemaFields\TilesField::class
            ],
        ],
    ],
];
