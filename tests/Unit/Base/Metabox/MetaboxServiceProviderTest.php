<?php

namespace OWC\PDC\Base\Metabox;

use Mockery as m;
use OWC\PDC\Base\Config;
use OWC\PDC\Base\Foundation\Loader;
use OWC\PDC\Base\Foundation\Plugin;
use OWC\PDC\Base\Tests\Unit\TestCase;
use OWC\PDC\Base\Metabox\Handlers\UPLResourceHandler;

class MetaboxServiceProviderTest extends TestCase
{
    public function setUp(): void
    {
        \WP_Mock::setUp();

        \WP_Mock::userFunction('wp_parse_args', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_pdc_item_slug'             => '',
                '_owc_setting_include_theme_in_portal_url'      => 0,
                '_owc_setting_include_subtheme_in_portal_url'   => 0,
                '_owc_setting_pdc-group'                        => 0,
                '_owc_setting_identifications'                  => 1,
                '_owc_setting_use_escape_element'               => 1,
                '_owc_upl_terms_url'                            => 'https://standaarden.overheid.nl/owms/oquery/UPL-gemeente.json'
            ]
        ]);

        \WP_Mock::userFunction('get_option', [
            'return' => [
                '_owc_setting_portal_url'                       => '',
                '_owc_setting_portal_pdc_item_slug'             => '',
                '_owc_setting_include_theme_in_portal_url'      => 0,
                '_owc_setting_include_subtheme_in_portal_url'   => 0,
                '_owc_setting_pdc-group'                        => 0,
                '_owc_setting_identifications'                  => 1,
                '_owc_setting_use_escape_element'               => 1,
                '_owc_upl_terms_url'                            => 'https://standaarden.overheid.nl/owms/oquery/UPL-gemeente.json'
            ]
        ]);
    }

    public function tearDown(): void
    {
        \WP_Mock::tearDown();
    }

    /** @test */
    public function check_registration_of_metaboxes()
    {
        $config = m::mock(Config::class);
        $plugin = m::mock(Plugin::class);

        $plugin->config = $config;
        $plugin->loader = m::mock(Loader::class);

        $service         = new MetaboxServiceProvider($plugin);
        $resourceHandler = UPLResourceHandler::class;

        $plugin->loader->shouldReceive('addFilter')->withArgs([
            'rwmb_meta_boxes',
            $service,
            'registerMetaboxes',
            10,
            1
        ])->once();

        $plugin->loader->shouldReceive('addAction')->withArgs([
            'updated_post_meta',
            $resourceHandler,
            'handleUpdatedMeta',
            10,
            4
        ])->once();

        \WP_Mock::userFunction('get_transient')
            ->withArgs(['uplOptions'])
            ->twice()
            ->andReturn(false);

        \WP_Mock::userFunction('wp_remote_get')
            ->withArgs(['https://standaarden.overheid.nl/owms/oquery/UPL-gemeente.json'])
            ->twice()
            ->andReturn(['{
                "head" : {
                  "vars" : [
                    "UniformeProductnaam",
                    "URI",
                    "Burger",
                    "Bedrijf",
                    "Dienstenwet",
                    "SDG",
                    "Grondslaglabel",
                    "Grondslaglink"
                  ]
                },
                "results" : {
                  "bindings" : [
                    {
                      "UniformeProductnaam" : {
                        "xml:lang" : "nl",
                        "type" : "literal",
                        "value" : "UPL-naam nog niet beschikbaar"
                      },
                      "URI" : {
                        "type" : "uri",
                        "value" : "http://standaarden.overheid.nl/owms/terms/UPL-naam_nog_niet_beschikbaar"
                      }
                    },
                    {
                      "Burger" : {
                        "type" : "literal",
                        "value" : "X"
                      },
                      "UniformeProductnaam" : {
                        "xml:lang" : "nl",
                        "type" : "literal",
                        "value" : "aanleunwoning"
                      },
                      "URI" : {
                        "type" : "uri",
                        "value" : "http://standaarden.overheid.nl/owms/terms/aanleunwoning"
                      }
                    },
                    {
                      "Burger" : {
                        "type" : "literal",
                        "value" : "X"
                      },
                      "Grondslaglink" : {
                        "type" : "uri",
                        "value" : "https://wetten.overheid.nl/jci1.3:c:BWBR0005645&titeldeel=III&hoofdstuk=VIII&Paragraaf=4&artikel=122"
                      },
                      "UniformeProductnaam" : {
                        "xml:lang" : "nl",
                        "type" : "literal",
                        "value" : "aanschrijving"
                      },
                      "Grondslaglabel" : {
                        "xml:lang" : "nl",
                        "type" : "literal",
                        "value" : "Artikel 122 Provinciewet"
                      },
                      "URI" : {
                        "type" : "uri",
                        "value" : "http://standaarden.overheid.nl/owms/terms/aanschrijving"
                      },
                      "Bedrijf" : {
                        "type" : "literal",
                        "value" : "X"
                      }
                    }]}}']);

        \WP_Mock::userFunction('is_wp_error')
            ->twice()
            ->andReturn(false);

        \WP_Mock::userFunction('set_transient')
            ->withArgs(['uplOptions', [], 86400])
            ->twice()
            ->andReturn();

        $service->register();

        $configMetaboxes = [
            'base' => [
                'id'     => 'metadata',
                'fields' => [
                    'general' => [
                        'testfield_noid' => [
                            'type' => 'heading'
                        ],
                        'testfield1'     => [
                            'id' => 'metabox_id1'
                        ],
                        'testfield2'     => [
                            'id' => 'metabox_id2'
                        ]
                    ]
                ]
            ],
            'identifications' => [
                'id'     => 'identifications',
                'fields' => [
                    'general' => [
                        'testfield_noid' => [
                            'type' => 'heading'
                        ],
                        'testfield1'     => [
                            'id' => 'metabox_id1'
                        ],
                        'testfield2'     => [
                            'id' => 'metabox_id2'
                        ]
                    ]
                ]
            ],
            'escape_element' => [
                'id'     => 'escape_element',
                'fields' => [
                    'general' => [
                        'testfield_noid' => [
                            'type' => 'heading'
                        ],
                        'testfield1'     => [
                            'id' => 'metabox_id1'
                        ],
                        'testfield2'     => [
                            'id' => 'metabox_id2'
                        ]
                    ]
                ]
            ]
        ];

        $prefix = MetaboxServiceProvider::PREFIX;

        $expectedMetaboxes = [
            0 => [
                'id'     => 'metadata',
                'fields' => [
                    [
                        'type' => 'heading'
                    ],
                    [
                        'id' => $prefix . 'metabox_id1'
                    ],
                    [
                        'id' => $prefix . 'metabox_id2'
                    ]
                ]
            ],
            1 => [
                'id'     => 'identifications',
                'fields' => [
                    [
                        'type' => 'heading'
                    ],
                    [
                        'id' => $prefix . 'metabox_id1'
                    ],
                    [
                        'id' => $prefix . 'metabox_id2'
                    ]
                ]
            ],
            2 => [
                'id'     => 'escape_element',
                'fields' => [
                    [
                        'type' => 'heading'
                    ],
                    [
                        'id' => $prefix . 'metabox_id1'
                    ],
                    [
                        'id' => $prefix . 'metabox_id2'
                    ]
                ]
            ]
        ];

        $config->shouldReceive('get')->with('metaboxes')->once()->andReturn($configMetaboxes);
        $config->shouldReceive('get')->with('identifications_metaboxes')->once()->andReturn($configMetaboxes);
        $config->shouldReceive('get')->with('escape_element_metabox')->once()->andReturn($configMetaboxes);

        //test for filter being called
        \WP_Mock::expectFilter('owc/pdc-base/before-register-metaboxes', $expectedMetaboxes);

        $this->assertEquals($expectedMetaboxes, $service->registerMetaboxes([]));

        $existingMetaboxes = [
            0 => [
                'id'     => 'existing_metadata',
                'fields' => [
                    [
                        'type' => 'existing_heading'
                    ],
                    [
                        'id' => $prefix . 'existing_metabox_id1'
                    ],
                    [
                        'id' => $prefix . 'existing_metabox_id2'
                    ]
                ]
            ]
        ];

        $expectedMetaboxesAfterMerge = [
            0 => [
                'id'     => 'existing_metadata',
                'fields' => [
                    [
                        'type' => 'existing_heading'
                    ],
                    [
                        'id' => $prefix . 'existing_metabox_id1'
                    ],
                    [
                        'id' => $prefix . 'existing_metabox_id2'
                    ]
                ]
            ],
            1 => [
                'id'     => 'metadata',
                'fields' => [
                    [
                        'type' => 'heading'
                    ],
                    [
                        'id' => $prefix . 'metabox_id1'
                    ],
                    [
                        'id' => $prefix . 'metabox_id2'
                    ]
                ]
            ],
            2 => [
                'id'     => 'identifications',
                'fields' => [
                    [
                        'type' => 'heading'
                    ],
                    [
                        'id' => $prefix . 'metabox_id1'
                    ],
                    [
                        'id' => $prefix . 'metabox_id2'
                    ]
                ]
            ],
            3 => [
                'id'     => 'escape_element',
                'fields' => [
                    [
                        'type' => 'heading'
                    ],
                    [
                        'id' => $prefix . 'metabox_id1'
                    ],
                    [
                        'id' => $prefix . 'metabox_id2'
                    ]
                ]
            ]
        ];

        $config->shouldReceive('get')->with('metaboxes')->once()->andReturn($configMetaboxes);
        $config->shouldReceive('get')->with('identifications_metaboxes')->once()->andReturn($configMetaboxes);
        $config->shouldReceive('get')->with('escape_element_metabox')->once()->andReturn($configMetaboxes);

        $this->assertEquals($expectedMetaboxesAfterMerge, $service->registerMetaboxes($existingMetaboxes));
    }
}
